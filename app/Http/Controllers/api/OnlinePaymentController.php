<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Carbon\Traits\ToStringFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Services\XSignatureService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OnlinePaymentController extends Controller
{
    protected $signatureService;
    protected $clientId;
    protected $xSignature;
    protected $paymentBaseURL;
    protected $endPointUrl;
    protected $deviceId;
    protected $channelId;
    protected $externalId;
    protected $b2bToken;
    protected $prefixVA;
    protected $previxReal;
    protected $clientIdGov;
    protected $partnerServiceId;
    protected $mataAnggaran;
    protected $xTimeStamp;
    protected $dateNow;

    public function __construct(XSignatureService $signatureService)
    {
        $this->signatureService = $signatureService;
        $this->xSignature = $this->signatureService->getXSignatureAccessToken();
        $this->clientId = env('CLIENT_ID');
        $this->deviceId = env('DEVICE_ID');
        $this->channelId = env('CHANNEL_ID');
        $this->externalId = env('EXTERNAL_ID');
        $this->prefixVA = env('PREVIX_VA');
        $this->previxReal = env('PREVIX_REAL');
        $this->partnerServiceId = env('PARTNER_SERVICE_ID');
        $this->clientIdGov = env('CLIENT_ID_GOV');
        $this->mataAnggaran = env('MATA_ANGGARAN');
        $this->paymentBaseURL = env('PAYMENT_BASE_URL');
        $this->endPointUrl = "/api/v1.0.0/access-token/b2b";
        $this->dateNow = Carbon::now();
        $this->xTimeStamp = $this->dateNow->addMinutes(2)->setTimezone('Asia/Bangkok')->format('Y-m-d\TH:i:sP');
    }

    public function inquiryPajak(Request $request)
    {

        $varInquiryPajak = json_encode([
            'KodeBayar' => $request->get('kode_bayar'),
            'TransaksiId' => $request->get('trx_id')
        ]);

        $paymentPajak = DB::select('CALL view_checkPaymentPajak(:dataPayment)', ['dataPayment' => $varInquiryPajak]);

        if ($paymentPajak) {
            return response()->json([
                'code' => "88"
            ]);
        } else {
            $inquiryPajak = DB::select('CALL view_inquiry_pajak(:dataInquiryPajak)', ['dataInquiryPajak' => $varInquiryPajak]);

            if ($inquiryPajak) {
                return response()->json([
                    'code' => "00",
                    'data' => $inquiryPajak
                ]);
            } else {
                return response()->json([
                    'code' => "14",
                    'message' => 'Data Tidak Ditemukan.'
                ]);
            }
        }
    }

    public function paymentPajak(Request $request)
    {
        /*if (is_null($request->get('kode_bayar')) || empty($request->get('kode_bayar'))) {
            return response()->json([
                'code' => "14",
                'message' => 'Data Kode Bayar Tidak Ditemukan.'
            ]);
        } else if (is_null($request->get('trx_id')) || empty($request->get('trx_id'))) {
            return response()->json([
                'code' => "14",
                'message' => 'Data Id Transaksi Tidak Ditemukan.'
            ]);
        } else if (is_null($request->get('pokok')) || empty($request->get('pokok'))) {
            return response()->json([
                'code' => "14",
                'message' => 'Data Pokok Retribusi Tidak Ditemukan.'
            ]);
        } else if (is_null($request->get('denda')) || empty($request->get('denda'))) {
            return response()->json([
                'code' => "14",
                'message' => 'Data Denda Retribusi Tidak Ditemukan.'
            ]);
        } else if (is_null($request->get('tgl_pembayaran')) || empty($request->get('tgl_pembayaran'))) {
            return response()->json([
                'code' => "14",
                'message' => 'Data Tanggal Pembayaran Tidak Ditemukan.'
            ]);
        } else if (is_null($request->get('kode_referensi')) || empty($request->get('kode_referensi'))) {
            return response()->json([
                'code' => "14",
                'message' => 'Data Kode Referensi Tidak Ditemukan.'
            ]);
        } else if (is_null($request->get('kode_terminal')) || empty($request->get('kode_terminal'))) {
            return response()->json([
                'code' => "14",
                'message' => 'Data Kode Terminal Tidak Ditemukan.'
            ]);
        } else if (is_null($request->get('kode_cabang')) || empty($request->get('kode_cabang'))) {
            return response()->json([
                'code' => "14",
                'message' => 'Data Kode Cabang Tidak Ditemukan.'
            ]);
        } else if (is_null($request->get('nama_channel')) || empty($request->get('nama_channel'))) {
            return response()->json([
                'code' => "14",
                'message' => 'Data Kode Channel Tidak Ditemukan.'
            ]);
        } else {*/
            $varPaymentPajak = json_encode([
                'KodeBayar' => $request->get('kode_bayar'),
                'TransaksiId' => $request->get('trx_id')
            ]);

            $paymentPajak = DB::select('CALL view_checkPaymentPajak(:dataPayment)', ['dataPayment' => $varPaymentPajak]);

            if ($paymentPajak) {
                return response()->json([
                    'code' => "88"
                ]);
            } else {
                $date = Carbon::parse(str_replace(' ', '+', $request->get('tanggal_pembayaran')));
                $formattedTime = $date->format('m/d/Y H:i:s');

                $dataPaymentPajak = json_encode([
                    'KodeBayar' => $request->get('kode_bayar'),
                    'TransaksiId' => $request->get('trx_id'),
                    'Pokok' => $request->get('pokok'),
                    'Denda' => $request->get('denda'),
                    'TanggalPembayaran' => $formattedTime,
                    'KodeReferensi' => $request->get('kode_referensi'),
                    'KodeTerminal' => $request->get('kode_terminal'),
                    'KodeCabang' => $request->get('kode_cabang'),
                    'NamaChannel' => $request->get('nama_channel')
                ]);

                //dd($dataPaymentPajak);

                $response = DB::statement('CALL insert_pembayaranRetribusi(:dataPaymentPajak)', ['dataPaymentPajak' => $dataPaymentPajak]);

                if ($response) {
                    return response()->json([
                        'code' => "00"
                    ]);
                } else {
                    return response()->json([
                        'status' => 91
                    ]);
                }

            }
        //}

    }

    public function accessToken()
    {
        $rawData = [
            'grantType' => 'client_credentials',
            'additionalInfo' => (object) []
        ];

        // Convert data to JSON format for the raw body
        $jsonData = json_encode($rawData);

        $response = Http::withHeaders([
            'X-TIMESTAMP' => $this->xTimeStamp,
            'X-CLIENT-KEY' => $this->clientId,
            'X-SIGNATURE' => $this->xSignature,
        ])->withBody($jsonData, 'application/json')
            ->post('https://snap.banksumut.co.id/snapgov/api/v1.0.0/access-token/b2b');

        if ($response->successful()) {
            return $response->json();
        }

        return response()->json([
            'error' => 'API request failed',
            'message' => $response->body()
        ], $response->status());
    }

    public function getAccessToken()
    {
        //$result = $this->signatureService->getXSignatureAccessToken();
        //return response()->json($result);

        // $result = $this->accessToken();
        return $this->accessToken()["accessToken"];
    }

    public function getServiceSignature(Request $request)
    {
        $httpMethod = $request->method();
        $bodyRaw = $request->getContent();  // Get the raw body of the request
        $endPointUrl = "/api/v1.0.0/transfer-va/create-vagov";
        $accessToken = $this->accessToken()['accessToken'];
        $result = $this->signatureService->getXSignatureService($httpMethod, $bodyRaw, $endPointUrl, $accessToken);
        return response()->json($result);
    }

    public function createVA(Request $request)
    {
        $httpMethod = $request->method();

        $dataRaw = [
            'partnerServiceId' => $this->partnerServiceId,
            'virtualAccountName' => "Gilangg",
            'virtualAccountEmail' => "gilangprasetioo2301@gmail.com",
            'virtualAccountPhone' => "082168519882",
            'billDetails' => [
                [
                    'billAmount' => [
                        'value' => "10000.00",
                        'currency' => "IDR"
                    ]
                ]
            ],
            'virtualAccountTrxType' => "C",
            'expiredDate' => "2025-12-20T23:59:59+07:00",
            'additionalInfo' => [
                'clientid' => $this->clientIdGov,
                'prefix_real' => $this->previxReal,
                'masa_bayar' => "2024-11",
                'nik' => "1209312334123331",
                'mata_anggaran' => $this->mataAnggaran,
                'denda' => "0",
                'customer_address' => "-",
                'keterangan' => "Retribusi Sewa Tanah"
            ]
        ];

        // Convert data to JSON format for the raw body
        $bodyRaw = json_encode($dataRaw);
        $endPointUrl = "/api/v1.0.0/transfer-va/create-vagov";
        $this->b2bToken = $this->accessToken()['accessToken'];

        $xsignaturService = $this->signatureService->getXSignatureService($httpMethod, $bodyRaw, $endPointUrl, $this->b2bToken);

        //print_r($bodyRaw);

        //print_r($xsignaturService);

        $response = Http::withHeaders([
            'X-TIMESTAMP' => $this->xTimeStamp,
            'X-PARTNER-ID' => $this->clientId,
            'X-DEVICE-ID' => $this->deviceId,
            'X-SIGNATURE' => $xsignaturService,
            'CHANNEL-ID' => $this->channelId,
            'X-EXTERNAL-ID' => $this->externalId,
            'Authorization' => "Bearer " . $this->b2bToken,
        ])->withBody($bodyRaw, 'application/json')
            ->post('https://snap.banksumut.co.id/snapgov' . $endPointUrl);


        if ($response->successful()) {
            return $response->json();
        }

        return response()->json([
            'error' => 'API request failed',
            'message' => $response->body()
        ], $response->status());

    }

    public function updateVA(Request $request)
    {
        $httpMethod = $request->method();

        $dataRaw = [
            'partnerServiceId' => $this->partnerServiceId,
            'trxId' => "20250204113043903",
            'virtualAccountName' => "Gilangg",
            'virtualAccountEmail' => "gilangprasetioo2301@gmail.com",
            'virtualAccountPhone' => "082168519882",
            'billDetails' => [
                [
                    'billAmount' => [
                        'value' => "20000.00",
                        'currency' => "IDR"
                    ]
                ]
            ],
            'virtualAccountTrxType' => "C",
            'expiredDate' => "2025-12-20T23:59:59+07:00",
            'additionalInfo' => [
                'clientid' => $this->clientIdGov,
                'masa_bayar' => "2024-11",
                'denda' => "0",
                'customer_address' => "-",
                'keterangan' => "Retribusi Sewa Tanah"
            ]
        ];

        // Convert data to JSON format for the raw body
        $bodyRaw = json_encode($dataRaw);
        $endPointUrl = "/api/v1.0.0/transfer-va/update-vagov";
        $this->b2bToken = $this->accessToken()['accessToken'];

        $xsignaturService = $this->signatureService->getXSignatureService($httpMethod, $bodyRaw, $endPointUrl, $this->b2bToken);

        //print_r($bodyRaw);

        //print_r($xsignaturService);

        $response = Http::withHeaders([
            'X-TIMESTAMP' => $this->xTimeStamp,
            'X-PARTNER-ID' => $this->clientId,
            'X-DEVICE-ID' => $this->deviceId,
            'X-SIGNATURE' => $xsignaturService,
            'CHANNEL-ID' => $this->channelId,
            'X-EXTERNAL-ID' => $this->externalId,
            'Authorization' => "Bearer " . $this->b2bToken,
        ])->withBody($bodyRaw, 'application/json')
            ->post('https://snap.banksumut.co.id/snapgov' . $endPointUrl);


        if ($response->successful()) {
            return $response->json();
        }

        return response()->json([
            'error' => 'API request failed',
            'message' => $response->body()
        ], $response->status());

    }

    public function inquiryVA(Request $request)
    {
        $httpMethod = $request->method();

        $dataRaw = [
            'partnerServiceId' => $this->partnerServiceId,
            'trxId' => "20250204113043903",
            'virtualAccountTrxType' => "C",
            'additionalInfo' => [
                'clientid' => $this->clientIdGov
            ]
        ];

        // Convert data to JSON format for the raw body
        $bodyRaw = json_encode($dataRaw);
        $endPointUrl = "/api/v1.0.0/transfer-va/inquiry-vagov";
        $this->b2bToken = $this->accessToken()['accessToken'];

        $xsignaturService = $this->signatureService->getXSignatureService($httpMethod, $bodyRaw, $endPointUrl, $this->b2bToken);

        //print_r($bodyRaw);

        //print_r($xsignaturService);

        $response = Http::withHeaders([
            'X-TIMESTAMP' => $this->xTimeStamp,
            'X-SIGNATURE' => $xsignaturService,
            'X-PARTNER-ID' => $this->clientId,
            'X-EXTERNAL-ID' => $this->externalId,
            'X-DEVICE-ID' => $this->deviceId,
            'CHANNEL-ID' => $this->channelId,
            'Authorization' => "Bearer " . $this->b2bToken,
        ])->withBody($bodyRaw, 'application/json')
            ->post('https://snap.banksumut.co.id/snapgov' . $endPointUrl);


        if ($response->successful()) {
            return $response->json();
        }

        return response()->json([
            'error' => 'API request failed',
            'message' => $response->body()
        ], $response->status());

    }
}