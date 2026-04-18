<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PelangganController extends Controller
{
    /**
     * Show logged-in user's pelanggan profile (if any).
     */
    public function index()
    {
        $user = Auth::user();

        $pelanggan = DB::table('pelanggan')
            ->where('id', $user->idPersonal)
            ->first();

        return view('user.Pelanggan.index', compact('user', 'pelanggan'));
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            return redirect()->route('user.pelanggan.index')->with('error', 'Password saat ini tidak benar.');
        }

        DB::table('users')->where('id', $user->id)->update([
            'password' => Hash::make($validated['new_password']),
            'updated_at' => now(),
        ]);

        return redirect()->route('user.pelanggan.index')->with('success', 'Password berhasil diubah.');
    }

    public function updateAccount(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'no_wa' => ['required', 'string', 'max:30'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
        ]);

        DB::beginTransaction();

        try {
            DB::table('users')->where('id', $user->id)->update([
                'username' => $validated['username'],
                'email' => $validated['email'] ?? null,
                'updated_at' => now(),
            ]);

            if ($user->idPersonal) {
                DB::table('pelanggan')->where('id', $user->idPersonal)->update([
                    'no_wa' => $validated['no_wa'],
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('user.pelanggan.index')->with('success', 'Data akun berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->route('user.pelanggan.index')->with('error', 'Gagal memperbarui data akun.');
        }
    }
}
