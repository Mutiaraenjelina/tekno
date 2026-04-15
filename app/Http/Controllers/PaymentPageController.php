<?php

namespace App\Http\Controllers;

use App\Http\Controllers\api\ModulePaymentGatewayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class PaymentPageController extends Controller
{
    public function show(int $tagihanId, int $userId)
    {
        $tagihan = DB::table('tagihan')->where('id', $tagihanId)->first();
        $user = DB::table('users')->where('id', $userId)->first();

        if (! $tagihan || ! $user) {
            abort(404);
        }

        return view('payment.page', compact('tagihan', 'user'));
    }

    public function create(Request $request, int $tagihanId, int $userId)
    {
        $tagihan = DB::table('tagihan')->where('id', $tagihanId)->first();

        if (! $tagihan) {
            abort(404);
        }

        $paymentRequest = Request::create('/api/create-payment', 'POST', [
            'tagihan_id' => $tagihanId,
            'user_id' => $userId,
            'amount' => $tagihan->nominal,
        ]);

        $response = app(ModulePaymentGatewayController::class)->createPayment($paymentRequest);
        $payload = $response->getData(true);

        if (($payload['status'] ?? null) !== 200) {
            return back()->with('error', $payload['message'] ?? 'Gagal membuat pembayaran.');
        }

        return Redirect::away($payload['data']['payment_url']);
    }
}
