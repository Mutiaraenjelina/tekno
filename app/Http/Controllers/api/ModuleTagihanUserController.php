<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleTagihanUserController extends Controller
{
    public function index()
    {
        $rows = DB::table('tagihan_user as tu')
            ->leftJoin('tagihan as t', 't.id', '=', 'tu.tagihan_id')
            ->leftJoin('users as u', 'u.id', '=', 'tu.user_id')
            ->leftJoin('transaksi as tr', 'tr.id', '=', 'tu.payment_id')
            ->select('tu.*', 't.nama_tagihan', 'u.username', 'u.email', 'tr.order_id', 'tr.status as transaksi_status')
            ->orderByDesc('tu.id')
            ->get();

        return response()->json(['status' => 200, 'data' => $rows]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tagihan_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'status' => ['nullable', 'in:belum,sudah'],
            'payment_id' => ['nullable', 'integer'],
        ]);

        $tagihanExists = DB::table('tagihan')->where('id', $validated['tagihan_id'])->exists();
        $user = DB::table('users')->where('id', $validated['user_id'])->first();

        if (! $tagihanExists || ! $user) {
            return response()->json(['status' => 422, 'message' => 'Tagihan atau user tidak valid.'], 422);
        }

        // Validate that assigned user is linked to a pelanggan (idPersonal must exist in pelanggan table).
        $pelangganLinked = DB::table('pelanggan')->where('id', $user->idPersonal)->exists();
        if (! $pelangganLinked) {
            return response()->json(['status' => 422, 'message' => 'User tidak terhubung ke data pelanggan.'], 422);
        }

        $exists = DB::table('tagihan_user')
            ->where('tagihan_id', $validated['tagihan_id'])
            ->where('user_id', $validated['user_id'])
            ->exists();

        if ($exists) {
            return response()->json(['status' => 409, 'message' => 'Relasi tagihan-user sudah ada.'], 409);
        }

        $id = DB::table('tagihan_user')->insertGetId([
            'tagihan_id' => $validated['tagihan_id'],
            'user_id' => $validated['user_id'],
            'status' => $validated['status'] ?? 'belum',
            'payment_id' => $validated['payment_id'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 200, 'message' => 'Relasi berhasil dibuat.', 'id' => $id]);
    }

    public function show($id)
    {
        $row = DB::table('tagihan_user as tu')
            ->leftJoin('tagihan as t', 't.id', '=', 'tu.tagihan_id')
            ->leftJoin('users as u', 'u.id', '=', 'tu.user_id')
            ->leftJoin('transaksi as tr', 'tr.id', '=', 'tu.payment_id')
            ->select('tu.*', 't.nama_tagihan', 'u.username', 'u.email', 'tr.order_id', 'tr.status as transaksi_status')
            ->where('tu.id', $id)
            ->first();

        if (! $row) {
            return response()->json(['status' => 404, 'message' => 'Relasi tidak ditemukan.'], 404);
        }

        return response()->json(['status' => 200, 'data' => $row]);
    }

    public function update(Request $request, $id)
    {
        $assignment = DB::table('tagihan_user')->where('id', $id)->first();
        if (! $assignment) {
            return response()->json(['status' => 404, 'message' => 'Relasi tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'status' => ['required', 'in:belum,sudah'],
            'payment_id' => ['nullable', 'integer'],
        ]);

        if (! empty($validated['payment_id'])) {
            $paymentExists = DB::table('transaksi')->where('id', $validated['payment_id'])->exists();
            if (! $paymentExists) {
                return response()->json(['status' => 422, 'message' => 'payment_id tidak valid.'], 422);
            }
        }

        DB::table('tagihan_user')->where('id', $id)->update([
            'status' => $validated['status'],
            'payment_id' => $validated['payment_id'] ?? null,
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 200, 'message' => 'Relasi diubah.']);
    }

    public function destroy($id)
    {
        $deleted = DB::table('tagihan_user')->where('id', $id)->delete();

        if (! $deleted) {
            return response()->json(['status' => 404, 'message' => 'Relasi tidak ditemukan.'], 404);
        }

        return response()->json(['status' => 200, 'message' => 'Relasi dihapus.']);
    }
}
