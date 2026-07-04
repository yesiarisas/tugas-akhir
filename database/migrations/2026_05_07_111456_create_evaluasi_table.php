<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluasiTable extends Migration
{
    public function up()
    {
        Schema::create('evaluasi', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('anggota_id');

            $table->foreign('anggota_id')
                ->references('id')
                ->on('anggota')
                ->onDelete('cascade');

            $table->unsignedInteger('kategori_id');

            $table->foreign('kategori_id')
                ->references('id')
                ->on('kategori_latihan')
                ->onDelete('cascade');

            $table->date('tanggal_evaluasi');

            $table->integer('nilai_teknik');

            $table->integer('nilai_kedisiplinan');

            $table->integer('nilai_kehadiran');

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluasi');
    }
}