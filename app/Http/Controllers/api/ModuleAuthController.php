<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ModuleAuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'jenis_tagihan' => ['required', 'in:rutin,non_rutin'],
            'nama' => ['required_if:jenis_tagihan,rutin', 'nullable', 'string', 'max:255'],
            'no_wa' => ['required_if:jenis_tagihan,rutin', 'nullable', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'jenis_tagihan.required' => 'Silakan pilih jenis tagihan usaha.',
            'jenis_tagihan.in' => 'Jenis tagihan tidak valid.',
            'nama.required_if' => 'Nama pelanggan wajib diisi untuk usaha tagihan rutin.',
            'no_wa.required_if' => 'No WhatsApp wajib diisi untuk usaha tagihan rutin.',
        ]);

        $pelangganId = null;

        if ($validated['jenis_tagihan'] === 'rutin') {
            $pelangganId = DB::table('pelanggan')->insertGetId([
                'nama' => $validated['nama'],
                'no_wa' => $validated['no_wa'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user = User::create([
            'roleId' => 3,
            'idJenisUser' => $validated['jenis_tagihan'] === 'rutin' ? 1 : 2,
            'idPersonal' => $pelangganId,
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Register berhasil.',
            'data' => [
                'user_id' => $user->id,
                'jenis_tagihan' => $validated['jenis_tagihan'],
                'pelanggan_id' => $pelangganId,
            ],
        ]);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (! $token = JWTAuth::attempt([
            'username' => $validated['username'],
            'password' => $validated['password'],
        ])) {
            return response()->json([
                'status' => 401,
                'message' => 'Username atau password salah.',
            ], 401);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Login berhasil.',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'status' => 200,
            'message' => 'Logout berhasil.',
        ]);
    }
}
