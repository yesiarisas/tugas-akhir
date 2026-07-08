<?php

namespace App\Admin\Controllers;

use App\Models\Anggota;
use App\Models\Pembayaran;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PembayaranController extends AdminController
{
    /**
     * GRID (HALAMAN UTAMA - BERSIH)
     */
   /**
     * GRID (HALAMAN UTAMA - BERSIH)
     */
    protected function grid()
    {
        return \Dcat\Admin\Grid::make(new \App\Models\Anggota(), function ($grid) {

            $grid->column('id')->sortable();
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

            // 🔥 SOLUSI: Menggunakan Quick Search langsung di header list
            // Kotak pencarian otomatis muncul di samping tombol Refresh/Filter
            $grid->quickSearch('nama')->placeholder('Cari nama...');

            // Nonaktifkan filter bawaan jika sudah memakai quickSearch agar tidak double
            $grid->disableFilter(); 

            // Disable fitur bawaan yang tidak diperlukan
            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->disableViewButton();
            $grid->disableDeleteButton();
        });
    }

    /**
     * FORM INPUT PEMBAYARAN
     */
    protected function form()
    {
        return Form::make(new Pembayaran(), function (Form $form) {

            $form->display('id');

            // Ambil ID Anggota dari parameter URL (?anggota_id=xx)
            $anggotaId = request('anggota_id');
            $namaAnggota = '-';
            
            if ($anggotaId) {
                $anggota = Anggota::find($anggotaId);
                $namaAnggota = $anggota ? $anggota->nama : '-';
            }

            // Nama dibuat paten (hanya tampil tekstual)
            $form->display('nama_anggota', 'Nama')->default($namaAnggota);
            
            // ID asli dikirim lewat hidden field agar tersimpan ke database
            $form->hidden('anggota_id')->default($anggotaId);

            // Kolom Tanggal Bayar
            $form->date('tanggal_bayar')
                ->default(date('Y-m-d'))
                ->required();

            // Pilihan Jenis Pembayaran
            $form->select('jenis', 'Jenis')
                ->options([
                    'harian' => 'Harian',
                    'mingguan' => 'Mingguan',
                    'bulanan' => 'Bulanan',
                ])
                ->required();

            // Field periode menggunakan readOnly() agar tidak bisa dimanipulasi user
            $form->text('periode', 'Periode')
                ->required()
                ->placeholder('Otomatis terisi berdasarkan Tanggal & Jenis')
                ->readOnly(); 

            $form->currency('nominal')
                ->symbol('Rp ')
                ->required();

            $form->radio('status')
                ->options([
                    'lunas' => 'Lunas',
                    'belum' => 'Belum',
                ])
                ->default('lunas');

            $form->disableDeleteButton();

            // 🔥 FITUR FOOTER: Menghilangkan tombol reset dan semua checkbox, menyisakan tombol Submit saja
            $form->footer(function ($footer) {
                $footer->disableReset();          // Hilangkan tombol Reset
                $footer->disableViewCheck();      // Hilangkan checkbox View
                $footer->disableEditingCheck();   // Hilangkan checkbox Continue Editing
                $footer->disableCreatingCheck();  // Hilangkan checkbox Continue Creating
            });

            // 1. HOOK SAVING: Memastikan text periode ikut tersimpan ke database saat submit
            $form->saving(function (Form $form) {
                $jenis = $form->jenis;
                $tanggalInput = $form->tanggal_bayar ?? date('Y-m-d');
                
                $carbon = \Carbon\Carbon::parse($tanggalInput);
                $text = '-';

                if ($jenis == 'harian') {
                    $text = 'Harian (' . $carbon->translatedFormat('d-m-Y') . ')';
                } elseif ($jenis == 'mingguan') {
                    $text = 'Minggu ke-' . $carbon->weekOfMonth . ' (' . $carbon->translatedFormat('F Y') . ')';
                } elseif ($jenis == 'bulanan') {
                    $text = $carbon->translatedFormat('F Y');
                }

                $form->input('periode', $text);
            });

            // 2. JAVASCRIPT: Mengubah teks periode secara realtime di browser saat pilihan Jenis diganti
            \Dcat\Admin\Admin::script(<<<JS
                $(document).off('change', 'select[name="jenis"], input[name="tanggal_bayar"]').on('change', 'select[name="jenis"], input[name="tanggal_bayar"]', function () {
                    var jenis = $('select[name="jenis"]').val();
                    var tanggal = $('input[name="tanggal_bayar"]').val();
                    
                    if (!jenis || !tanggal) return;

                    $.ajax({
                        url: '/admin/pembayaran/generate-periode',
                        type: 'GET',
                        data: { q: jenis, tanggal_bayar: tanggal },
                        success: function (data) {
                            if (data && data.text) {
                                $('input[name="periode"]').val(data.text);
                            }
                        }
                    });
                });
            JS);
        });
    }

    /**
     * API UNTUK GENERATE PERIODE OTOMATIS (DI AKSES OLEH AJAX)
     */
    public function generatePeriode(Request $request)
    {
        $jenis = $request->get('q'); 
        $tanggalInput = $request->get('tanggal_bayar') ?? date('Y-m-d');
        
        $carbon = Carbon::parse($tanggalInput);
        $text = '-';

        if ($jenis == 'harian') {
            $text = 'Harian (' . $carbon->translatedFormat('d-m-Y') . ')';
        } elseif ($jenis == 'mingguan') {
            $text = 'Minggu ke-' . $carbon->weekOfMonth . ' (' . $carbon->translatedFormat('F Y') . ')';
        } elseif ($jenis == 'bulanan') {
            $text = $carbon->translatedFormat('F Y');
        }

        return response()->json([
            'id'   => $text,
            'text' => $text
        ]);
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
            $grid->disableDeleteButton();
            
            $grid->tools(function ($tools) use ($id) {
                $tools->append(
                    "<a href='/admin/pembayaran/pdf/$id' target='_blank' class='btn btn-sm btn-success'>Print PDF</a>"
                );
            });
        });
    }

    /**
     * CETAK PDF
     */
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