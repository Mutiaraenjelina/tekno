<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleTagihanController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 200,
            'data' => DB::table('tagihan')->orderByDesc('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tagihan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'tipe' => ['required', 'in:rutin,sekali'],
            'jatuh_tempo' => ['required', 'date'],
            'created_by' => ['required', 'integer'],
        ]);

        $id = DB::table('tagihan')->insertGetId([
            'nama_tagihan' => $validated['nama_tagihan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'nominal' => $validated['nominal'],
            'tipe' => $validated['tipe'],
            'jatuh_tempo' => $validated['jatuh_tempo'],
            'created_by' => $validated['created_by'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 200, 'message' => 'Tagihan dibuat.', 'id' => $id]);
    }

    public function show($id)
    {
        $tagihan = DB::table('tagihan')->where('id', $id)->first();

        if (! $tagihan) {
            return response()->json(['status' => 404, 'message' => 'Tagihan tidak ditemukan.'], 404);
        }

        $assignments = DB::table('tagihan_user as tu')
            ->leftJoin('users as u', 'u.id', '=', 'tu.user_id')
            ->leftJoin('transaksi as tr', 'tr.id', '=', 'tu.payment_id')
            ->select('tu.id', 'tu.user_id', 'tu.status', 'tu.payment_id', 'u.username', 'u.email', 'tr.order_id', 'tr.status as transaksi_status')
            ->where('tu.tagihan_id', $id)
            ->get();

        return response()->json([
            'status' => 200,
            'data' => [
                'tagihan' => $tagihan,
                'assignments' => $assignments,
            ],
        ]);
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

        if (! $updated) {
            return response()->json(['status' => 404, 'message' => 'Tagihan tidak ditemukan.'], 404);
        }

        return response()->json(['status' => 200, 'message' => 'Tagihan diubah.']);
    }

    public function destroy($id)
    {
        DB::table('tagihan_user')->where('tagihan_id', $id)->delete();
        DB::table('transaksi')->where('tagihan_id', $id)->delete();
        $deleted = DB::table('tagihan')->where('id', $id)->delete();

        if (! $deleted) {
            return response()->json(['status' => 404, 'message' => 'Tagihan tidak ditemukan.'], 404);
        }

        return response()->json(['status' => 200, 'message' => 'Tagihan dihapus.']);
    }
}
