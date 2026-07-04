<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGaleriPrestasiTable extends Migration
{
    public function up()
    {
        Schema::create('galeri_prestasi', function (Blueprint $table) {

            $table->id();

            $table->string('judul');

            $table->string('gambar');

            $table->text('deskripsi')->nullable();

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('galeri_prestasi');
    }
}