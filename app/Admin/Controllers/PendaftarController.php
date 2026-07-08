<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Pendaftar;
use App\Models\KategoriLatihan;
use App\Models\Anggota;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PendaftarController extends AdminController
{
    /**
     * GRID - HALAMAN DAFTAR UTAMA
     */
    protected function grid()
    {
        return Grid::make(new Pendaftar(), function (Grid $grid) {

            $grid->column('id')->sortable();

            $grid->column('nama_pendaftar', 'Nama');

            $grid->column('tanggal_lahir', 'Tanggal Lahir');

            $grid->column('no_hp', 'No HP');

            $grid->column('tanggal_daftar', 'Tanggal Daftar');

            // PERBAIKAN UTAMA: Mengubah kolom status menjadi tombol pilihan inline dropdown
            $grid->column('status', 'Status')
                ->select([
                    'menunggu' => 'Menunggu',
                    'diterima' => 'Diterima',
                    'ditolak'  => 'Ditolak',
                ]);

            $grid->column('created_at', 'Dibuat');

            $grid->quickSearch('nama_pendaftar', 'no_hp');

            $grid->filter(function ($filter) {
                $filter->like('nama_pendaftar', 'Nama');
                $filter->equal('status')->select([
                    'menunggu' => 'Menunggu',
                    'diterima' => 'Diterima',
                    'ditolak'  => 'Ditolak',
                ]);
            });

            // Sembunyikan tombol Create (Tambah Data) di kanan atas
            $grid->disableCreateButton();

            // Membatasi menu Aksi (Titik Tiga) agar HANYA menampilkan SHOW saja
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableEdit();   // Menghilangkan tombol Edit
                $actions->disableDelete(); // Menghilangkan tombol Delete
            });

            $grid->model()->orderBy('id', 'desc');
        });
    }

    /**
     * DETAIL - HALAMAN LIHAT DATA (SHOW)
     */
    protected function detail($id)
    {
        return Show::make($id, new Pendaftar(), function (Show $show) {
            
            // Sembunyikan tombol Edit & Delete di dalam halaman detail data
            $show->panel()->tools(function (Show\Tools $tools) {
                $tools->disableEdit();
                $tools->disableDelete();
            });

            $show->field('id');
            $show->field('nama_pendaftar', 'Nama');
            $show->field('tanggal_lahir', 'Tanggal Lahir');
            $show->field('no_hp', 'No HP');
            $show->field('alamat', 'Alamat');
            $show->field('tanggal_daftar', 'Tanggal Daftar');
            $show->field('status', 'Status');
            $show->field('catatan_admin', 'Catatan Admin');
            $show->field('created_at', 'Dibuat');
            $show->field('updated_at', 'Diupdate');
        });
    }

    /**
     * FORM - JANGAN DIHAPUS
     * Dcat Admin memerlukan blueprint di method form() ini 
     * untuk memproses update data saat Anda mengubah pilihan status di halaman Grid.
     */
    protected function form()
    {
        return Form::make(new Pendaftar(), function (Form $form) {

            $form->display('id');

            /*
            |--------------------------------------------------------------------------
            | DATA PENDAFTAR
            |--------------------------------------------------------------------------
            */

            $form->select('kategori_id', 'Kategori')
                ->options(
                    KategoriLatihan::pluck(
                        'nama_kategori',
                        'id'
                    )
                )
                ->required();

            $form->text('nama_pendaftar', 'Nama')
                ->required();

            $form->date('tanggal_lahir', 'Tanggal Lahir')
                ->required();

            $form->text('no_hp', 'No HP')
                ->required();

            $form->textarea('alamat', 'Alamat')
                ->required();

            $form->date('tanggal_daftar', 'Tanggal Daftar')
                ->default(date('Y-m-d'))
                ->required();

            /*
            |--------------------------------------------------------------------------
            | VERIFIKASI ADMIN
            |--------------------------------------------------------------------------
            */

            $form->radio('status', 'Status')
                ->options([
                    'menunggu' => 'Menunggu',
                    'diterima' => 'Diterima',
                    'ditolak'  => 'Ditolak',
                ])
                ->default('menunggu')
                ->required();

            $form->textarea('catatan_admin', 'Catatan Admin');

            /*
            |--------------------------------------------------------------------------
            | AUTO INSERT KE ANGGOTA SAAT STATUS "DITERIMA"
            |--------------------------------------------------------------------------
            */
            $form->saved(function (Form $form) {
                $pendaftar = $form->model();

                if ($pendaftar->status === 'diterima') {
                    $anggota = Anggota::where('no_hp', $pendaftar->no_hp)->first();

                    if (!$anggota) {
                        Anggota::create([
                            'kategori_id'    => $pendaftar->kategori_id,
                            'nama'           => $pendaftar->nama_pendaftar,
                            'tanggal_lahir'  => $pendaftar->tanggal_lahir,
                            'no_hp'          => $pendaftar->no_hp,
                            'alamat'         => $pendaftar->alamat,
                            'tanggal_gabung' => now(),
                            'kode_anggota'   => 'AGT-' . str_pad($pendaftar->id, 5, '0', STR_PAD_LEFT),
                            'email'          => null,
                            'password'       => null,
                            'sudah_aktivasi' => false,
                        ]);
                    }
                }
            });
        });
    }
}