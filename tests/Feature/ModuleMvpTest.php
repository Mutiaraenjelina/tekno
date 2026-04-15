<?php

namespace Tests\Feature;

use App\Http\Controllers\api\ModuleAuthController;
use App\Http\Controllers\api\ModulePaymentGatewayController;
use App\Http\Controllers\api\ModuleTransaksiController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ModuleMvpTest extends TestCase
{
    use DatabaseTransactions;

    public function test_register_create_payment_and_status_update_flow(): void
    {
        $suffix = uniqid();

        $registerRequest = Request::create('/api/register', 'POST', [
            'nama' => 'Smoke User ' . $suffix,
            'no_wa' => '08123' . substr($suffix, -6),
            'username' => 'smoke_' . $suffix,
            'email' => 'smoke_' . $suffix . '@example.com',
            'password' => 'password123',
        ]);

        $registerResponse = app(ModuleAuthController::class)->register($registerRequest);
        $registerData = $registerResponse->getData(true);

        $this->assertSame(200, $registerData['status']);
        $this->assertDatabaseHas('pelanggan', [
            'nama' => 'Smoke User ' . $suffix,
        ]);

        $user = DB::table('users')->where('username', 'smoke_' . $suffix)->first();
        $this->assertNotNull($user);

        $tagihanId = DB::table('tagihan')->insertGetId([
            'nama_tagihan' => 'Smoke Tagihan ' . $suffix,
            'deskripsi' => 'Feature test tagihan',
            'nominal' => 75000,
            'tipe' => 'sekali',
            'jatuh_tempo' => now()->toDateString(),
            'created_by' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $paymentRequest = Request::create('/api/create-payment', 'POST', [
            'tagihan_id' => $tagihanId,
            'user_id' => $user->id,
            'amount' => 75000,
        ]);

        $paymentResponse = app(ModulePaymentGatewayController::class)->createPayment($paymentRequest);
        $paymentData = $paymentResponse->getData(true);

        $this->assertSame(200, $paymentData['status']);
        $this->assertNotEmpty($paymentData['data']['order_id']);

        $updateRequest = Request::create('/api/transaksi/status', 'PUT', [
            'tagihan_id' => $tagihanId,
            'user_id' => $user->id,
            'status' => 'success',
        ]);

        $updateResponse = app(ModuleTransaksiController::class)->updateStatusPembayaran($updateRequest);
        $updateData = $updateResponse->getData(true);

        $this->assertSame(200, $updateData['status']);

        $assignment = DB::table('tagihan_user')
            ->where('tagihan_id', $tagihanId)
            ->where('user_id', $user->id)
            ->first();

        $this->assertNotNull($assignment);
        $this->assertSame('sudah', $assignment->status);
    }

    public function test_create_payment_requires_valid_tagihan_and_user(): void
    {
        $request = Request::create('/api/create-payment', 'POST', [
            'tagihan_id' => 999999,
            'user_id' => 999998,
            'amount' => 10000,
        ]);

        $response = app(ModulePaymentGatewayController::class)->createPayment($request);
        $data = $response->getData(true);

        $this->assertSame(422, $data['status']);
    }
}
