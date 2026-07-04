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

    $router->get('/', 'HomeController@index');
    $router->resource('anggota', 'AnggotaController');
    $router->resource('kategori_latihan', 'KategoriLatihanController');
    $router->resource('pendaftar', 'PendaftarController');
    $router->resource('jadwal-latihan', 'JadwalLatihanController');
    $router->resource('pembayaran', 'PembayaranController');
    $router->get('pembayaran/riwayat/{id}', 'PembayaranController@riwayat');
    $router->get('pembayaran/pdf/{id}', 'PembayaranController@pdf');
    $router->resource('pengumuman', 'PengumumanController');
  $router->resource('evaluasi', 'EvaluasiController');

    $router->get(
        'evaluasi/riwayat/{id}',
        'EvaluasiController@riwayat'
    );

    $router->get(
        'evaluasi/grafik/{id}',
        'EvaluasiController@grafik'
    );
    Route::resource('homepage', HomepageController::class);

    $router->resource('agenda', AgendaController::class);
    Route::resource('infolomba', InfoLombaController::class);
    
$router->resource('galeri-prestasi', GaleriPrestasiController::class);








    });
