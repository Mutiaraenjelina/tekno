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
            ->orderByDesc('id')
            ->get();

        return view('admin.TagihanDanPembayaran.ModulePelanggan.index', compact('pelangganList'));
    }

    public function create()
    {
        return view('admin.TagihanDanPembayaran.ModulePelanggan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'max:30'],
        ]);

        $id = DB::table('pelanggan')->insertGetId([
            'nama' => $validated['nama'],
            'no_wa' => $validated['no_wa'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('ModulePelanggan.index')
            ->with('success', 'Pelanggan berhasil dibuat dengan ID: ' . $id);
    }

    public function edit($id)
    {
        $pelanggan = DB::table('pelanggan')->where('id', $id)->first();

        if (!$pelanggan) {
            return redirect()->route('ModulePelanggan.index')->with('error', 'Pelanggan tidak ditemukan.');
        }

        return view('admin.TagihanDanPembayaran.ModulePelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'max:30'],
        ]);

        $updated = DB::table('pelanggan')->where('id', $id)->update([
            'nama' => $validated['nama'],
            'no_wa' => $validated['no_wa'],
            'updated_at' => now(),
        ]);

        if (!$updated) {
            return redirect()->route('ModulePelanggan.index')->with('error', 'Pelanggan tidak ditemukan.');
        }

        return redirect()->route('ModulePelanggan.index')
            ->with('success', 'Pelanggan berhasil diubah.');
    }

    public function destroy($id)
    {
        $deleted = DB::table('pelanggan')->where('id', $id)->delete();

        if (!$deleted) {
            return redirect()->route('ModulePelanggan.index')->with('error', 'Pelanggan tidak ditemukan.');
        }

        return redirect()->route('ModulePelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
