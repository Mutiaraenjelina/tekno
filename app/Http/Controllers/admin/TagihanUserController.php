<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TagihanUserController extends Controller
{
    public function index()
    {
        if (! Schema::hasTable('tagihan_user')) {
            return redirect()->route('Dashboard.index')->with('error', 'Tabel tagihan_user belum tersedia.');
        }

        $assignments = DB::table('tagihan_user as tu')
            ->leftJoin('users as u', 'u.id', '=', 'tu.user_id')
            ->leftJoin('tagihan as t', 't.id', '=', 'tu.tagihan_id')
            ->leftJoin('transaksi as tr', 'tr.id', '=', 'tu.payment_id')
            ->select(
                'tu.id',
                'tu.tagihan_id',
                'tu.user_id',
                'tu.status',
                'tu.payment_id',
                'u.username',
                'u.email',
                't.nama_tagihan',
                't.nominal',
                't.jatuh_tempo',
                'tr.order_id',
                'tr.status as transaksi_status'
            )
            ->orderByDesc('tu.id')
            ->get();

        $tagihanOptions = DB::table('tagihan')
            ->select('id', 'nama_tagihan', 'nominal', 'jatuh_tempo')
            ->orderByDesc('id')
            ->limit(300)
            ->get();

        $userOptions = DB::table('users as u')
            ->leftJoin('pelanggan as p', 'p.id', '=', 'u.idPersonal')
            ->select('u.id', 'u.username', 'u.email', 'p.nama as namaPelanggan')
            ->orderBy('u.username')
            ->get();

        return view('admin.TagihanDanPembayaran.TagihanUser.index', compact('assignments', 'tagihanOptions', 'userOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tagihan_id' => ['nullable', 'integer', 'required_without:tagihan_id_manual'],
            'tagihan_id_manual' => ['nullable', 'integer', 'required_without:tagihan_id'],
            'user_id' => ['required', 'integer'],
            'status' => ['required', 'in:belum,sudah'],
            'payment_id' => ['nullable', 'integer', 'exists:transaksi,id'],
        ], [
            'tagihan_id.required_without' => 'Pilih tagihan dari dropdown atau isi ID tagihan manual.',
            'tagihan_id_manual.required_without' => 'Isi ID tagihan manual atau pilih dari dropdown.',
            'tagihan_id.integer' => 'Tagihan dari dropdown tidak valid.',
            'tagihan_id_manual.integer' => 'ID tagihan manual harus berupa angka.',
            'user_id.required' => 'User wajib dipilih.',
            'user_id.integer' => 'User tidak valid.',
            'payment_id.integer' => 'Payment ID harus berupa angka.',
            'payment_id.exists' => 'Payment ID tidak ditemukan di data transaksi.',
        ]);

        $tagihanId = (int) ($validated['tagihan_id_manual'] ?? $validated['tagihan_id']);

        $relationError = $this->validateTagihanUserRelation($tagihanId, $validated['user_id']);
        if ($relationError) {
            return redirect()->route('TagihanUser.index')->with('error', $relationError);
        }

        $exists = DB::table('tagihan_user')
            ->where('tagihan_id', $tagihanId)
            ->where('user_id', $validated['user_id'])
            ->exists();

        if ($exists) {
            return redirect()->route('TagihanUser.index')->with('error', 'Assignment sudah ada.');
        }

        DB::table('tagihan_user')->insert([
            'tagihan_id' => $tagihanId,
            'user_id' => $validated['user_id'],
            'status' => $validated['status'],
            'payment_id' => $validated['payment_id'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('TagihanUser.index')->with('success', 'Assignment berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $assignment = DB::table('tagihan_user')->where('id', $id)->first();

        if (! $assignment) {
            return redirect()->route('TagihanUser.index')->with('error', 'Assignment tidak ditemukan.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:belum,sudah'],
            'payment_id' => ['nullable', 'integer', 'exists:transaksi,id'],
        ], [
            'payment_id.integer' => 'Payment ID harus berupa angka.',
            'payment_id.exists' => 'Payment ID tidak ditemukan di data transaksi.',
        ]);

        DB::table('tagihan_user')->where('id', $id)->update([
            'status' => $validated['status'],
            'payment_id' => $validated['payment_id'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->route('TagihanUser.index')->with('success', 'Assignment berhasil diperbarui.');
    }

    public function delete($id)
    {
        DB::table('tagihan_user')->where('id', $id)->delete();

        return redirect()->route('TagihanUser.index')->with('success', 'Assignment berhasil dihapus.');
    }

    private function validateTagihanUserRelation(int $tagihanId, int $userId): ?string
    {
        $tagihanData = DB::table('tagihan')
            ->select('id')
            ->where('id', $tagihanId)
            ->first();

        $userData = DB::table('users')->select('idPersonal')->where('id', $userId)->first();

        if (! $tagihanData) {
            return 'Tagihan tidak ditemukan. Periksa ID tagihan yang dipilih/diinput.';
        }

        if (! $userData) {
            return 'User tidak ditemukan. Silakan pilih user yang valid.';
        }

        if (! DB::table('pelanggan')->where('id', $userData->idPersonal)->exists()) {
            return 'User tidak terkait dengan data pelanggan.';
        }

        return null;
    }
}
