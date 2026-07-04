<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengumumanTable extends Migration
{
    public function up()
    {
        Schema::create('pengumuman', function (Blueprint $table) {

            $table->increments('id');

            // kategori opsional
            $table->unsignedInteger('kategori_id')->nullable();

            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategori_latihan')
                  ->onDelete('cascade');

            $table->string('judul');

            $table->text('isi');

            $table->date('tanggal');

            $table->enum('status', ['tampil', 'tidak'])
                  ->default('tampil');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengumuman');
    }
}