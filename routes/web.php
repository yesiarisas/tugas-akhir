<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// Pastikan semua alamat lain juga lari ke 'welcome' agar ditangani oleh Vue
Route::get('/{any}', function () {
    return view('welcome'); 
})->where('any', '.*');