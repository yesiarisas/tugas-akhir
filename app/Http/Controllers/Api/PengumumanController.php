<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::where('status', 'tampil')
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json($pengumuman);
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        return response()->json($pengumuman);
    }
}