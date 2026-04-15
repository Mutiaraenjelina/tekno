<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ModuleTagihanController extends Controller
{
    public function index()
    {
        $tagihanList = DB::table('tagihan')
            ->orderByDesc('id')
            ->get();

        return view('admin.TagihanDanPembayaran.ModuleTagihan.index', compact('tagihanList'));
    }

    public function create()
    {
        return view('admin.TagihanDanPembayaran.ModuleTagihan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tagihan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'tipe' => ['required', 'in:rutin,sekali'],
            'jatuh_tempo' => ['required', 'date'],
        ]);

        $id = DB::table('tagihan')->insertGetId([
            'nama_tagihan' => $validated['nama_tagihan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'nominal' => $validated['nominal'],
            'tipe' => $validated['tipe'],
            'jatuh_tempo' => $validated['jatuh_tempo'],
            'created_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('ModuleTagihan.index')
            ->with('success', 'Tagihan berhasil dibuat dengan ID: ' . $id);
    }

    public function edit($id)
    {
        $tagihan = DB::table('tagihan')->where('id', $id)->first();

        if (!$tagihan) {
            return redirect()->route('ModuleTagihan.index')->with('error', 'Tagihan tidak ditemukan.');
        }

        return view('admin.TagihanDanPembayaran.ModuleTagihan.edit', compact('tagihan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_tagihan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'tipe' => ['required', 'in:rutin,sekali'],
            'jatuh_tempo' => ['required', 'date'],
        ]);

        $updated = DB::table('tagihan')->where('id', $id)->update([
            'nama_tagihan' => $validated['nama_tagihan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'nominal' => $validated['nominal'],
            'tipe' => $validated['tipe'],
            'jatuh_tempo' => $validated['jatuh_tempo'],
            'updated_at' => now(),
        ]);

        if (!$updated) {
            return redirect()->route('ModuleTagihan.index')->with('error', 'Tagihan tidak ditemukan.');
        }

        return redirect()->route('ModuleTagihan.index')
            ->with('success', 'Tagihan berhasil diubah.');
    }

    public function destroy($id)
    {
        // Cascade delete: remove tagihan_user and transaksi related to this tagihan
        DB::table('tagihan_user')->where('tagihan_id', $id)->delete();
        DB::table('transaksi')->where('tagihan_id', $id)->delete();
        
        $deleted = DB::table('tagihan')->where('id', $id)->delete();

        if (!$deleted) {
            return redirect()->route('ModuleTagihan.index')->with('error', 'Tagihan tidak ditemukan.');
        }

        return redirect()->route('ModuleTagihan.index')
            ->with('success', 'Tagihan berhasil dihapus beserta relasi dan transaksinya.');
    }
}
