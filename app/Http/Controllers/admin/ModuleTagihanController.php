<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ModuleTagihanController extends Controller
{
    private function isSuperAdmin(): bool
    {
        return Auth::check() && (string) Auth::user()->roleId === '1';
    }

    private function tagihanScope()
    {
        $query = DB::table('tagihan');

        if (! $this->isSuperAdmin()) {
            $query->where('created_by', Auth::id());
        }

        return $query;
    }

    public function index()
    {
        $tagihanList = $this->tagihanScope()
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

        $createdBy = $this->isSuperAdmin() ? Auth::id() : Auth::id();

        $id = DB::table('tagihan')->insertGetId([
            'nama_tagihan' => $validated['nama_tagihan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'nominal' => $validated['nominal'],
            'tipe' => $validated['tipe'],
            'jatuh_tempo' => $validated['jatuh_tempo'],
            'created_by' => $createdBy,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('ModuleTagihan.index')
            ->with('success', 'Tagihan berhasil dibuat dengan ID: ' . $id);
    }

    public function edit($id)
    {
        $tagihan = $this->tagihanScope()->where('id', $id)->first();

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

        $updated = $this->tagihanScope()->where('id', $id)->update([
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
        $tagihan = $this->tagihanScope()->where('id', $id)->first();

        if (! $tagihan) {
            return redirect()->route('ModuleTagihan.index')->with('error', 'Tagihan tidak ditemukan.');
        }

        // Cascade delete: remove tagihan_user and transaksi related to this tagihan
        DB::table('tagihan_user')->where('tagihan_id', $id)->delete();
        DB::table('transaksi')->where('tagihan_id', $id)->delete();
        
        $deleted = $this->tagihanScope()->where('id', $id)->delete();

        if (!$deleted) {
            return redirect()->route('ModuleTagihan.index')->with('error', 'Tagihan tidak ditemukan.');
        }

        return redirect()->route('ModuleTagihan.index')
            ->with('success', 'Tagihan berhasil dihapus beserta relasi dan transaksinya.');
    }
}
