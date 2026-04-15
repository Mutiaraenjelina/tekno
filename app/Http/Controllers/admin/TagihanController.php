<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Services\XSignatureService;
use Carbon\Carbon;

class TagihanController extends Controller
{
    protected $signatureService;
    protected $clientId;
    protected $xSignature;
    protected $paymentBaseURL;
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

    private $stat = 13;

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
        $this->dateNow = Carbon::now();
        $this->xTimeStamp = $this->dateNow->addMinutes(2)->setTimezone('Asia/Bangkok')->format('Y-m-d\TH:i:sP');
    }


    public function index()
    {
        $tagihanSewa = DB::select('CALL view_tagihanAll()');

        return view('admin.TagihanDanPembayaran.Tagihan.index', compact('tagihanSewa'));

    }

    public function detail($id)
    {
        $headTagihanDetailData = DB::select('CALL view_headTagihanByIdPerjanjian(' . $id . ')');
        $tagihanDetail = DB::select('CALL view_tagihanByIdPerjanjian(' . $id . ')');

        //dd($tagihanDetail);
        $detailTagihan = [];

        for ($count = 0; $count < collect($tagihanDetail)->count(); $count++) {

            if ($tagihanDetail[$count]->idStatus == 9) {
                $detailTagihan[] = [
                    'IdTagihan' => $tagihanDetail[$count]->idTagihanSewa
                ];
            }

        }

        //dd($detailTagihan);

        $dataTagihan = json_encode([
            'IdPerjanjian' => $id,
            'DetailTagihan' => $detailTagihan
        ]);

        if ($headTagihanDetailData) {

            DB::statement('CALL update_tagihan(:dataTagihan)', ['dataTagihan' => $dataTagihan]);


            $tagihanDetail = DB::select('CALL view_tagihanByIdPerjanjian(' . $id . ')');
            $headTagihanDetail = $headTagihanDetailData[0];

            //dd($tagihanDetail);

            return view('admin.TagihanDanPembayaran.Tagihan.detail', compact('tagihanDetail', 'headTagihanDetail'));
        } else {
            return redirect()->route('Tagihan.detail', $id)->with('error', 'Data Tagihan Tidak Ditemukan!');
        }
    }

    public function checkout(Request $request)
    {
        //dd($request->all());

        $idPerjanjian = $request->get('idPerjanjian');

        $idTagihan = $request->input('idTagihan');

        $detailTagihan = [];

        for ($count = 0; $count < collect($idTagihan)->count(); $count++) {
            //dd($fileFoto[$count]);

            $detailTagihan[] =
                intval($idTagihan[$count])
            ;
        }

        $dataTagihan = json_encode([
            'IdPerjanjian' => $request->get('idPerjanjian'),
            'DibuatOleh' => Auth::user()->id,
            'Status' => $this->stat,
            'DetailTagihan' => $detailTagihan
        ]);

        //dd($dataTagihan);

        $existPembayaran = DB::select('CALL view_pembayaranExist(:dataTagihan)', ['dataTagihan' => $dataTagihan]);

        if ($existPembayaran) {

            $idPembayaran = $existPembayaran[0];
        } else {
            $checkout = DB::select('CALL view_checkoutTagihanByid(:dataTagihan)', ['dataTagihan' => $dataTagihan]);
            $idPembayaran = $checkout[0];

        }
        //dd( $idPembayaran->idPembayaranSewa);

        $headPembayaranData = DB::select('CALL view_pembayaranSewaById(' . $idPembayaran->idPembayaranSewa . ')');

        if ($headPembayaranData) {

            $headPembayaran = $headPembayaranData[0];
            $detailPembayaran = DB::select('CALL view_detailPembayaranByIdPembayaran(' . $idPembayaran->idPembayaranSewa . ')');

            //dd($checkoutDetail);

            return view('admin.TagihanDanPembayaran.Tagihan.invoice', compact('headPembayaran', 'detailPembayaran'));
        } else {
            return redirect()->route('Tagihan.detail', $request->get('idPerjanjian'))->with('error', 'Data Tagihan Tidak Ditemukan!');
        }
    }


    public function singleCheckout(Request $request)
    {
        $idPerjanjian = $request->get('idPerjanjian');
        $idTagihan = $request->get('idTagihan');

        $dataTagihan = json_encode([
            'IdPerjanjian' => $idPerjanjian,
            'IdTagihan' => $idTagihan
        ]);

        $headTagihanDetailData = DB::select('CALL view_headTagihanByIdPerjanjian(' . $idPerjanjian . ')');
        $detailTagihan = DB::select('CALL view_singleCheckoutTagihanByid(:dataTagihan)', ['dataTagihan' => $dataTagihan]);

        $expiredAt = now('Asia/Jakarta')
            ->addDays(12)
            ->endOfDay()
            ->toIso8601String();


        //dd($headTagihanDetail);
        if ($detailTagihan[0]->trxId == "" && $detailTagihan[0]->noVirtualAccount == "") {
            $httpMethod = $request->method();

            $dataRaw = [
                'partnerServiceId' => $this->partnerServiceId,
                'virtualAccountName' => $headTagihanDetailData[0]->namaWajibRetribusi,
                'virtualAccountEmail' => $headTagihanDetailData[0]->email,
                'virtualAccountPhone' => $headTagihanDetailData[0]->nomorPonsel,
                'billDetails' => [
                    [
                        'billAmount' => [
                            'value' => number_format((float) $detailTagihan[0]->jumlahTagihan, 2, '.', ''),
                            'currency' => "IDR"
                        ]
                    ]
                ],
                'virtualAccountTrxType' => "C",
                'expiredDate' => $expiredAt,
                'additionalInfo' => [
                    'clientid' => $this->clientIdGov,
                    'prefix_real' => $this->previxReal,
                    'masa_bayar' => $detailTagihan[0]->masaBayar,
                    'nik' => $headTagihanDetailData[0]->nik,
                    'mata_anggaran' => $this->mataAnggaran,
                    'denda' => number_format((float) $detailTagihan[0]->jumlahDenda, 2, '.', ''),
                    'customer_address' => $headTagihanDetailData[0]->alamatWajibRetribusi,
                    'keterangan' => "Retribusi Sewa Tanah"
                ]
            ];

            //dd($dataRaw);

            /*$dataRaw = [
                'partnerServiceId' => $this->partnerServiceId,
                'virtualAccountName' => "Gilangg",
                'virtualAccountEmail' => "gilangprasetioo2301@gmail.com",
                'virtualAccountPhone' => "082168519882",
                'billDetails' => [[
                    'billAmount' => [
                        'value'=> "10000.00",
                        'currency'=> "IDR"
                    ]
                ]],
                'virtualAccountTrxType' => "C",
                'expiredDate'=> "2025-12-20T23:59:59+07:00",
                'additionalInfo' => [
                    'clientid' => $this->clientIdGov,
                    'prefix_real'=> $this->previxReal,
                    'masa_bayar'=> "2024-11",
                    'nik'=> "1209312334123331",
                    'mata_anggaran'=> $this->mataAnggaran,
                    'denda'=> "0",
                    'customer_address'=> "-",
                    'keterangan'=> "Retribusi Sewa Tanah"
                ]
            ];*/

            // Convert data to JSON format for the raw body
            $bodyRaw = json_encode($dataRaw);
            $endPointUrl = "/api/v1.0.0/transfer-va/create-vagov";
            $this->b2bToken = $this->signatureService->accessToken($this->xSignature)['accessToken'];

            $xsignaturService = $this->signatureService->getXSignatureService($httpMethod, $bodyRaw, $endPointUrl, $this->b2bToken);

            $response = Http::withHeaders([
                'X-TIMESTAMP' => $this->xTimeStamp,
                'X-PARTNER-ID' => $this->clientId,
                'X-DEVICE-ID' => $this->deviceId,
                'X-SIGNATURE' => $xsignaturService,
                'CHANNEL-ID' => $this->channelId,
                'X-EXTERNAL-ID' => $this->externalId,
                'Authorization' => "Bearer " . $this->b2bToken,
            ])->withBody($bodyRaw, 'application/json')
                ->post($this->paymentBaseURL . $endPointUrl);

            //dd($response->successful());
            if ($response->successful()) {
                $result = $response->json();

                $date = Carbon::parse(str_replace(' ', '+', $result['virtualAccountData']['expiredDate']));
                $formattedTime = $date->format('m/d/Y H:i:s');

                if ($result) {
                    $dataUpdateTagihan = json_encode([
                        'IdTagihan' => $idTagihan,
                        'IdTrx' => $result['virtualAccountData']['trxId'],
                        'NoVirtualAccount' => $result['virtualAccountData']['virtualAccountNo'],
                        'ExpiredDatePembayaran' => $formattedTime,
                    ]);

                    DB::statement('CALL updateCheckoutTagihan(:dataUpdateTagihan)', ['dataUpdateTagihan' => $dataUpdateTagihan]);

                    $headTagihanDetailData = DB::select('CALL view_headTagihanByIdPerjanjian(' . $idPerjanjian . ')');
                    $headTagihanDetail = $headTagihanDetailData[0];
                    $detailTagihan = DB::select('CALL view_singleCheckoutTagihanByid(:dataTagihan)', ['dataTagihan' => $dataTagihan]);

                    return view('admin.TagihanDanPembayaran.Tagihan.invoice', compact('headTagihanDetail', 'detailTagihan'));

                } else {
                    /*return response()->json([
                        'error' => 'API request failed',
                        'message' => $response->body()
                    ], $response->status());*/

                    return redirect()->route('Tagihan.detail', $$detailTagihan[0]->idPerjanjianSewa)->with('Error: API request failed', '$response->body()');
                }
            } else {
                return view('admin.TagihanDanPembayaran.Tagihan.invoice', compact('headTagihanDetail', 'detailTagihan'));
            }
        } else {
            $httpMethod = $request->method();

            $dataRaw = [
                'partnerServiceId' => $this->partnerServiceId,
                'trxId' => $detailTagihan[0]->trxId,
                'virtualAccountName' => $headTagihanDetailData[0]->namaWajibRetribusi,
                'virtualAccountEmail' => $headTagihanDetailData[0]->email,
                'virtualAccountPhone' => $headTagihanDetailData[0]->nomorPonsel,
                'billDetails' => [
                    [
                        'billAmount' => [
                            'value' => number_format((float) $detailTagihan[0]->jumlahTagihan, 2, '.', ''),
                            'currency' => "IDR"
                        ]
                    ]
                ],
                'virtualAccountTrxType' => "C",
                'expiredDate' => $expiredAt,
                'additionalInfo' => [
                    'clientid' => $this->clientIdGov,
                    'masa_bayar' => $detailTagihan[0]->masaBayar,
                    'denda' => number_format((float) $detailTagihan[0]->jumlahDenda, 2, '.', ''),
                    'customer_address' => $headTagihanDetailData[0]->alamatWajibRetribusi,
                    'keterangan' => "Retribusi Sewa Tanah"
                ]
            ];

            $bodyRaw = json_encode($dataRaw);
            $endPointUrlUpdate = "/api/v1.0.0/transfer-va/update-vagov";
            $this->b2bToken = $this->signatureService->accessToken($this->xSignature)['accessToken'];

            $xsignaturService = $this->signatureService->getXSignatureService($httpMethod, $bodyRaw, $endPointUrlUpdate, $this->b2bToken);

            $response = Http::withHeaders([
                'X-TIMESTAMP' => $this->xTimeStamp,
                'X-PARTNER-ID' => $this->clientId,
                'X-DEVICE-ID' => $this->deviceId,
                'X-SIGNATURE' => $xsignaturService,
                'CHANNEL-ID' => $this->channelId,
                'X-EXTERNAL-ID' => $this->externalId,
                'Authorization' => "Bearer " . $this->b2bToken,
            ])->withBody($bodyRaw, 'application/json')
                ->post($this->paymentBaseURL . $endPointUrlUpdate);

            if ($response->successful()) {
                $result = $response->json();

                $date = Carbon::parse(str_replace(' ', '+', $result['virtualAccountData']['expiredDate']));
                $formattedTime = $date->format('m/d/Y H:i:s');

                if ($result) {
                    $dataUpdateTagihan = json_encode([
                        'IdTagihan' => $idTagihan,
                        'IdTrx' => $result['virtualAccountData']['trxId'],
                        'NoVirtualAccount' => "",
                        'ExpiredDatePembayaran' => $formattedTime,
                    ]);

                    DB::statement('CALL updateCheckoutTagihan(:dataUpdateTagihan)', ['dataUpdateTagihan' => $dataUpdateTagihan]);

                    $headTagihanDetailData = DB::select('CALL view_headTagihanByIdPerjanjian(' . $idPerjanjian . ')');
                    $headTagihanDetail = $headTagihanDetailData[0];
                    $detailTagihan = DB::select('CALL view_singleCheckoutTagihanByid(:dataTagihan)', ['dataTagihan' => $dataTagihan]);

                    return view('admin.TagihanDanPembayaran.Tagihan.invoice', compact('headTagihanDetail', 'detailTagihan'));

                } else {
                    /*return response()->json([
                        'error' => 'API request failed',
                        'message' => $response->body()
                    ], $response->status());*/

                    return redirect()->route('Tagihan.detail', $$detailTagihan[0]->idPerjanjianSewa)->with('Error: API request failed', '$response->body()');
                }
            } else {
                return view('admin.TagihanDanPembayaran.Tagihan.invoice', compact('headTagihanDetail', 'detailTagihan'));
            }

        }
    }
}