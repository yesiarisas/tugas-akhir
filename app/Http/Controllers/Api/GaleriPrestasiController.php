<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GaleriPrestasi;

class GaleriPrestasiController extends Controller
{
    public function index()
    {
        $galeri = GaleriPrestasi::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $galeri
        ]);
    }

    public function show($id)
    {
        $galeri = GaleriPrestasi::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $galeri
        ]);
    }
}