<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\KategoriLatihan;

class PendaftaranController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | KATEGORI
    |--------------------------------------------------------------------------
    */
    public function kategori()
    {
        // Mengembalikan data langsung agar Vue bisa membaca data dengan konsisten
        return response()->json([
            'success' => true,
            'data'    => KategoriLatihan::all()
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE PENDAFTARAN
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id'    => 'required',
            'nama_pendaftar' => 'required',
            'tanggal_lahir'  => 'required',
            'no_hp'          => 'required',
            'alamat'         => 'required',
        ]);

        // Membersihkan nomor HP dari spasi, strip, atau karakter non-angka
        $noHpClean = preg_replace('/[^0-9]/', '', $request->no_hp);

        $pendaftar = Pendaftar::create([
            'kategori_id'    => $request->kategori_id,
            'nama_pendaftar' => $request->nama_pendaftar,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'no_hp'          => $noHpClean, 
            'alamat'         => $request->alamat,
            'tanggal_daftar' => now(),
            'status'         => 'menunggu',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil',
            'data'    => $pendaftar
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CEK STATUS
    |--------------------------------------------------------------------------
    */
    public function cekStatus(Request $request)
    {
        $request->validate([
            'no_hp' => 'required'
        ]);

        // Bersihkan nomor HP inputan user sebelum dicocokkan ke DB
        $noHpClean = preg_replace('/[^0-9]/', '', $request->no_hp);

        $pendaftar = Pendaftar::where('no_hp', $noHpClean)->first();

        if (!$pendaftar) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $pendaftar
        ]);
    }
}