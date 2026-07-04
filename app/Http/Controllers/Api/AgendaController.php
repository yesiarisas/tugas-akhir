<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agenda;

class AgendaController extends Controller
{
    // LIST AGENDA
    public function index()
    {
        $agenda = Agenda::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $agenda
        ]);
    }

    // DETAIL AGENDA
    public function show($id)
    {
        $agenda = Agenda::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $agenda
        ]);
    }
}