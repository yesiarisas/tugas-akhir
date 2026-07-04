<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJadwalLatihanTable extends Migration
{
    public function up()
    {
        Schema::create('jadwal_latihan', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('kategori_id');
            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategori_latihan')
                  ->onDelete('cascade');

            $table->enum('hari', [
                'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'
            ]);

            $table->time('jam_mulai');
            $table->time('jam_selesai');

            $table->string('lokasi');
            $table->text('keterangan')->nullable();

            $table->enum('status', ['aktif','nonaktif'])->default('aktif');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_latihan');
    }
}