<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class TagihanController extends Controller
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
                Log::warning('Failed syncing Midtrans status from status page', [
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
            Log::warning('Exception syncing Midtrans status from status page', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function baseTagihanQuery(int $userId)
    {
        return DB::table('tagihan_user as tu')
            ->join('tagihan as t', 'tu.tagihan_id', '=', 't.id')
            ->leftJoin('users as a', 'a.id', '=', 't.created_by')
            ->leftJoin('transaksi as tr', 'tu.payment_id', '=', 'tr.id')
            ->where('tu.user_id', $userId)
            ->select(
                't.id',
                't.nama_tagihan',
                't.nominal',
                't.tipe',
                't.jatuh_tempo',
                't.deskripsi',
                't.created_at as tagihan_created_at',
                't.created_by',
                'a.username as admin_creator_username',
                'tu.id as assignment_id',
                'tu.status',
                'tu.user_id',
                'tu.payment_id',
                'tu.created_at as assignment_created_at',
                'tr.order_id',
                'tr.status as transaksi_status',
                'tr.created_at as transaksi_created_at'
            );
    }

    /**
     * Return user's tagihan list as JSON for dashboard widgets.
     */
    public function data()
    {
        $userId = Auth::id();

        $tagihan = $this->baseTagihanQuery($userId)
            ->orderBy('t.jatuh_tempo', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $tagihan,
        ]);
    }

    /**
     * Display user's tagihan list
     */
    public function index()
    {
        $userId = Auth::id();
        
        $tagihan = $this->baseTagihanQuery($userId)
            ->orderBy('t.jatuh_tempo', 'desc')
            ->get();

        return view('user.Tagihan.index', compact('tagihan'));
    }

    /**
     * Display tagihan detail
     */
    public function show($tagihanId)
    {
        $userId = Auth::id();
        
        $tagihan = $this->baseTagihanQuery($userId)
            ->where('t.id', $tagihanId)
            ->first();

        if (!$tagihan) {
            return redirect()->route('user.tagihan.index')->with('error', 'Tagihan tidak ditemukan');
        }

        return view('user.Tagihan.show', compact('tagihan'));
    }

    /**
     * Display assignment/payment status list for authenticated user.
     */
    public function status(Request $request)
    {
        $userId = Auth::id();

        $orderId = $request->query('order_id');
        if (is_string($orderId) && $orderId !== '') {
            $this->syncMidtransStatusByOrderId($orderId, $userId);
        }

        $assignments = $this->baseTagihanQuery($userId)
            ->orderBy('t.jatuh_tempo', 'desc')
            ->get();

        return view('user.Tagihan.status', compact('assignments'));
    }
}
