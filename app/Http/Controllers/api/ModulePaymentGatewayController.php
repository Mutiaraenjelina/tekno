<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ModulePaymentGatewayController extends Controller
{
    private function getMidtransServerKey(): ?string
    {
        return config('services.midtrans.server_key');
    }

    private function getMidtransBaseUrl(): string
    {
        return config('services.midtrans.is_production', false)
            ? 'https://app.midtrans.com'
            : 'https://app.sandbox.midtrans.com';
    }

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

        $serverKey = $this->getMidtransServerKey();
        if (empty($serverKey)) {
            return response()->json([
                'status' => 500,
                'message' => 'Konfigurasi Midtrans belum lengkap (server key belum diatur).',
            ], 500);
        }

        $user = DB::table('users')->where('id', $validated['user_id'])->first();
        $orderId = 'MID-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(6));

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) round($validated['amount']),
            ],
            'customer_details' => [
                'first_name' => $user->username ?? 'User',
                'email' => $user->email ?? null,
            ],
            'callbacks' => [
                'finish' => rtrim(config('app.url'), '/') . '/tagihan/status',
                'error' => rtrim(config('app.url'), '/') . '/tagihan/status',
                'pending' => rtrim(config('app.url'), '/') . '/tagihan/status',
            ],
        ];

        try {
            $response = Http::withBasicAuth($serverKey, '')
                ->acceptJson()
                ->post($this->getMidtransBaseUrl() . '/snap/v1/transactions', $payload);

            if (! $response->successful()) {
                Log::error('Midtrans create transaction failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return response()->json([
                    'status' => 502,
                    'message' => 'Gagal membuat transaksi Midtrans.',
                    'midtrans' => $response->json(),
                ], 502);
            }

            $midtransData = $response->json();
            $snapToken = $midtransData['token'] ?? null;
            $paymentUrl = $midtransData['redirect_url'] ?? null;

            if (! $snapToken || ! $paymentUrl) {
                Log::error('Midtrans response missing token/redirect_url', ['response' => $midtransData]);
                return response()->json([
                    'status' => 502,
                    'message' => 'Response Midtrans tidak lengkap.',
                ], 502);
            }
        } catch (\Throwable $e) {
            Log::error('Midtrans request exception', ['error' => $e->getMessage()]);

            return response()->json([
                'status' => 502,
                'message' => 'Tidak dapat terhubung ke Midtrans.',
            ], 502);
        }

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
            'status_code' => ['required', 'string'],
            'gross_amount' => ['required', 'string'],
            'signature_key' => ['required', 'string'],
        ]);

        $serverKey = $this->getMidtransServerKey();
        if (empty($serverKey)) {
            return response()->json(['status' => 500, 'message' => 'Server key Midtrans belum diset.'], 500);
        }

        $expectedSignature = hash('sha512',
            $validated['order_id'] .
            $validated['status_code'] .
            $validated['gross_amount'] .
            $serverKey
        );

        if (! hash_equals($expectedSignature, $validated['signature_key'])) {
            Log::warning('Midtrans callback signature mismatch', [
                'order_id' => $validated['order_id'],
            ]);

            return response()->json(['status' => 403, 'message' => 'Signature callback tidak valid.'], 403);
        }

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
