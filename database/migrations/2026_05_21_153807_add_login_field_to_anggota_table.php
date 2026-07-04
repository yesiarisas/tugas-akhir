<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoginFieldToAnggotaTable extends Migration
{
    public function up()
    {
        Schema::table('anggota', function (Blueprint $table) {

            $table->string('kode_anggota')
                  ->nullable()
                  ->unique();

            $table->string('email')
                  ->nullable()
                  ->unique();

            $table->string('password')
                  ->nullable();

            $table->boolean('sudah_aktivasi')
                  ->default(false);

        });
    }

    public function down()
    {
        Schema::table('anggota', function (Blueprint $table) {

            $table->dropColumn([

                'kode_anggota',
                'email',
                'password',
                'sudah_aktivasi'

            ]);

        });
    }
}