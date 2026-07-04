<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Pengumuman;
use App\Models\JadwalLatihan;
use App\Models\Pembayaran;
use App\Models\Evaluasi;
use App\Models\User;
use Carbon\Carbon;

class SiswaDashboardController extends Controller
{
    /**
     * Helper untuk mengambil data Anggota berdasarkan User ID (dari tabel users)
     */
    private function getAnggotaByUserId($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return null;
        }

        return Anggota::with('kategori')
            ->whereRaw('LOWER(email) = ?', [
                strtolower(trim($user->email))
            ])
            ->first();
    }

    /**
     * API Ambil Profil
     */
    public function getProfil($id)
    {
        $siswa = $this->getAnggotaByUserId($id);

        if (!$siswa) {
            // Fallback: jika id yang dikirim adalah ID Anggota langsung
            $siswa = Anggota::with('kategori')->find($id);
        }

        if (!$siswa) {
            return response()->json([
                'status' => false,
                'message' => 'Data anggota tidak ditemukan',
                'user_id' => $id
            ], 404);
        }

        $umur = 0;
        if ($siswa->tanggal_lahir) {
            $umur = Carbon::parse($siswa->tanggal_lahir)->age;
        }

        $kelas = 'Dewasa';
        if ($umur <= 6) {
            $kelas = 'TK';
        } elseif ($umur <= 12) {
            $kelas = 'SD';
        } elseif ($umur <= 15) {
            $kelas = 'SMP';
        } elseif ($umur <= 18) {
            $kelas = 'SMA';
        }

        return response()->json([
            'status' => true,
            'siswa' => [
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'email' => $siswa->email,
                'alamat' => $siswa->alamat,
                'no_hp' => $siswa->no_hp,
                'tanggal_lahir' => $siswa->tanggal_lahir,
                'tanggal_gabung' => $siswa->tanggal_gabung,
                'kategori' => $siswa->kategori
            ],
            'kelas' => $kelas
        ]);
    }

    /**
     * API Pengumuman Dashboard
     */
    public function getPengumuman($id)
    {
        $siswa = $this->getAnggotaByUserId($id);
        
        if (!$siswa) {
            $siswa = Anggota::find($id);
        }

        if (!$siswa) {
            return response()->json([
                'status' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $pengumuman = Pengumuman::where('status', 'tampil')
            ->where(function ($q) use ($siswa) {
                $q->whereNull('kategori_id')
                  ->orWhere('kategori_id', $siswa->kategori_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $pengumuman
        ]);
    }

    /**
     * API JADWAL LATIHAN (Telah Diperbaiki Total)
     */
    public function getJadwal($id)
    {
        // 1. Ambil data siswa lewat ID User
        $siswa = $this->getAnggotaByUserId($id);

        // 2. Fallback jika yang dikirim dari LocalStorage adalah ID Anggota langsung
        if (!$siswa) {
            $siswa = Anggota::with('kategori')->find($id);
        }

        // 3. Jika tidak ditemukan di kedua skenario, balikkan array kosong agar Vue tidak crash
        if (!$siswa) {
            return response()->json([
                'status' => false,
                'success' => false,
                'kelas' => '-',
                'message' => 'Siswa dengan ID ' . $id . ' tidak ditemukan.',
                'data' => []
            ], 404);
        }

        // 4. Jika siswa ditemukan tapi belum memiliki kategori kelas (kategori_id masih NULL)
        if (!$siswa->kategori_id) {
            return response()->json([
                'status' => true,
                'success' => true,
                'kelas' => 'Belum Ditentukan',
                'data' => []
            ], 200);
        }

        // 5. Ambil data jadwal latihan aktif sesuai kategori kelas tari siswa
        $jadwal = JadwalLatihan::with('kategori')
            ->where('kategori_id', $siswa->kategori_id)
            ->where('status', 'aktif')
            ->get();

        // 6. Return JSON response yang dibaca oleh res.data di Vue
        return response()->json([
            'status' => true,
            'success' => true,
            'kelas' => $siswa->kategori ? $siswa->kategori->nama_kategori : '-',
            'data' => $jadwal
        ], 200);
    }

    /**
     * API Pembayaran
     */
    public function getPembayaran($id)
    {
        $siswa = $this->getAnggotaByUserId($id);
        
        if (!$siswa) {
            $siswa = Anggota::find($id);
        }

        if (!$siswa) {
            return response()->json([
                'status' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $pembayaran = Pembayaran::where('anggota_id', $siswa->id)
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $pembayaran
        ]);
    }

    /**
     * API Evaluasi
     */
    public function getEvaluasi($id)
    {
        $siswa = $this->getAnggotaByUserId($id);
        
        if (!$siswa) {
            $siswa = Anggota::find($id);
        }

        if (!$siswa) {
            return response()->json([
                'status' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $evaluasi = Evaluasi::where('anggota_id', $siswa->id)
            ->orderBy('tanggal_evaluasi', 'asc')
            ->get();

        $label = [];
        $teknik = [];
        $disiplin = [];
        $kehadiran = [];

        foreach ($evaluasi as $item) {
            $label[] = Carbon::parse($item->tanggal_evaluasi)->format('d M Y');
            $teknik[] = (int) $item->nilai_teknik;
            $disiplin[] = (int) $item->nilai_kedisiplinan;
            $kehadiran[] = (int) $item->nilai_kehadiran;
        }

        return response()->json([
            'status' => true,
            'chart' => [
                'labels' => $label,
                'teknik' => $teknik,
                'disiplin' => $disiplin,
                'kehadiran' => $kehadiran
            ],
            'list' => $evaluasi
        ]);
    }
}