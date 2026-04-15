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
            'nama' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $pelangganId = DB::table('pelanggan')->insertGetId([
            'nama' => $validated['nama'],
            'no_wa' => $validated['no_wa'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::create([
            'roleId' => 3,
            'idJenisUser' => 1,
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
