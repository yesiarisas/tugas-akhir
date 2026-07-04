<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Pendaftar;

class AuthSiswaController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([

            'pendaftar_id' => 'required',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|min:6'

        ]);

        $pendaftar = Pendaftar::find($request->pendaftar_id);

        if (!$pendaftar) {

            return response()->json([

                'success' => false,

                'message' => 'Pendaftar tidak ditemukan'

            ]);
        }

        if ($pendaftar->status != 'diterima') {

            return response()->json([

                'success' => false,

                'message' => 'Pendaftaran belum diterima admin'

            ]);
        }

        if ($pendaftar->sudah_register == true) {

            return response()->json([

                'success' => false,

                'message' => 'Akun sudah dibuat'

            ]);
        }

        $user = User::create([

            'name' => $pendaftar->nama_pendaftar,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'role' => 'siswa'

        ]);

        $pendaftar->update([

            'sudah_register' => true

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Register berhasil'

        ]);
    }

    public function login(Request $request)
    {
        $request->validate([

            'email' => 'required|email',

            'password' => 'required'

        ]);

        $user = User::where('email', $request->email)
                    ->first();

        if (!$user) {

            return response()->json([

                'success' => false,

                'message' => 'Email tidak ditemukan'

            ]);
        }

        if (!Hash::check($request->password, $user->password)) {

            return response()->json([

                'success' => false,

                'message' => 'Password salah'

            ]);
        }

        return response()->json([

            'success' => true,

            'message' => 'Login berhasil',

            'user' => $user

        ]);
    }
}