<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SiswaApiController extends Controller
{
    public function getProfil($id)
    {
        try {

            $siswa = DB::table('anggota')
                ->where('id', $id)
                ->first();

            if (!$siswa) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data siswa tidak ditemukan'
                ], 404);
            }

            $kelas = '-';

            if ($siswa->tanggal_lahir) {

                $umur = Carbon::parse($siswa->tanggal_lahir)->age;

                if ($umur <= 6) {
                    $kelas = 'TK';
                } elseif ($umur <= 12) {
                    $kelas = 'SD';
                } elseif ($umur <= 15) {
                    $kelas = 'SMP';
                } elseif ($umur <= 18) {
                    $kelas = 'SMA';
                } else {
                    $kelas = 'Dewasa';
                }
            }

            return response()->json([
                'status' => true,
                'siswa' => [
                    'id' => $siswa->id,
                    'nama' => $siswa->nama,
                    'email' => $siswa->email,
                    'no_hp' => $siswa->no_hp,
                    'tanggal_lahir' => $siswa->tanggal_lahir,
                    'alamat' => $siswa->alamat
                ],
                'kelas' => $kelas
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProfil(Request $request, $id)
    {
        try {

            $siswa = DB::table('anggota')
                ->where('id', $id)
                ->first();

            if (!$siswa) {
                return response()->json([
                    'status' => false,
                    'message' => 'Siswa tidak ditemukan'
                ], 404);
            }

            DB::table('anggota')
                ->where('id', $id)
                ->update([
                    'nama' => $request->nama,
                    'no_hp' => $request->no_hp,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'alamat' => $request->alamat,
                    'updated_at' => now()
                ]);

            return response()->json([
                'status' => true,
                'message' => 'Profil berhasil diperbarui'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}