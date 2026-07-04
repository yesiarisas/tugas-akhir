<?php

namespace App\Admin\Controllers;

use App\Models\GaleriPrestasi;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;

class GaleriPrestasiController extends AdminController
{
    protected function grid()
    {
        return Grid::make(new GaleriPrestasi(), function (Grid $grid) {

            $grid->column('id')->sortable();

            $grid->column('gambar')->image('', 120, 80);

            $grid->column('judul');

            $grid->column('created_at');

        });
    }

    protected function form()
    {
        return Form::make(new GaleriPrestasi(), function (Form $form) {

            $form->text('judul')
                ->required();

            $form->image('gambar')
                ->disk('public')
                ->uniqueName()
                ->autoUpload()
                ->required();

            $form->textarea('deskripsi');

        });
    }
}