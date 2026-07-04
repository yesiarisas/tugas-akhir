<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('homepages', function (Blueprint $table) {
            $table->id();

            // Header
            $table->string('logo')->nullable();
            $table->string('nama_sanggar')->nullable();

            // Hero Section
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_button_text')->nullable();
            $table->string('hero_button_link')->nullable();

            // Kategori Seni 1
            $table->string('kategori1_nama')->nullable();
            $table->text('kategori1_deskripsi')->nullable();
            $table->string('kategori1_gambar')->nullable();

            // Kategori Seni 2
            $table->string('kategori2_nama')->nullable();
            $table->text('kategori2_deskripsi')->nullable();
            $table->string('kategori2_gambar')->nullable();

            // Sejarah / Tentang Sanggar
            $table->string('tentang_judul')->nullable();
            $table->longText('tentang_deskripsi')->nullable();
            $table->string('tentang_gambar')->nullable();

            // Footer
            $table->text('footer_deskripsi')->nullable();
            $table->string('footer_telepon')->nullable();
            $table->text('footer_alamat')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepages');
    }
};