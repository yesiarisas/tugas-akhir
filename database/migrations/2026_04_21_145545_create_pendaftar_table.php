<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendaftarTable extends Migration
{
    public function up()
    {
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('kategori_id');
            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategori_latihan')
                  ->onDelete('cascade');

            $table->string('nama_pendaftar');

            // ✅ TAMBAHAN DI SINI
            $table->date('tanggal_lahir');

            $table->string('no_hp');
            $table->text('alamat');
            $table->date('tanggal_daftar');

            $table->enum('status', ['menunggu','diterima','ditolak'])
                  ->default('menunggu');

            $table->text('catatan_admin')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftar');
    }
}