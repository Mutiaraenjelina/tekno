<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WhatsAppService
{
    public function sendLoginCredentials(string $phone, string $nama, string $username, string $password, string $loginUrl): array
    {
        if (! (bool) config('services.whatsapp.enabled', false)) {
            return [
                'success' => false,
                'message' => 'Auto-send WhatsApp nonaktif. Set WHATSAPP_ENABLED=true untuk mengaktifkan.',
            ];
        }

        $provider = (string) config('services.whatsapp.provider', 'fonnte');
        $token = (string) config('services.whatsapp.token', '');

        if ($token === '') {
            return [
                'success' => false,
                'message' => 'Token WhatsApp API belum diatur.',
            ];
        }

        $normalizedPhone = $this->normalizePhone($phone);
        if ($normalizedPhone === '') {
            return [
                'success' => false,
                'message' => 'Nomor WhatsApp pelanggan tidak valid.',
            ];
        }

        $text = "Halo {$nama}, akun SIPAYDA Anda sudah dibuat.\n"
            . "Username: {$username}\n"
            . "Password: {$password}\n"
            . "Login di: {$loginUrl}\n"
            . 'Silakan ganti password setelah login.';

        if ($provider === 'fonnte') {
            return $this->sendViaFonnte($normalizedPhone, $text, $token);
        }

        return [
            'success' => false,
            'message' => 'Provider WhatsApp API tidak dikenali: ' . $provider,
        ];
    }

    private function sendViaFonnte(string $target, string $message, string $token): array
    {
        $endpoint = (string) config('services.whatsapp.base_url', 'https://api.fonnte.com/send');
        $timeout = (int) config('services.whatsapp.timeout', 15);
        $countryCode = (string) config('services.whatsapp.country_code', '62');

        $response = Http::timeout($timeout)
            ->withHeaders([
                'Authorization' => $token,
            ])
            ->asForm()
            ->post($endpoint, [
                'target' => $target,
                'message' => $message,
                'countryCode' => $countryCode,
            ]);

        if ($response->successful()) {
            return [
                'success' => true,
                'message' => 'Kredensial berhasil dikirim otomatis ke WhatsApp pelanggan.',
                'raw' => $response->json(),
            ];
        }

        return [
            'success' => false,
            'message' => 'Gagal kirim otomatis ke WhatsApp API. HTTP ' . $response->status(),
            'raw' => $response->body(),
        ];
    }

    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/[^0-9]/', '', $phone);
        if ($digits === null || $digits === '') {
            return '';
        }

        if (Str::startsWith($digits, '0')) {
            return '62' . substr($digits, 1);
        }

        if (Str::startsWith($digits, '62')) {
            return $digits;
        }

        return '62' . $digits;
    }
}
