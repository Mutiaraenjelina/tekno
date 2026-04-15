<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Services\XSignatureService;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AssetRentalMobileController extends Controller
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

    private $stat = 1;

    private $parentIdPermohonan = 1;

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

    public function cboJenisPermohonan()
    {
        $jenisPermohonan = DB::select('CALL cbo_jenisPermohonanByParentId(' . $this->parentIdPermohonan . ')');

        if ($jenisPermohonan) {
            return response()->json([
                'status' => 200,
                'jenisPermohonan' => $jenisPermohonan
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Permohonan Sewa Tidak Ditemukan.'
            ]);
        }
    }

    public function cboWajibRetribusi()
    {
        $wajibRetribusi = DB::select('CALL cbo_wajibRetribusi()');

        if ($wajibRetribusi) {
            return response()->json([
                'status' => 200,
                'wajibRetribusi' => $wajibRetribusi
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Wajib Retribusi Tidak Ditemukan.'
            ]);
        }
    }
    public function cboObjekRetribusi()
    {
        $objekRetribusi = DB::select('CALL cbo_objekRetribusi()');

        if ($objekRetribusi) {
            return response()->json([
                'status' => 200,
                'objekRetribusi' => $objekRetribusi
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Objek Retribusi Tidak Ditemukan.'
            ]);
        }
    }

    public function cboPeruntukanSewa()
    {
        $peruntukanSewa = DB::select('CALL cbo_peruntukanSewa()');

        if ($peruntukanSewa) {
            return response()->json([
                'status' => 200,
                'peruntukanSewa' => $peruntukanSewa
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Peruntukan Sewa Tidak Ditemukan.'
            ]);
        }
    }

    public function cboPerioditas()
    {
        $jangkaWaktu = DB::select('CALL cbo_jenisJangkaWaktu()');

        if ($jangkaWaktu) {
            return response()->json([
                'status' => 200,
                'jangkaWaktu' => $jangkaWaktu
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Perioditas Sewa Tidak Ditemukan.'
            ]);
        }
    }

    public function cboSatuan()
    {
        $satuan = DB::select('CALL cbo_satuan(' . 1 . ')');

        if ($satuan) {
            return response()->json([
                'status' => 200,
                'satuan' => $satuan
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Satuan Tidak Ditemukan.'
            ]);
        }
    }

    public function cboDokumenKelengkapan()
    {
        $dokumen = DB::select('CALL cbo_dokumenKelengkapan(' . 1 . ')');

        if ($dokumen) {
            return response()->json([
                'status' => 200,
                'dokumen' => $dokumen
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Dokumen Tidak Ditemukan.'
            ]);
        }
    }


    public function permohonanIndex($id)
    {
        $permohonanSewa = DB::select('CALL viewAll_permohonanSewaByIdWajibRetribusi(' . $id . ')');

        if ($permohonanSewa) {
            return response()->json([
                'status' => 200,
                'permohonanSewa' => $permohonanSewa
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Permohonan Sewa Tidak Ditemukan.'
            ]);
        }

    }

    public function permohonanStore(Request $request)
    {
        //dd($request->all());
        $stts = 1;

        $jenisDokumen = $request->input('jenisDokumen');
        $fileDokumen = $request->file('fileDokumen');
        $keteranganDokumen = $request->input('keteranganDokumen');

        $dokumenKelengkapan = [];

        for ($count = 0; $count < collect($jenisDokumen)->count(); $count++) {
            $uploadedFileDokumen = $fileDokumen[$count];
            $dokumenPermohonan = $count . "-" . $request->get('nomorPermohonan') . time() . "." . $uploadedFileDokumen->getClientOriginalExtension();
            $dokumenPermohonanPath = Storage::disk('biznet')->putFileAs("documents/permohonanSewa", $uploadedFileDokumen, $dokumenPermohonan);

            $dokumenKelengkapan[] = [
                'JenisDokumen' => $jenisDokumen[$count],
                'FileDokumen' => $dokumenPermohonanPath,
                'KeteranganDokumen' => $keteranganDokumen[$count],
            ];
        }

        if (is_null($request->get('wajibRetribusiSebelumnya'))) {
            $wajibRetribusiSebelumnya = 0;
        } else {
            $wajibRetribusiSebelumnya = $request->get('wajibRetribusiSebelumnya');
        }

        $Permohonan = json_encode([
            'JenisPermohonan' => $request->get('jenisPermohonan'),
            'NoSuratPermohonan' => $request->get('nomorPermohonan'),
            'WajibRetribusi' => $request->get('wajibRetribusi'),
            'WajibRetribusiSebelumnya' => $wajibRetribusiSebelumnya,
            'ObjekRetribusi' => $request->get('objekRetribusi'),
            'JenisJangkaWaktu' => $request->get('perioditas'),
            'PeruntukanSewa' => $request->get('peruntukanSewa'),
            'LamaSewa' => $request->get('lamaSewa'),
            'Satuan' => $request->get('satuan'),
            'Status' => $stts,
            'Catatan' => $request->get('catatan'),
            'DibuatOleh' => $request->get('dibuatOleh'),
            'DokumenKelengkapan' => $dokumenKelengkapan
        ]);

        //dd($Permohonan);

        $response = DB::statement('CALL insert_permohonanSewa(:dataPermohonan)', ['dataPermohonan' => $Permohonan]);

        if ($response) {
            return response()->json([
                'status' => 200,
                'message' => 'Permohonan Sewa Berhasil Disimpan!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Permohonan Sewa Gagal Disimpan!'
            ]);
        }
    }

    public function permohonanDetail($id)
    {
        $idStatus = "0";

        $dokumenKelengkapan = DB::select('CALL cbo_dokumenKelengkapan(' . 2 . ')');
        $dokumenPermohonan = DB::select('CALL view_dokumenPermohonanById(' . $id . ')');

        $permohonanData = DB::select('CALL view_PermohonanSewaByIdAndStatus(?, ?)', [$id, $idStatus]);
        $permohonanSewa = $permohonanData[0];

        //dd($fieldEducation);

        if ($permohonanSewa) {
            return response()->json([
                'status' => 200,
                'detailDermohonan' => $permohonanSewa,
                'dokumenermohonan' => $dokumenPermohonan

            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Permohonan Sewa Tidak Ditemukan!'
            ]);
        }

        //return view('admin.SewaAset.Permohonan.detail', compact('permohonanSewa', 'dokumenKelengkapan', 'dokumenPermohonan'));
    }

    public function objekRetribusi()
    {
        $objekRetribusi = DB::select('CALL viewAll_objekRetribusi()');

        if ($objekRetribusi) {
            return response()->json([
                'status' => 200,
                'objekRetribusi' => $objekRetribusi
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Objek Retribusi Tidak Ditemukan.'
            ]);
        }

    }

    public function objekRetribusiDetail($id)
    {
        $objekRetribusiData = DB::select('CALL view_objekRetribusiById(' . $id . ')');

        $fotoObjek = DB::select('CALL view_photoObjekRetribusiById(' . $id . ')');

        if ($objekRetribusiData) {
            $objekRetribusi = $objekRetribusiData[0];

            return response()->json([
                'status' => 200,
                'objekRetribusi' => $objekRetribusi,
                'fotoObjek' => $fotoObjek
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Objek Retribusi Tidak Ditemukan.'
            ]);
        }
    }

    public function tarifObjekRetribusi()
    {
        $tarifRetribusi = DB::select('CALL viewAll_tarifObjekRetribusi()');

        if ($tarifRetribusi) {
            return response()->json([
                'status' => 200,
                'tarifRetribusi' => $tarifRetribusi
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Tarif Objek Retribusi Tidak Ditemukan.'
            ]);
        }

    }

    public function detailTarifObjekRetribusi($id)
    {
        $objekData = DB::select('CALL view_TarifObjekRetribusiById(' . $id . ')');

        //dd($objekData);
        if ($objekData) {
            $tarifObjekRetribusi = $objekData[0];

            return response()->json([
                'status' => 200,
                'tarifObjekRetribusi' => $tarifObjekRetribusi
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Tarif Objek Retribusi Tidak Ditemukan.'
            ]);
        }

    }

    public function perjanjianSewa($id)
    {
        $perjanjianSewa = DB::select('CALL viewAll_perjanjianSewaByIdWajibRetribusi(' . $id . ')');

        if ($perjanjianSewa) {
            return response()->json([
                'status' => 200,
                'perjanjianSewa' => $perjanjianSewa
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Perjanjian Sewa Tidak Ditemukan.'
            ]);
        }

    }

    public function perjanjianSewaDetail($id)
    {
        $perjanjianData = DB::select('CALL view_perjanjianSewaById(' . $id . ')');

        if ($perjanjianData) {
            $perjanjianSewa = $perjanjianData[0];

            return response()->json([
                'status' => 200,
                'perjanjianSewa' => $perjanjianSewa
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Perjanjian Sewa Tidak Ditemukan.'
            ]);
        }

    }

    public function tagihanSewa($id)
    {
        $tagihanSewa = DB::select('CALL view_tagihanByIdWajibRetribusi(' . $id . ')');

        if ($tagihanSewa) {
            return response()->json([
                'status' => 200,
                'tagihanSewa' => $tagihanSewa
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Tagihan Sewa Tidak Ditemukan.'
            ]);
        }

    }

    public function detailTagihanSewa($id)
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

        $dataTagihan = json_encode([
            'IdPerjanjian' => $id,
            'DetailTagihan' => $detailTagihan
        ]);

        if ($headTagihanDetailData) {
            DB::statement('CALL update_tagihan(:dataTagihan)', ['dataTagihan' => $dataTagihan]);


            $tagihanDetail = DB::select('CALL view_tagihanByIdPerjanjian(' . $id . ')');
            $headTagihanDetail = $headTagihanDetailData[0];

            return response()->json([
                'status' => 200,
                'headTagihanDetail' => $headTagihanDetail,
                'tagihanDetail' => $tagihanDetail,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Tagihan Sewa Tidak Ditemukan.'
            ]);
        }

    }

    public function checkout(Request $request)
    {
        //dd($request->all());

        $idPerjanjian = $request->get('idPerjanjian');
        $idTagihan = $request->get('idTagihan');

        $dataTagihan = json_encode([
            'IdPerjanjian' => $idPerjanjian,
            'IdTagihan' => $idTagihan
        ]);

        $headTagihanDetailData = DB::select('CALL view_headTagihanByIdPerjanjian(' . $idPerjanjian . ')');
        $detailTagihan = DB::select('CALL view_singleCheckoutTagihanByid(:dataTagihan)', ['dataTagihan' => $dataTagihan]);

        //dd($detailTagihan);
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
                'expiredDate' => "2025-12-20T23:59:59+07:00",
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

            // Convert data to JSON format for the raw body
            $bodyRaw = json_encode($dataRaw);
            $endPointUrl = "/api/v1.0.0/transfer-va/create-vagov";
            $this->b2bToken = $this->signatureService->accessToken($this->xSignature)['accessToken'];

            Log::info("b2bToken: " . $this->b2bToken);
            //dd($this->b2bToken);

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

                    return $response->json();

                } else {
                    return response()->json([
                        'error' => 'API request failed',
                        'message' => $response->body()
                    ], $response->status());

                    //return redirect()->route('Tagihan.detail', $$detailTagihan[0]->idPerjanjianSewa)->with('Error: API request failed', '$response->body()');
                }
            } else {
                return $response->json();
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
                'expiredDate' => "2025-12-20T23:59:59+07:00",
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

                    //dd($detailTagihan);

                    return response()->json([
                        'status' => 200,
                        'headTagihanDetail' => $headTagihanDetail,
                        'tagihanDetail' => $detailTagihan,
                    ]);
                    //return $response->json();

                } else {
                    return response()->json([
                        'error' => 'API request failed',
                        'message' => $response->body()
                    ], $response->status());

                    //return redirect()->route('Tagihan.detail', $$detailTagihan[0]->idPerjanjianSewa)->with('Error: API request failed', '$response->body()');
                }
            } else {
                return $response->json();
            }

        }
    }

    public function singleCheckout($idP, $idT)
    {
        //dd($request->get('idPerjanjian'));

        $idPerjanjian = $idP;

        $idTagihan = $idT;

        $detailTagihan[] =
            intval($idTagihan)
        ;

        //dd($detailTagihan);

        $dataTagihan = json_encode([
            'IdPerjanjian' => $idP,
            'DetailTagihan' => $detailTagihan
        ]);

        //dd($dataTagihan);

        $headTagihanDetailData = DB::select('CALL view_headTagihanByIdPerjanjian(' . $idPerjanjian . ')');



        //dd($dataTagihan);


        if ($headTagihanDetailData) {

            $checkoutDetail = DB::select('CALL view_checkoutTagihanByid(:dataTagihan)', ['dataTagihan' => $dataTagihan]);
            $headTagihanDetail = $headTagihanDetailData[0];

            return response()->json([
                'status' => 200,
                'headTagihanDetail' => $headTagihanDetail,
                'checkoutDetail' => $checkoutDetail,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Tagihan Sewa Tidak Ditemukan.'
            ]);
        }
    }

    public function pembayaranSewa($id)
    {
        $pembayaranSewa = DB::select('CALL view_pembayaranSewaByIdWajib(' . $id . ')');

        if ($pembayaranSewa) {
            return response()->json([
                'status' => 200,
                'pembayaranSewa' => $pembayaranSewa
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Pembayaran Sewa Tidak Ditemukan.'
            ]);
        }

    }

    public function storeBukti(Request $request)
    {
        //dd($request->all());

        if ($request->hasFile('fileBukti')) {
            //dd($request->file('fileSuratPerjanjian'));
            $uploadedFile = $request->file('fileBukti');
            $filePenilaian = $request->get('idPembayaranSewa') . "-" . time() . "." . $uploadedFile->getClientOriginalExtension();
            $filePath = Storage::disk('biznet')->putFileAs("images/BuktiBayar", $uploadedFile, $filePenilaian);
        } else {
            $filePath = "";
        }

        $idTagihan = $request->input('idTagihan');

        $detailTagihan = [];

        for ($count = 0; $count < collect($idTagihan)->count(); $count++) {

            $detailTagihan[] = [
                'idTagihan' => $idTagihan[$count]
            ];
        }

        $dataPembayaran = json_encode([
            'IdPembayaran' => $request->get('idPembayaranSewa'),
            'NamaBank' => $request->get('namaBank'),
            'NamaPemilikRek' => $request->get('namaPemilikRek'),
            'JumlahDana' => $request->get('jumlahDana'),
            'Keterangan' => $request->get('keterangan'),
            'FileBuktiBayar' => $filePath,
            'DetailTagihan' => $detailTagihan
        ]);

        //dd($dataPembayaran);

        $response = DB::statement('CALL insert_BuktiPembayaran(:dataPembayaran)', ['dataPembayaran' => $dataPembayaran]);

        if ($response) {
            return response()->json([
                'status' => 200,
                'message' => 'Bukti Bayar Berhasil Disimpan!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Bukti Bayar Gagal Disimpan!'
            ]);
        }

        //return view('admin.TagihanDanPembayaran.Pembayaran.uploadBukti');
    }

    public function login(Request $request)
    {
        request()->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ]
        );

        $credentials = $request->only('username', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'status' => 401,
                'message' => 'Username atau Password Anda Salah!'
            ]);
        }

        $user = Auth::user();
        //$userRole = Auth::user()->roles->roleName;

        $userData = DB::select('CALL view_userSessionById(?, ?)', [$user->id, $user->idJenisUser]);

        return response()->json([
            'responseCode' => 200,
            'responseMessage' => "Successful",
            'userData' => $userData,
            'accessToken' => $token,
            'tokenType' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 15
        ]);

    }

    public function register(Request $request)
    {
        $nik = $request->get('nik');

        $WajibRetribusi = DB::select('CALL viewWajibRetribusiByNIK(' . $nik . ')');

        if ($WajibRetribusi) {

            $wajibRetribusiData = $WajibRetribusi[0];

            $dataUser = json_encode([
                'Username' => $request->get('username'),
                'Email' => $request->get('email'),
            ]);

            $users = DB::select('CALL check_usernameOrEmail(:dataUser)', ['dataUser' => $dataUser]);

            if ($users) {
                $userData = $users[0];

                if (strtoupper($userData->username) == strtoupper($request->get('username'))) {
                    return response()->json([
                        'status' => 409,
                        'message' => 'Data username ' . $userData->username . ' sudah terdaftar, gunakan username lain!'
                    ]);
                } else if ($userData->email == $request->get('email')) {
                    return response()->json([
                        'status' => 409,
                        'message' => 'Email ' . $userData->email . ' sudah terdaftar, gunakan email lain!'
                    ]);
                }

            } else {
                $dataUser = json_encode([
                    'IdJenisUser' => 2,
                    'IdPersonal' => $wajibRetribusiData->idWajibRetribusi,
                    'UserRole' => 3,
                    'Username' => $request->get('username'),
                    'Password' => Hash::make($request->get('password')),
                    'Email' => $request->get('email'),
                ]);

                $response = DB::statement('CALL insert_user(:dataUser)', ['dataUser' => $dataUser]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Data User Berhasil Disimpan!'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'NIK Data Wajib Retribusi Tidak Ditemukan.'
            ]);
        }
    }
}