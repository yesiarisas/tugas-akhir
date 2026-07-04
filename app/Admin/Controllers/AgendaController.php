<?php

namespace App\Admin\Controllers;

use App\Models\Agenda;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;

class AgendaController extends AdminController
{
    protected function grid()
    {
        return Grid::make(new Agenda(), function (Grid $grid) {

            $grid->column('id')->sortable();

            $grid->column('gambar')
                ->image('', 100, 100);

            $grid->column('judul');

            $grid->column('tanggal');

            $grid->column('lokasi');

            $grid->column('created_at');

        });
    }

    protected function form()
    {
        return Form::make(new Agenda(), function (Form $form) {

            $form->display('id');

            $form->text('judul')
                ->required();

            $form->date('tanggal')
                ->required();

            $form->text('lokasi');

            $form->textarea('deskripsi');

            $form->image('gambar')
                ->autoUpload()
                ->uniqueName();

        });
    }
}