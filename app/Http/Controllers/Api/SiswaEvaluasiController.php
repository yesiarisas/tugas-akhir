<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Evaluasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiswaEvaluasiController extends Controller
{
    /**
     * Mengambil data grafik perkembangan dan catatan evaluasi latihan siswa.
     * Endpoint: GET /api/siswa/evaluasi/{id}
     */
    public function getEvaluasiSiswa($id)
    {
        // 1. Validasi keberadaan data siswa/anggota
        $anggota = Anggota::find($id);
        if (!$anggota) {
            return response()->json([
                'status' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ], 404);
        }

        // 2. Ambil data evaluasi (diurutkan dari yang terlama ke terbaru untuk akurasi linimasa grafik)
        $evaluasi = Evaluasi::where('anggota_id', $id)
            ->orderBy('tanggal_evaluasi', 'asc')
            ->get();

        $labels = [];
        $teknik = [];
        $disiplin = [];
        $kehadiran = [];
        $catatanSiswa = [];

        // 3. Transformasi data agar sesuai dengan format Chart dan UI Frontend
        foreach ($evaluasi as $item) {
            // Membuat penamaan label sumbu X. Contoh: "Jan-M1" (Januari Minggu ke-1)
            $bulan = Carbon::parse($item->tanggal_evaluasi)->translatedFormat('M');
            $tanggal = Carbon::parse($item->tanggal_evaluasi);
            $minggu = ceil($tanggal->day / 7);
            
            $labels[] = $bulan . '-M' . $minggu;

            // Memasukkan nilai angka penilaian aspek ke array masing-masing
            $teknik[] = (int) $item->nilai_teknik;
            $disiplin[] = (int) $item->nilai_kedisiplinan;
            $kehadiran[] = (int) $item->nilai_kehadiran;

            // Kumpulkan catatan evaluasi dari pelatih jika ada
            if (!empty($item->catatan)) {
                $catatanSiswa[] = [
                    'tanggal' => Carbon::parse($item->tanggal_evaluasi)->translatedFormat('d F Y'),
                    'isi' => $item->catatan
                ];
            }
        }

        // Membalikkan urutan list catatan agar catatan evaluasi paling baru muncul di urutan teratas
        $catatanSiswa = array_reverse($catatanSiswa);

        // 4. Kirim response JSON ke aplikasi frontend
        return response()->json([
            'status' => true,
            'nama_siswa' => $anggota->nama,
            'chart_data' => [
                'labels' => $labels,
                'series' => [
                    [
                        'name' => 'Teknik',
                        'data' => $teknik
                    ],
                    [
                        'name' => 'Disiplin',
                        'data' => $disiplin
                    ],
                    [
                        'name' => 'Kehadiran',
                        'data' => $kehadiran
                    ]
                ]
            ],
            'catatan' => $catatanSiswa
        ], 200);
    }
}