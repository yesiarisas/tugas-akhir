<?php

namespace App\Admin\Controllers;

use App\Models\Anggota;
use App\Models\Pembayaran;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Barryvdh\DomPDF\Facade\Pdf;


class PembayaranController extends AdminController
{
    /**
     * GRID (HALAMAN UTAMA - BERSIH)
     */
   protected function grid()
{
    return \Dcat\Admin\Grid::make(new \App\Models\Anggota(), function ($grid) {

        $grid->column('id');
        $grid->column('nama', 'Nama');

        // 🔥 PERIODE TERAKHIR
        $grid->column('periode', 'Periode')
            ->display(function () {

                $data = \App\Models\Pembayaran::where('anggota_id', $this->id)
                    ->latest()
                    ->first();

                return $data ? $data->periode : '-';
            });

        // 🔥 TANGGAL TERAKHIR
        $grid->column('tanggal', 'Tanggal')
            ->display(function () {

                $data = \App\Models\Pembayaran::where('anggota_id', $this->id)
                    ->latest()
                    ->first();

                return $data ? $data->tanggal_bayar : '-';
            });

        // 🔥 AKSI
        $grid->actions(function ($actions) {

            $id = $actions->getKey();

            $actions->append(
                "<a href='/admin/pembayaran/create?anggota_id=$id' class='btn btn-sm btn-primary'>Bayar</a>"
            );

            $actions->append(
                "<a href='/admin/pembayaran/riwayat/$id' class='btn btn-sm btn-info'>Riwayat</a>"
            );
        });

        $grid->disableCreateButton();
        $grid->disableEditButton();
        $grid->disableViewButton();
    });
}

    /**
     * FORM INPUT PEMBAYARAN
     */
    protected function form()
    {
        return Form::make(new Pembayaran(), function (Form $form) {

            $form->display('id');

            $form->select('anggota_id', 'Nama')
                ->options(Anggota::pluck('nama','id'))
                ->default(request('anggota_id'))
                ->required();

            $form->select('jenis', 'Jenis')
                ->options([
                    'harian' => 'Harian',
                    'mingguan' => 'Mingguan',
                    'bulanan' => 'Bulanan',
                ]);

            $form->text('periode')
                ->help('Contoh: Minggu ke-1 / April 2026');

            $form->currency('nominal')
                ->symbol('Rp ')
                ->required();

            $form->date('tanggal_bayar')
                ->default(date('Y-m-d'))
                ->required();

            // status tetap disimpan di DB (untuk riwayat)
            $form->radio('status')
                ->options([
                    'lunas' => 'Lunas',
                    'belum' => 'Belum',
                ])
                ->default('lunas');
        });
    }

    /**
     * RIWAYAT PER ANGGOTA
     */
    public function riwayat($id)
    {
        return Grid::make(new Pembayaran(), function (Grid $grid) use ($id) {

            $grid->model()->where('anggota_id', $id);

            $grid->column('tanggal_bayar', 'Tanggal');
            $grid->column('jenis', 'Jenis');
            $grid->column('periode', 'Periode');

            $grid->column('nominal', 'Nominal')
                ->display(function ($value) {
                    return 'Rp ' . number_format($value, 0, ',', '.');
                });

            $grid->column('status')
                ->label([
                    'lunas' => 'success',
                    'belum' => 'danger',
                ]);

            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->disableViewButton();
            $grid->tools(function ($tools) use ($id) {
             $tools->append(
        "<a href='/admin/pembayaran/pdf/$id' target='_blank' class='btn btn-sm btn-success'>Print PDF</a>"
    );
});
        });
        
    }
    public function pdf($id)
{
    $anggota = \App\Models\Anggota::findOrFail($id);

    $data = \App\Models\Pembayaran::where('anggota_id', $id)->get();

    $pdf = Pdf::loadView('pdf.pembayaran', [
        'anggota' => $anggota,
        'data' => $data
    ]);

    return $pdf->stream('riwayat-pembayaran.pdf');
}
}