<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoLombaTable extends Migration
{
    public function up()
    {
        Schema::create('info_lomba', function (Blueprint $table) {

            $table->id();

            $table->string('judul');
            $table->date('tanggal')->nullable();
            $table->string('lokasi')->nullable();

            $table->text('deskripsi')->nullable();

            $table->string('gambar')->nullable();

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('info_lomba');
    }
}