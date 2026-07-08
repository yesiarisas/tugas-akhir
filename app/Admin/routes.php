<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    // Home
    $router->get('/', 'HomeController@index');

    // Master Data & Fitur Lain
    $router->resource('anggota', 'AnggotaController');
    $router->resource('kategori_latihan', 'KategoriLatihanController');
    $router->resource('pendaftar', 'PendaftarController');
    $router->resource('jadwal-latihan', 'JadwalLatihanController');
    $router->resource('pengumuman', 'PengumumanController');
    
    // Fitur Pembayaran (Custom routes ditaruh di atas resource agar tidak bentrok)
    $router->get('pembayaran/generate-periode', 'PembayaranController@generatePeriode');
    $router->get('pembayaran/riwayat/{id}', 'PembayaranController@riwayat');
    $router->get('pembayaran/pdf/{id}', 'PembayaranController@pdf');
    $router->resource('pembayaran', 'PembayaranController');

    // Fitur Evaluasi (Custom routes di atas resource)
    $router->get('evaluasi/riwayat/{id}', 'EvaluasiController@riwayat');
    $router->get('evaluasi/grafik/{id}', 'EvaluasiController@grafik');
    $router->resource('evaluasi', 'EvaluasiController');

    // Fitur Informasi & Konten (Diseragamkan menggunakan $router)
    $router->resource('homepage', 'HomepageController');
    $router->resource('agenda', 'AgendaController');
    $router->resource('infolomba', 'InfoLombaController');
    $router->resource('galeri-prestasi', 'GaleriPrestasiController');

});