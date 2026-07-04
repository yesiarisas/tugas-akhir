<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Pengumuman;
use App\Models\KategoriLatihan;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PengumumanController extends AdminController
{
    /**
     * GRID
     */
    protected function grid()
    {
        return Grid::make(new Pengumuman(), function (Grid $grid) {

            $grid->column('id')->sortable();

            $grid->column('judul', 'Judul');

            // 🔥 tampil kategori / semua
            $grid->column('kategori.nama_kategori', 'Kategori')
                ->display(function ($value) {
                    return $value ?: 'Semua';
                });

            $grid->column('tanggal', 'Tanggal');

            $grid->column('status')
                ->using([
                    'tampil' => 'Tampil',
                    'tidak' => 'Tidak',
                ])
                ->label([
                    'tampil' => 'success',
                    'tidak' => 'danger',
                ]);

            $grid->column('created_at');

            $grid->filter(function ($filter) {
                $filter->like('judul', 'Judul');
            });
        });
    }

    /**
     * DETAIL
     */
    protected function detail($id)
    {
        return Show::make($id, new Pengumuman(), function (Show $show) {

            $show->field('judul');

            $show->field('kategori.nama_kategori', 'Kategori')
                ->as(function ($value) {
                    return $value ?: 'Semua';
                });

            $show->field('isi');
            $show->field('tanggal');
            $show->field('status');
        });
    }

    /**
     * FORM
     */
    protected function form()
    {
        return Form::make(new Pengumuman(), function (Form $form) {

            $form->display('id');

            $form->text('judul', 'Judul')->required();

            $form->textarea('isi', 'Isi Pengumuman')->required();

            // 🔥 kategori opsional
            $form->select('kategori_id', 'Kategori')
                ->options(KategoriLatihan::pluck('nama_kategori', 'id'))
                ->placeholder('Semua Kategori')
                ->help('Kosongkan jika untuk semua kategori');

            // kalender
            $form->date('tanggal', 'Tanggal')
                ->default(date('Y-m-d'))
                ->required();

            // status
            $form->radio('status', 'Status')
                ->options([
                    'tampil' => 'Tampilkan',
                    'tidak' => 'Sembunyikan',
                ])
                ->default('tampil');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}