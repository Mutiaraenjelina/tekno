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
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nama_usaha' => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:30'],
            'jenis_usaha' => ['required', 'string', 'max:100'],
            'jenis_tagihan' => ['required', 'in:rutin,non-rutin'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_usaha.required' => 'Nama usaha wajib diisi.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'jenis_usaha.required' => 'Jenis usaha wajib dipilih.',
            'jenis_tagihan.required' => 'Jenis tagihan wajib dipilih.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // users.idPersonal pada schema aktif wajib terisi.
        $pelangganId = DB::table('pelanggan')->insertGetId([
            'nama' => $validated['nama_lengkap'],
            'no_wa' => $validated['no_telepon'],
            'nama_usaha' => $validated['nama_usaha'],
            'jenis_usaha' => $validated['jenis_usaha'],
            'jenis_tagihan' => $validated['jenis_tagihan'],
            'is_umkm_verified' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::create([
            'roleId' => 2,
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
                'role_id' => $user->roleId,
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

        $user = JWTAuth::setToken($token)->toUser();

        return response()->json([
            'status' => 200,
            'message' => 'Login berhasil.',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'role_id' => (int) $user->roleId,
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
