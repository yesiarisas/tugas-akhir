<?php
// app/Http/Controllers/Api/HomepageController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Homepage;

class HomepageController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Homepage::first()
        ]);
    }
}