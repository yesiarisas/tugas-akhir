<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('anggota', function (Blueprint $table) {

            $table->increments('id');

            /*
            |--------------------------------------------------------------------------
            | RELASI KATEGORI
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('kategori_id');

            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategori_latihan')
                  ->onDelete('cascade');

            /*
            |--------------------------------------------------------------------------
            | DATA SISWA / ANGGOTA
            |--------------------------------------------------------------------------
            */

            $table->string('nama');

            $table->date('tanggal_lahir')
                  ->nullable();

            $table->string('no_hp');

            $table->text('alamat');

            $table->date('tanggal_gabung');

            /*
            |--------------------------------------------------------------------------
            | LOGIN SYSTEM
            |--------------------------------------------------------------------------
            */

            $table->string('kode_anggota')
                  ->unique()
                  ->nullable();

            $table->string('email')
                  ->unique()
                  ->nullable();

            $table->string('password')
                  ->nullable();

            $table->boolean('sudah_aktivasi')
                  ->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('anggota');
    }
}