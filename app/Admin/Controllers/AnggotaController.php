<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Anggota;
use App\Models\KategoriLatihan;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Carbon\Carbon;

class AnggotaController extends AdminController
{
    /**
     * GRID
     */
    protected function grid()
    {
        return Grid::make(new Anggota(), function (Grid $grid) {

         
            /*
            |--------------------------------------------------------------------------
            | DATA SISWA
            |--------------------------------------------------------------------------
            */

            $grid->column('nama', 'Nama');

            $grid->column('tanggal_lahir', 'Tanggal Lahir')
                ->display(function ($value) {
                    return $value
                        ? date('d-m-Y', strtotime($value))
                        : '-';
                });

            /*
            |--------------------------------------------------------------------------
            | KELAS OTOMATIS
            |--------------------------------------------------------------------------
            */

            $grid->column('kelas', 'Kelas')
                ->display(function () {

                    if (!$this->tanggal_lahir) {
                        return '-';
                    }

                    $umur = Carbon::parse(
                        $this->tanggal_lahir
                    )->age;

                    if ($umur <= 6) return 'TK';
                    if ($umur <= 12) return 'SD';
                    if ($umur <= 15) return 'SMP';
                    if ($umur <= 18) return 'SMA';

                    return 'Dewasa';
                });

            /*
            |--------------------------------------------------------------------------
            | KONTAK
            |--------------------------------------------------------------------------
            */

            $grid->column('alamat', 'Alamat');

            $grid->column('no_hp', 'No HP');

            /*
            |--------------------------------------------------------------------------
            | LOGIN SISWA
            |--------------------------------------------------------------------------
            */

            $grid->column('email', 'Email')
                ->display(function ($value) {
                    return $value ?: '-';
                });

            $grid->column('sudah_aktivasi', 'Status Akun')
                ->display(function ($value) {

                    if ($value) {
                        return "<span class='badge badge-success'>Aktif</span>";
                    }

                    return "<span class='badge badge-warning'>Belum Aktivasi</span>";
                });

            /*
            |--------------------------------------------------------------------------
            | TANGGAL
            |--------------------------------------------------------------------------
            */

            $grid->column('tanggal_gabung', 'Tanggal Gabung')
                ->display(function ($value) {
                    return $value
                        ? date('d-m-Y', strtotime($value))
                        : '-';
                });

            /*
            |--------------------------------------------------------------------------
            | KATEGORI
            |--------------------------------------------------------------------------
            */

            $grid->column(
                'kategori.nama_kategori',
                'Kategori'
            )->display(function ($value) {
                return $value ?? '-';
            });

            /*
            |--------------------------------------------------------------------------
            | FILTER
            |--------------------------------------------------------------------------
            */

            $grid->filter(function (Grid\Filter $filter) {

                $filter->like('nama', 'Nama');

           
                $filter->like(
                    'email',
                    'Email'
                );
            });
        });
    }

    /**
     * DETAIL
     */
    protected function detail($id)
    {
        return Show::make($id, new Anggota(), function (Show $show) {

            $show->field('id');

            /*
            |--------------------------------------------------------------------------
            | LOGIN
            |--------------------------------------------------------------------------
            */

          

            $show->field('email', 'Email');

            $show->field(
                'sudah_aktivasi',
                'Status Akun'
            )->as(function ($value) {

                return $value
                    ? 'Sudah Aktivasi'
                    : 'Belum Aktivasi';
            });

            /*
            |--------------------------------------------------------------------------
            | DATA SISWA
            |--------------------------------------------------------------------------
            */

            $show->field('nama');

            $show->field(
                'tanggal_lahir',
                'Tanggal Lahir'
            );

            /*
            |--------------------------------------------------------------------------
            | KELAS
            |--------------------------------------------------------------------------
            */

            $show->field('kelas', 'Kelas')
                ->as(function () {

                    if (!$this->tanggal_lahir) {
                        return '-';
                    }

                    $umur = Carbon::parse(
                        $this->tanggal_lahir
                    )->age;

                    if ($umur <= 6) return 'TK';
                    if ($umur <= 12) return 'SD';
                    if ($umur <= 15) return 'SMP';
                    if ($umur <= 18) return 'SMA';

                    return 'Dewasa';
                });

            /*
            |--------------------------------------------------------------------------
            | DATA LAIN
            |--------------------------------------------------------------------------
            */

            $show->field('alamat');

            $show->field('no_hp');

            $show->field(
                'tanggal_gabung',
                'Tanggal Gabung'
            );

            $show->field(
                'kategori.nama_kategori',
                'Kategori'
            );
        });
    }

    /**
     * FORM
     */
    protected function form()
    {
        return Form::make(new Anggota(), function (Form $form) {

       
          
            /*
            |--------------------------------------------------------------------------
            | DATA SISWA
            |--------------------------------------------------------------------------
            */

            $form->text('nama', 'Nama')
                ->required();

            $form->date(
                'tanggal_lahir',
                'Tanggal Lahir'
            )->required();

            $form->textarea('alamat')
                ->required();

            $form->text('no_hp', 'No HP')
                ->required();

            $form->date(
                'tanggal_gabung',
                'Tanggal Gabung'
            )
            ->default(date('Y-m-d'))
            ->required();

            /*
            |--------------------------------------------------------------------------
            | KATEGORI
            |--------------------------------------------------------------------------
            */

            $form->select(
                'kategori_id',
                'Kategori'
            )
            ->options(
                KategoriLatihan::pluck(
                    'nama_kategori',
                    'id'
                )
            )
            ->required();

            /*
            |--------------------------------------------------------------------------
            | STATUS AKUN
            |--------------------------------------------------------------------------
            */

            $form->display(
                'sudah_aktivasi',
                'Status Akun'
            )->with(function ($value) {

                return $value
                    ? 'Sudah Aktivasi'
                    : 'Belum Aktivasi';
            });

            /*
            |--------------------------------------------------------------------------
            | EMAIL
            |--------------------------------------------------------------------------
            */

            $form->display(
                'email',
                'Email Login'
            );

            /*
            |--------------------------------------------------------------------------
            | KELAS
            |--------------------------------------------------------------------------
            */

            $form->display('kelas', 'Kelas')
                ->with(function () {

                    if (!$this->tanggal_lahir) {
                        return '-';
                    }

                    $umur = Carbon::parse(
                        $this->tanggal_lahir
                    )->age;

                    if ($umur <= 6) return 'TK';
                    if ($umur <= 12) return 'SD';
                    if ($umur <= 15) return 'SMP';
                    if ($umur <= 18) return 'SMA';

                    return 'Dewasa';
                });

            /*
            |--------------------------------------------------------------------------
            | CREATED UPDATED
            |--------------------------------------------------------------------------
            */

            $form->display('created_at');

            $form->display('updated_at');
        });
    }
}