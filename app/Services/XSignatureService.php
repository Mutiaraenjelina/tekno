<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class XSignatureService
{
    protected $clientId;
    protected $privateKeyPem;
    protected $clientSecret;
    protected $endPointUrl;
    protected $deviceId;
    protected $channelId;
    protected $externalId;
    protected $xTimeStamp;
    protected $dateNow;
    protected $paymentBaseURL;

    public function __construct()
    {
        // You can retrieve these values from the environment or configuration
        $this->clientId = env('CLIENT_ID');
        $this->privateKeyPem = env('PRIVATE_KEY_PEM');
        $this->clientSecret = env('CLIENT_SECRET');
        $this->paymentBaseURL = env('PAYMENT_BASE_URL');
        $this->deviceId = env('DEVICE_ID');
        $this->channelId = env('CHANNEL_ID');
        $this->externalId = env('EXTERNAL_ID');
        $this->dateNow = Carbon::now();
        $this->xTimeStamp =  $this->dateNow->addMinutes(2)->setTimezone('Asia/Bangkok')->format('Y-m-d\TH:i:sP');
    }

    public function getXSignatureAccessToken()
    {
        // Check if private key is configured
        if (empty($this->privateKeyPem)) {
            Log::warning('PRIVATE_KEY_PEM not configured in environment');
            return null;
        }

        // Data to sign
        $stringToSign = $this->clientId . '|' .  $this->xTimeStamp;

        // Sign the string using the private key
        $privateKey = openssl_pkey_get_private($this->privateKeyPem);
        
        if ($privateKey === false) {
            Log::error('Failed to parse private key');
            return null;
        }

        openssl_sign($stringToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        // Encode the signature in base64
        $xSignatureAccessToken = base64_encode($signature);

        // Log the result for debugging purposes
        Log::info('xSignatureAccessToken : ' . $xSignatureAccessToken);

        // Return the result
        return $xSignatureAccessToken;
    }

    public function getXSignatureService($httpMethod, $bodyRaw, $endPointUrl, $accessToken)
    {
        // Prepare the string to sign
        $minifiedBody = json_encode(json_decode($bodyRaw), JSON_UNESCAPED_SLASHES);
        $hashedBody = strtolower(hash('sha256', $minifiedBody));
        $externalId = Str::uuid()->toString();
        $stringToSign = implode(':', [
            $httpMethod,
            $endPointUrl,
            $accessToken,
            $hashedBody,
            $this->xTimeStamp
        ]);

        // Create the HMAC signature
        $xSignatureService = base64_encode(hash_hmac('sha512', $stringToSign, $this->clientSecret, true));

        // Log the result for debugging purposes
        Log::info("xTimestamp : " . $this->xTimeStamp);
        //Log::info("accessToken : " . $this->b2bToken);
        Log::info("clientSecret : " . $this->clientSecret);
        Log::info("minified body : " . $minifiedBody);
        Log::info("hashedBody: " . $hashedBody);
        Log::info("stringToSign: " . $stringToSign);
        Log::info("xSignatureService: " . $xSignatureService);

        // Return the result
        return $xSignatureService;
    }

    public function accessToken($xSignature)
    {
        $rawData = [
            'grantType' => 'client_credentials',
            'additionalInfo' => (object)[]
        ];

        $endPointUrl = "/api/v1.0.0/access-token/b2b";
    
        // Convert data to JSON format for the raw body
        $jsonData = json_encode($rawData);

        $response = Http::withHeaders([
            'X-TIMESTAMP' => $this->xTimeStamp,
            'X-CLIENT-KEY' => $this->clientId,
            'X-SIGNATURE' => $xSignature,
        ])->withBody($jsonData, 'application/json')
        ->post($this->paymentBaseURL . $endPointUrl);

        if ($response->successful()) {
            return $response->json();
        }

        return response()->json([
            'error' => 'API request failed',
            'message' => $response->body()
        ], $response->status());
    }

}
