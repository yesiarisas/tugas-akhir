<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnggotaIdToPendaftarTable extends Migration
{
    public function up()
    {
        Schema::table('pendaftar', function (Blueprint $table) {

            // cek kalau kolom belum ada
            if (!Schema::hasColumn('pendaftar', 'anggota_id')) {
                $table->unsignedInteger('anggota_id')
                    ->nullable()
                    ->after('status');
            }

            // cek kalau kolom belum ada
            if (!Schema::hasColumn('pendaftar', 'sudah_register')) {
                $table->boolean('sudah_register')
                    ->default(false)
                    ->after('anggota_id');
            }
        });
    }

    public function down()
    {
        Schema::table('pendaftar', function (Blueprint $table) {

            if (Schema::hasColumn('pendaftar', 'anggota_id')) {
                $table->dropColumn('anggota_id');
            }

            if (Schema::hasColumn('pendaftar', 'sudah_register')) {
                $table->dropColumn('sudah_register');
            }
        });
    }
}