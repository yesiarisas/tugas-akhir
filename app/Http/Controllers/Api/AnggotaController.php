<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function aktivasi(Request $request)
    {
        $request->validate([
            'no_hp'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ]);

        $pendaftar = Pendaftar::where('no_hp', $request->no_hp)->first();

        if (!$pendaftar) {
            return response()->json([
                'success' => false,
                'message' => 'Data pendaftar tidak ditemukan'
            ], 404);
        }

        $anggota = Anggota::where('no_hp', $request->no_hp)->first();

        if (!$anggota) {
            return response()->json([
                'success' => false,
                'message' => 'Data anggota belum dibuat admin'
            ], 404);
        }

        if ($anggota->sudah_aktivasi) {
            return response()->json([
                'success' => false,
                'message' => 'Akun sudah diaktivasi'
            ], 400);
        }

        $anggota->update([
            'email'          => strtolower(trim($request->email)),
            'password'       => Hash::make($request->password),
            'sudah_aktivasi' => 1
        ]);

        $pendaftar->update([
            'anggota_id' => $anggota->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Aktivasi berhasil, silakan login'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $anggota = Anggota::where('email', $request->email)->first();

        if (!$anggota) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan'
            ], 404);
        }

        if (!Hash::check($request->password, $anggota->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'user' => [
                'id' => $anggota->id,
                'nama' => $anggota->nama,
                'email' => $anggota->email
            ]
        ]);
    }
}