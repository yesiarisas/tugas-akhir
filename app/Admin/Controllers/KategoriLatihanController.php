<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\KategoriLatihan;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class KategoriLatihanController extends AdminController
{
    /**
     * Grid (tampilan tabel)
     */
    protected function grid()
    {
        return Grid::make(new KategoriLatihan(), function (Grid $grid) {

            $grid->column('id')->sortable();
            $grid->column('nama_kategori', 'Nama Kategori');
            $grid->column('deskripsi', 'Deskripsi');

            // ✅ Status tampil bagus
            $grid->column('is_active', 'Status')
                ->using([
                    1 => 'Aktif',
                    0 => 'Tidak Aktif',
                ])
                ->label([
                    1 => 'success',
                    0 => 'danger',
                ]);

            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            // 🔍 filter
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

                $filter->equal('is_active', 'Status')->select([
                    1 => 'Aktif',
                    0 => 'Tidak Aktif',
                ]);
            });
        });
    }

    /**
     * Detail view
     */
    protected function detail($id)
    {
        return Show::make($id, new KategoriLatihan(), function (Show $show) {

            $show->field('id');
            $show->field('nama_kategori', 'Nama Kategori');
            $show->field('deskripsi', 'Deskripsi');

            // ✅ Status tampil jelas
            $show->field('is_active', 'Status')
                ->as(function ($value) {
                    return $value ? 'Aktif' : 'Tidak Aktif';
                });

            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Form (create & edit)
     */
    protected function form()
    {
        return Form::make(new KategoriLatihan(), function (Form $form) {

            $form->display('id');

            $form->text('nama_kategori', 'Nama Kategori')->required();
            $form->textarea('deskripsi', 'Deskripsi');

            // ✅ GANTI pakai SELECT (aman semua versi)
            $form->select('is_active', 'Status')
                ->options([
                    1 => 'Aktif',
                    0 => 'Tidak Aktif',
                ])
                ->default(1)
                ->required();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}