<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ModulePaymentGatewayController extends Controller
{
    public function createPayment(Request $request)
    {
        $validated = $request->validate([
            'tagihan_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        if (! DB::table('tagihan')->where('id', $validated['tagihan_id'])->exists()) {
            return response()->json(['status' => 422, 'message' => 'Tagihan tidak valid.'], 422);
        }

        if (! DB::table('users')->where('id', $validated['user_id'])->exists()) {
            return response()->json(['status' => 422, 'message' => 'User tidak valid.'], 422);
        }

        $orderId = 'MID-' . strtoupper(Str::random(12));
        $snapToken = 'snap_' . Str::random(24);
        $paymentUrl = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken;

        $transaksiId = DB::table('transaksi')->insertGetId([
            'order_id' => $orderId,
            'status' => 'pending',
            'amount' => $validated['amount'],
            'metode' => 'midtrans',
            'tagihan_id' => $validated['tagihan_id'],
            'user_id' => $validated['user_id'],
            'snap_token' => $snapToken,
            'payment_url' => $paymentUrl,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tagihan_user')->updateOrInsert(
            ['tagihan_id' => $validated['tagihan_id'], 'user_id' => $validated['user_id']],
            [
                'status' => 'belum',
                'payment_id' => $transaksiId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return response()->json([
            'status' => 200,
            'data' => [
                'order_id' => $orderId,
                'snap_token' => $snapToken,
                'payment_url' => $paymentUrl,
            ],
        ]);
    }

    public function midtransCallback(Request $request)
    {
        $validated = $request->validate([
            'order_id' => ['required', 'string'],
            'transaction_status' => ['required', 'string'],
        ]);

        $trx = DB::table('transaksi')->where('order_id', $validated['order_id'])->first();
        if (! $trx) {
            return response()->json(['status' => 404, 'message' => 'Order tidak ditemukan.'], 404);
        }

        $statusMap = [
            'settlement' => 'success',
            'capture' => 'success',
            'pending' => 'pending',
            'expire' => 'expired',
            'cancel' => 'failed',
            'deny' => 'failed',
            'failure' => 'failed',
        ];

        $newStatus = $statusMap[$validated['transaction_status']] ?? 'pending';

        DB::table('transaksi')->where('id', $trx->id)->update([
            'status' => $newStatus,
            'updated_at' => now(),
        ]);

        DB::table('tagihan_user')
            ->where('tagihan_id', $trx->tagihan_id)
            ->where('user_id', $trx->user_id)
            ->update([
                'status' => $newStatus === 'success' ? 'sudah' : 'belum',
                'payment_id' => $trx->id,
                'updated_at' => now(),
            ]);

        return response()->json(['status' => 200, 'message' => 'Callback diproses.']);
    }
}
