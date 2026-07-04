<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomepageController;
use App\Http\Controllers\Api\AgendaController;
use App\Http\Controllers\Api\InfoLombaController;
use App\Http\Controllers\Api\GaleriPrestasiController;
use App\Http\Controllers\Api\PendaftaranController;
use App\Http\Controllers\Api\AnggotaController;
use App\Http\Controllers\Api\SiswaDashboardController;
use App\Http\Controllers\Api\SiswaApiController;
use App\Http\Controllers\Api\PengumumanController;
use App\Http\Controllers\Api\SiswaEvaluasiController;
// Tambahkan import Controller Pembayaran Baru di sini
use App\Http\Controllers\Api\SiswaPembayaranController;

/*
|--------------------------------------------------------------------------
| HOMEPAGE & UMUM
|--------------------------------------------------------------------------
*/
Route::get('/homepage', [HomepageController::class, 'index']);
Route::get('/info-lomba', [InfoLombaController::class, 'index']);
Route::get('/info-lomba/{id}', [InfoLombaController::class, 'detail']);
Route::get('/agenda', [AgendaController::class, 'index']);
Route::get('/agenda/{id}', [AgendaController::class, 'show']);
Route::get('/galeri-prestasi', [GaleriPrestasiController::class, 'index']);

/*
|--------------------------------------------------------------------------
| PENDAFTARAN & AUTH SISWA
|--------------------------------------------------------------------------
*/
Route::get('/kategori-latihan', [PendaftaranController::class, 'kategori']);
Route::post('/pendaftaran', [PendaftaranController::class, 'store']);
Route::post('/pendaftar/tolak/{id}', [PendaftaranController::class, 'tolak']);
Route::post('/aktivasi-akun', [AnggotaController::class, 'aktivasi']);
Route::post('/login-siswa', [AnggotaController::class, 'login']);
Route::post('/cek-status', [PendaftaranController::class, 'cekStatus']);

/*
|--------------------------------------------------------------------------
| PENGUMUMAN
|--------------------------------------------------------------------------
*/
Route::get('/pengumuman', [PengumumanController::class, 'index']);
Route::get('/pengumuman/{id}', [PengumumanController::class, 'show']);

/*
|--------------------------------------------------------------------------
| SISWA DASHBOARD & PROFIL (PREFIX)
|--------------------------------------------------------------------------
*/
Route::prefix('siswa')->group(function () {
    Route::get('/profil/{id}', [SiswaApiController::class, 'getProfil']);
    Route::put('/profil/update/{id}', [SiswaApiController::class, 'updateProfil']);
    Route::get('/pengumuman-dashboard/{id}', [SiswaDashboardController::class, 'getPengumuman']);
    Route::get('/jadwal/{id}', [SiswaDashboardController::class, 'getJadwal']);
    
    // RUTE PEMBAYARAN: Diarahkan ke SiswaPembayaranController yang baru dan terpisah
    Route::get('/pembayaran/{id}', [SiswaPembayaranController::class, 'getPembayaranSiswa']);
    
    // RUTE EVALUASI: Tetap diarahkan ke SiswaEvaluasiController mandiri
    Route::get('/evaluasi/{id}', [SiswaEvaluasiController::class, 'getEvaluasiSiswa']);
});

Route::get('/test-api', function () {
    return response()->json(['status' => true, 'message' => 'API berhasil berjalan dengan normal.']);
});