<?php

namespace App\Admin\Controllers;

use App\Models\InfoLomba;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;

class InfoLombaController extends AdminController
{
    protected function grid()
    {
        return Grid::make(new InfoLomba(), function (Grid $grid) {

            $grid->column('id')->sortable();

            $grid->column('gambar')->image('', 120, 80);

            $grid->column('judul');

            $grid->column('tanggal');

            $grid->column('lokasi');

            $grid->column('created_at');

        });
    }

    protected function form()
    {
        return Form::make(new InfoLomba(), function (Form $form) {

            $form->display('id');

            $form->text('judul')
                ->required();

            $form->date('tanggal');

            $form->text('lokasi');

            $form->textarea('deskripsi');

            $form->image('gambar')
                ->disk('public')
                ->uniqueName();

        });
    }
}