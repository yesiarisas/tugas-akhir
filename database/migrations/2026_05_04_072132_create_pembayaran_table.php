<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembayaranTable extends Migration
{
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {

            $table->increments('id');

            // relasi ke anggota
            $table->unsignedInteger('anggota_id');
            $table->foreign('anggota_id')
                  ->references('id')
                  ->on('anggota')
                  ->onDelete('cascade');

            // jenis pembayaran
            $table->enum('jenis', ['harian','mingguan','bulanan']);

            // periode biar rapi
            $table->string('periode'); 
            // contoh: "2026-04", "Minggu ke-2", dll

            $table->integer('nominal');

            $table->date('tanggal_bayar');

            $table->enum('status', ['lunas','belum'])
                  ->default('belum');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
}