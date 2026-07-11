<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Route::get('/debug-host', function () {
    return [
        'host' => request()->getHost(),
        'scheme' => request()->getScheme(),
        'is_secure' => request()->isSecure(),
        'trusted_proxies' => request()->getTrustedProxies(),
    ];
});

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// Pastikan semua alamat lain juga lari ke 'welcome' agar ditangani oleh Vue
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');


Route::get('/debug-host', function () {
    return [
        'host' => request()->getHost(),
        'scheme' => request()->getScheme(),
        'is_secure' => request()->isSecure(),
        'trusted_proxies' => request()->getTrustedProxies(),
    ];
});
