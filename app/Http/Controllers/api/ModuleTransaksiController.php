<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ModuleTransaksiController extends Controller
{
    public function createTransaksi(Request $request)
    {
        $validated = $request->validate([
            'tagihan_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric', 'min:0'],
            'metode' => ['nullable', 'string', 'max:50'],
            'status' => ['nullable', 'in:pending,success,failed,expired'],
            'order_id' => ['nullable', 'string', 'max:100'],
        ]);

        if (! DB::table('tagihan')->where('id', $validated['tagihan_id'])->exists()) {
            return response()->json(['status' => 422, 'message' => 'Tagihan tidak valid.'], 422);
        }

        if (! DB::table('users')->where('id', $validated['user_id'])->exists()) {
            return response()->json(['status' => 422, 'message' => 'User tidak valid.'], 422);
        }

        $orderId = $validated['order_id'] ?? ('ORD-' . strtoupper(Str::random(10)));

        $transaksiId = DB::table('transaksi')->insertGetId([
            'order_id' => $orderId,
            'status' => $validated['status'] ?? 'pending',
            'amount' => $validated['amount'],
            'metode' => $validated['metode'] ?? 'midtrans',
            'tagihan_id' => $validated['tagihan_id'],
            'user_id' => $validated['user_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tagihan_user')->updateOrInsert(
            ['tagihan_id' => $validated['tagihan_id'], 'user_id' => $validated['user_id']],
            [
                'status' => ($validated['status'] ?? 'pending') === 'success' ? 'sudah' : 'belum',
                'payment_id' => $transaksiId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return response()->json([
            'status' => 200,
            'message' => 'Transaksi berhasil dibuat.',
            'data' => [
                'id' => $transaksiId,
                'order_id' => $orderId,
            ],
        ]);
    }

    public function updateStatusPembayaran(Request $request)
    {
        $validated = $request->validate([
            'order_id' => ['nullable', 'string'],
            'tagihan_id' => ['nullable', 'integer'],
            'user_id' => ['nullable', 'integer'],
            'status' => ['required', 'in:pending,success,failed,expired'],
        ]);

        if (empty($validated['order_id']) && (empty($validated['tagihan_id']) || empty($validated['user_id']))) {
            return response()->json([
                'status' => 422,
                'message' => 'Gunakan order_id atau pasangan tagihan_id dan user_id.',
            ], 422);
        }

        $trxQuery = DB::table('transaksi');
        if (! empty($validated['order_id'])) {
            $trxQuery->where('order_id', $validated['order_id']);
        } else {
            $trxQuery
                ->where('tagihan_id', $validated['tagihan_id'])
                ->where('user_id', $validated['user_id'])
                ->latest('id');
        }

        $trx = $trxQuery->first();
        if (! $trx) {
            return response()->json(['status' => 404, 'message' => 'Transaksi tidak ditemukan.'], 404);
        }

        DB::table('transaksi')->where('id', $trx->id)->update([
            'status' => $validated['status'],
            'updated_at' => now(),
        ]);

        DB::table('tagihan_user')
            ->where('tagihan_id', $trx->tagihan_id)
            ->where('user_id', $trx->user_id)
            ->update([
                'status' => $validated['status'] === 'success' ? 'sudah' : 'belum',
                'payment_id' => $trx->id,
                'updated_at' => now(),
            ]);

        return response()->json(['status' => 200, 'message' => 'Status pembayaran diperbarui.']);
    }

    public function markManualCash(Request $request)
    {
        $validated = $request->validate([
            'tagihan_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric', 'min:0'],
            'order_id' => ['nullable', 'string', 'max:100'],
        ]);

        $request->merge([
            'metode' => 'cash',
            'status' => 'success',
            'order_id' => $validated['order_id'] ?? null,
        ]);

        return $this->createTransaksi($request);
    }
}
