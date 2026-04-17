<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModulePelangganController extends Controller
{
    public function index()
    {
        $pelangganList = DB::table('pelanggan')
            ->leftJoin('users as u', function ($join) {
                $join->on('u.idPersonal', '=', 'pelanggan.id')
                    ->where('u.roleId', '=', 3);
            })
            ->select(
                'pelanggan.*',
                DB::raw('COUNT(u.id) as linked_user_count'),
                DB::raw("GROUP_CONCAT(u.username ORDER BY u.username SEPARATOR ', ') as linked_usernames")
            )
            ->groupBy('pelanggan.id', 'pelanggan.nama', 'pelanggan.no_wa', 'pelanggan.created_at', 'pelanggan.updated_at')
            ->orderByDesc('id')
            ->get();

        return view('admin.TagihanDanPembayaran.ModulePelanggan.index', compact('pelangganList'));
    }

    public function create()
    {
        $userOptions = DB::table('users')
            ->where('roleId', 3)
            ->select('id', 'username', 'email', 'idPersonal')
            ->orderBy('username')
            ->get();

        return view('admin.TagihanDanPembayaran.ModulePelanggan.create', compact('userOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'max:30'],
            'user_ids' => ['nullable', 'array'],
            'user_ids.*' => ['integer', 'exists:users,id'],
        ]);

        $selectedUsers = $validated['user_ids'] ?? [];

        DB::beginTransaction();

        try {
            $id = DB::table('pelanggan')->insertGetId([
                'nama' => $validated['nama'],
                'no_wa' => $validated['no_wa'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (!empty($selectedUsers)) {
                DB::table('users')
                    ->whereIn('id', $selectedUsers)
                    ->where('roleId', 3)
                    ->update([
                        'idPersonal' => $id,
                        'updated_at' => now(),
                    ]);
            }

            DB::commit();

            $message = 'Pelanggan berhasil dibuat dengan ID: ' . $id;
            if (!empty($selectedUsers)) {
                $message .= ' dan terhubung ke ' . count($selectedUsers) . ' akun user.';
            }

            return redirect()->route('ModulePelanggan.index')->with('success', $message);
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat pelanggan. Silakan coba lagi.');
        }
    }

    public function edit($id)
    {
        $pelanggan = DB::table('pelanggan')->where('id', $id)->first();

        if (!$pelanggan) {
            return redirect()->route('ModulePelanggan.index')->with('error', 'Pelanggan tidak ditemukan.');
        }

        $userOptions = DB::table('users')
            ->where('roleId', 3)
            ->select('id', 'username', 'email', 'idPersonal')
            ->orderBy('username')
            ->get();

        $linkedUserIds = DB::table('users')
            ->where('roleId', 3)
            ->where('idPersonal', $id)
            ->pluck('id')
            ->toArray();

        return view('admin.TagihanDanPembayaran.ModulePelanggan.edit', compact('pelanggan', 'userOptions', 'linkedUserIds'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'max:30'],
            'user_ids' => ['nullable', 'array'],
            'user_ids.*' => ['integer', 'exists:users,id'],
        ]);

        $selectedUsers = $validated['user_ids'] ?? [];

        DB::beginTransaction();

        try {
            $exists = DB::table('pelanggan')->where('id', $id)->exists();
            if (!$exists) {
                DB::rollBack();
                return redirect()->route('ModulePelanggan.index')->with('error', 'Pelanggan tidak ditemukan.');
            }

            DB::table('pelanggan')->where('id', $id)->update([
                'nama' => $validated['nama'],
                'no_wa' => $validated['no_wa'],
                'updated_at' => now(),
            ]);

            // Reset relasi user role 3 yang sebelumnya terhubung ke pelanggan ini.
            DB::table('users')
                ->where('roleId', 3)
                ->where('idPersonal', $id)
                ->update([
                    'idPersonal' => null,
                    'updated_at' => now(),
                ]);

            // Set ulang user terpilih agar terhubung ke pelanggan ini.
            if (!empty($selectedUsers)) {
                DB::table('users')
                    ->whereIn('id', $selectedUsers)
                    ->where('roleId', 3)
                    ->update([
                        'idPersonal' => $id,
                        'updated_at' => now(),
                    ]);
            }

            DB::commit();

            return redirect()->route('ModulePelanggan.index')
                ->with('success', 'Pelanggan berhasil diubah dan relasi user diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengubah pelanggan. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            DB::table('users')
                ->where('roleId', 3)
                ->where('idPersonal', $id)
                ->update([
                    'idPersonal' => null,
                    'updated_at' => now(),
                ]);

            $deleted = DB::table('pelanggan')->where('id', $id)->delete();

            if (!$deleted) {
                DB::rollBack();
                return redirect()->route('ModulePelanggan.index')->with('error', 'Pelanggan tidak ditemukan.');
            }

            DB::commit();

            return redirect()->route('ModulePelanggan.index')
                ->with('success', 'Pelanggan berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('ModulePelanggan.index')->with('error', 'Gagal menghapus pelanggan.');
        }
    }
}
