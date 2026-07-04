<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKategoriLatihanTable extends Migration
{
    public function up()
    {
        Schema::create('kategori_latihan', function (Blueprint $table) {
            $table->increments('id'); // primary key

            $table->string('nama_kategori'); // nama kategori
            $table->text('deskripsi')->nullable(); // boleh kosong
            $table->boolean('is_active')->default(true); // status aktif

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategori_latihan');
    }
}