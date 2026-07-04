<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class SiswaPembayaranController extends Controller
{
    /**
     * Mengambil riwayat pembayaran iuran milik siswa tertentu
     * Endpoint: GET /api/siswa/pembayaran/{id}
     */
    public function getPembayaranSiswa($id)
    {
        try {
            // Menarik seluruh data pembayaran berdasarkan anggota_id siswa
            // Diurutkan dari tanggal bayar paling terbaru (descending)
            $pembayaran = Pembayaran::where('anggota_id', $id)
                ->orderBy('tanggal_bayar', 'desc')
                ->get();

            // Transformasi atau mapping data agar struktur JSON rapi saat dibaca Vue
            $riwayatData = $pembayaran->map(function ($item) {
                
                // Menentukan teks keterangan dinamis berdasarkan status pembayaran
                $keterangan = $item->status === 'lunas' 
                    ? 'Lunas Diterima oleh Admin' 
                    : 'Menunggu Konfirmasi / Belum Lunas';

                return [
                    'tanggal'    => $item->tanggal_bayar,
                    'jenis'      => ucfirst($item->jenis), // Format huruf kapital di awal kata (Contoh: Bulanan)
                    'periode'    => $item->periode ?? '-',
                    'nominal'    => (int) $item->nominal, // Memastikan data bertipe integer angka
                    'status'     => strtolower($item->status), // Memastikan teks status dalam huruf kecil (lunas/belum)
                    'keterangan' => $keterangan
                ];
            });

            // Mengirimkan response sukses dalam bentuk JSON
            return response()->json([
                'status'  => true,
                'message' => 'Berhasil mengambil riwayat pembayaran.',
                'data'    => $riwayatData
            ], 200);

        } catch (\Exception $e) {
            // Menangani error jika terjadi kendala pada query database atau server
            return response()->json([
                'status'  => false,
                'message' => 'Gagal memuat data riwayat pembayaran dari server: ' . $e->getMessage()
            ], 500);
        }
    }
}