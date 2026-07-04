<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSudahRegisterToPendaftarTable extends Migration
{
    public function up()
    {
        Schema::table('pendaftar', function (Blueprint $table) {

            $table->boolean('sudah_register')
                  ->default(false);

        });
    }

    public function down()
    {
        Schema::table('pendaftar', function (Blueprint $table) {

            $table->dropColumn('sudah_register');

        });
    }
}