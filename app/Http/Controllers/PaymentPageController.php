<?php

namespace App\Http\Controllers;

use App\Http\Controllers\api\ModulePaymentGatewayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentPageController extends Controller
{
    private function mapGatewayStatusToLocal(string $gatewayStatus): string
    {
        $statusMap = [
            'settlement' => 'success',
            'capture' => 'success',
            'pending' => 'pending',
            'expire' => 'expired',
            'cancel' => 'failed',
            'deny' => 'failed',
            'failure' => 'failed',
        ];

        return $statusMap[strtolower($gatewayStatus)] ?? 'pending';
    }

    private function syncMidtransStatusByOrderId(string $orderId, int $userId): void
    {
        $serverKey = config('services.midtrans.server_key');
        if (empty($serverKey)) {
            return;
        }

        $trx = DB::table('transaksi')
            ->where('order_id', $orderId)
            ->where('user_id', $userId)
            ->first();

        if (! $trx) {
            return;
        }

        try {
            $baseUrl = config('services.midtrans.is_production', false)
                ? 'https://api.midtrans.com'
                : 'https://api.sandbox.midtrans.com';

            $response = Http::withBasicAuth($serverKey, '')
                ->acceptJson()
                ->get($baseUrl . '/v2/' . $orderId . '/status');

            if (! $response->successful()) {
                Log::warning('Failed syncing Midtrans status from payment status page', [
                    'order_id' => $orderId,
                    'http_status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return;
            }

            $gatewayStatus = (string) ($response->json('transaction_status') ?? 'pending');
            $newStatus = $this->mapGatewayStatusToLocal($gatewayStatus);

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
        } catch (\Throwable $e) {
            Log::warning('Exception syncing Midtrans status from payment status page', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function show(int $tagihanId, int $userId)
    {
        $tagihan = DB::table('tagihan')->where('id', $tagihanId)->first();
        $user = DB::table('users')->where('id', $userId)->first();
        $assignmentExists = DB::table('tagihan_user')
            ->where('tagihan_id', $tagihanId)
            ->where('user_id', $userId)
            ->exists();

        if (! $tagihan || ! $user || ! $assignmentExists) {
            abort(404);
        }

        if (Auth::check()) {
            return view('payment.page', compact('tagihan', 'user'));
        }

        return view('payment.guest', compact('tagihan', 'user'));
    }

    public function create(Request $request, int $tagihanId, int $userId)
    {
        $tagihan = DB::table('tagihan')->where('id', $tagihanId)->first();
        $user = DB::table('users')->where('id', $userId)->first();
        $assignmentExists = DB::table('tagihan_user')
            ->where('tagihan_id', $tagihanId)
            ->where('user_id', $userId)
            ->exists();

        if (! $tagihan || ! $user || ! $assignmentExists) {
            abort(404);
        }

        $statusUrl = rtrim($request->root(), '/') . '/payment/status/' . $tagihanId . '/' . $userId;

        $paymentRequest = $request->duplicate([], [
            'tagihan_id' => $tagihanId,
            'user_id' => $userId,
            'amount' => $tagihan->nominal,
            'status_url' => $statusUrl,
        ]);
        $paymentRequest->setMethod('POST');

        $response = app(ModulePaymentGatewayController::class)->createPayment($paymentRequest);
        $payload = $response->getData(true);

        if (($payload['status'] ?? null) !== 200) {
            return back()->with('error', $payload['message'] ?? 'Gagal membuat pembayaran.');
        }

        return Redirect::away($payload['data']['payment_url']);
    }

    public function status(Request $request, int $tagihanId, int $userId)
    {
        $tagihan = DB::table('tagihan')->where('id', $tagihanId)->first();
        $user = DB::table('users')->where('id', $userId)->first();

        if (! $tagihan || ! $user) {
            abort(404);
        }

        $orderId = $request->query('order_id');
        if (is_string($orderId) && $orderId !== '') {
            $this->syncMidtransStatusByOrderId($orderId, $userId);
        } else {
            $latestOrderId = DB::table('transaksi')
                ->where('tagihan_id', $tagihanId)
                ->where('user_id', $userId)
                ->whereNotNull('order_id')
                ->orderByDesc('id')
                ->value('order_id');

            if (is_string($latestOrderId) && $latestOrderId !== '') {
                $this->syncMidtransStatusByOrderId($latestOrderId, $userId);
            }
        }

        $transaksi = DB::table('transaksi')
            ->where('tagihan_id', $tagihanId)
            ->where('user_id', $userId)
            ->when(is_string($orderId) && $orderId !== '', function ($query) use ($orderId) {
                $query->where('order_id', $orderId);
            })
            ->orderByDesc('id')
            ->first();

        return view('payment.status', compact('tagihan', 'user', 'transaksi'));
    }
}
