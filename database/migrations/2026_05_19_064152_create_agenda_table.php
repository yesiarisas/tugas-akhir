<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaTable extends Migration
{
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {

            $table->id();

            $table->string('judul');

            $table->date('tanggal');

            $table->string('lokasi')->nullable();

            $table->text('deskripsi')->nullable();

            $table->string('gambar')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agenda');
    }
}