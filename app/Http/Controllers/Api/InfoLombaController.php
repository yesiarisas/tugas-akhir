<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InfoLomba;

class InfoLombaController extends Controller
{
    public function index()
    {
        $data = InfoLomba::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function detail($id)
    {
        $data = InfoLomba::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}