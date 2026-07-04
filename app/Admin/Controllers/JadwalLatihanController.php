<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\JadwalLatihan;
use App\Models\KategoriLatihan;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class JadwalLatihanController extends AdminController
{
    /**
     * GRID / LIST DATA
     */
    protected function grid()
    {
        return Grid::make(new JadwalLatihan(), function (Grid $grid) {

            $grid->column('id', 'No')->sortable();

            // Hari
            $grid->column('hari', 'Hari');

            // Jam
            $grid->column('jam_mulai', 'Jam')->display(function () {
                return substr($this->jam_mulai, 0, 5) . ' - ' . substr($this->jam_selesai, 0, 5);
            });

            // Lokasi
            $grid->column('lokasi', 'Lokasi');

            // Keterangan
            $grid->column('keterangan', 'Keterangan');

            // Ambil Nama Kategori
            $grid->column('kategori_id', 'Kategori')->display(function ($id) {
                $kategori = \App\Models\KategoriLatihan::find($id);
                return $kategori ? $kategori->nama_kategori : '-';
            });

            // Status
            $grid->column('status', 'Status')
                ->using([
                    'aktif'    => 'Aktif',
                    'nonaktif' => 'Nonaktif',
                ])
                ->label([
                    'aktif'    => 'success',
                    'nonaktif' => 'danger',
                ]);

            $grid->disableViewButton();

            $grid->filter(function (Grid\Filter $filter) {

                $filter->equal('kategori_id', 'Kategori')
                    ->select(
                        KategoriLatihan::pluck('nama_kategori', 'id')
                    );

                $filter->equal('hari', 'Hari')->select([
                    'Senin'  => 'Senin',
                    'Selasa' => 'Selasa',
                    'Rabu'   => 'Rabu',
                    'Kamis'  => 'Kamis',
                    'Jumat'  => 'Jumat',
                    'Sabtu'  => 'Sabtu',
                    'Minggu' => 'Minggu',
                ]);
            });
        });
    }

    /**
     * DETAIL
     */
    protected function detail($id)
    {
        return Show::make($id, new JadwalLatihan(), function (Show $show) {

            $show->field('id');
            $show->field('hari');
            $show->field('jam_mulai');
            $show->field('jam_selesai');
            $show->field('lokasi');
            $show->field('keterangan');
            $show->field('kategori.nama_kategori', 'Kategori');
            $show->field('status');
        });
    }

    /**
     * FORM TAMBAH / EDIT
     */
    protected function form()
    {
        return Form::make(new JadwalLatihan(), function (Form $form) {

            $form->display('id');

            // Ambil kategori otomatis
            $form->select('kategori_id', 'Kategori Latihan')
                ->options(
                    KategoriLatihan::pluck('nama_kategori', 'id')
                )
                ->required();

            // Hari
            $form->select('hari', 'Hari')
                ->options([
                    'Senin'  => 'Senin',
                    'Selasa' => 'Selasa',
                    'Rabu'   => 'Rabu',
                    'Kamis'  => 'Kamis',
                    'Jumat'  => 'Jumat',
                    'Sabtu'  => 'Sabtu',
                    'Minggu' => 'Minggu',
                ])
                ->required();

            // Jam
            $form->time('jam_mulai', 'Jam Mulai')->required();
            $form->time('jam_selesai', 'Jam Selesai')->required();

            // Lokasi
            $form->text('lokasi', 'Lokasi')->required();

            // Keterangan
            $form->textarea('keterangan', 'Keterangan');

            // Status
            $form->radio('status', 'Status')
                ->options([
                    'aktif'    => 'Aktif',
                    'nonaktif' => 'Nonaktif',
                ])
                ->default('aktif');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}