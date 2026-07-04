<?php

namespace App\Admin\Controllers;

use App\Models\Homepage;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;

class HomepageController extends AdminController
{
    protected function grid()
    {
        return Grid::make(new Homepage(), function (Grid $grid) {

            $grid->column('id')->sortable();
            $grid->column('nama_sanggar');
            $grid->column('hero_title');

            $grid->disableCreateButton(false);
        });
    }

    protected function form()
    {
        return Form::make(new Homepage(), function (Form $form) {

            // HEADER
            $form->divider('Header Website');

            $form->image('logo')->uniqueName();
            $form->text('nama_sanggar');

            // HERO
            $form->divider('Hero Banner');

            $form->text('hero_title');
            $form->textarea('hero_subtitle');

            $form->image('hero_image')->uniqueName();

            $form->text('hero_button_text');
            $form->text('hero_button_link');

            // KATEGORI 1
            $form->divider('Kategori Seni 1');

            $form->text('kategori1_nama');
            $form->textarea('kategori1_deskripsi');
            $form->image('kategori1_gambar')->uniqueName();

            // KATEGORI 2
            $form->divider('Kategori Seni 2');

            $form->text('kategori2_nama');
            $form->textarea('kategori2_deskripsi');
            $form->image('kategori2_gambar')->uniqueName();

            // TENTANG
            $form->divider('Tentang Sanggar');

            $form->text('tentang_judul');
            $form->editor('tentang_deskripsi');
            $form->image('tentang_gambar')->uniqueName();

            // FOOTER
            $form->divider('Footer');

            $form->textarea('footer_deskripsi');
            $form->text('footer_telepon');
            $form->textarea('footer_alamat');
        });
    }
}