<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
//use Spatie\LaravelPdf\Facades\Pdf;
use Barryvdh\DomPDF\Facade\Pdf;

class PerjanjianController extends Controller
{
    private $stat = 6;

    public function index()
    {
        $perjanjianSewa = DB::select('CALL viewAll_perjanjianSewa()');

        return view('admin.SewaAset.Perjanjian.index', compact('perjanjianSewa'));

    }

    public function create()
    {
        $permohonanSewa = DB::select('CALL cbo_permohonanPerjanjianSewa()');
        $pegawai = DB::select('CALL cbo_pegawai()');

        //return view('admin.SewaAset.Permohonan.create', compact('jenisPermohonan', 'wajibRetribusi', 'objekRetribusi', 'jangkaWaktu', 'peruntukanSewa'));

        return view('admin.SewaAset.Perjanjian.create', compact('permohonanSewa', 'pegawai'));

    }

    public function detailPermohonanToPerjanjian(Request $request)
    {
        $id = $request->idPermohonan;

        //dd($id);

        $permohonanData = DB::select('CALL view_detailPermohonanToPerjanjianById(' . $id . ')');
        $permohonanSewa = $permohonanData[0];

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

    public function store(Request $request)
    {
        $npwrd = str_replace(['.', '-'], '', $request->get('npwrd'));

        //dd($npwrd);

        if ($request->hasFile('fileSuratPerjanjian')) {
            //dd($request->file('fileSuratPerjanjian'));
            $uploadedFile = $request->file('fileSuratPerjanjian');
            $filePerjanjian = "SuratPerjanjian-" . $npwrd . time() . "-" . "." . $uploadedFile->getClientOriginalExtension();
            $filePath = Storage::disk('biznet')->putFileAs("documents/perjanjianSewa", $uploadedFile, $filePerjanjian);
        } else {
            $filePath = "";
        }

        $nik = $request->input('nik');
        $namaSaksi = $request->input('namaSaksi');
        $keteranganSaksi = $request->input('keteranganSaksi');

        $saksiPerjanjianSewa = [];

        for ($count = 0; $count < collect($nik)->count(); $count++) {
            $saksiPerjanjianSewa[] = [
                'NIK' => $nik[$count],
                'NamaSaksi' => $namaSaksi[$count],
                'KeteranganSaksi' => $keteranganSaksi[$count],
            ];
        }

        $kodeBilling = env('BILLING_CODE');

        $PerjanjianSewa = json_encode([
            'IdPermohonan' => $request->get('permohonanSewa'),
            'NoSuratPerjanjian' => $request->get('noSuratPerjanjian'),
            'TanggalDisahkan' => date("m/d/Y", strtotime($request->get('tanggalDisahkan'))),
            'TanggalAwal' => date("m/d/Y", strtotime($request->get('tanggalAwal'))),
            'TanggalAkhir' => date("m/d/Y", strtotime($request->get('tanggalAkhir'))),
            'Keterangan' => $request->get('keterangan'),
            'DisahkanOleh' => $request->get('disahkanOleh'),
            //'FileSuratPerjanjian' => $filePath,
            'Status' => $this->stat,
            'CreateBy' => Auth::user()->id,
            'LuasTanah' => $request->get('luasTanah'),
            'LuasBangunan' => $request->get('luasBangunan'),
            'LamaSewa' => $request->get('lamaSewa'),
            'KodeBilling' => $kodeBilling,
            'NPWRD' => $request->get('npwrd'),
            'IdJenisPermohonanSewa' => $request->get('idJenisPermohonan'),
            'SaksiPerjanjianSewa' => $saksiPerjanjianSewa
        ]);

        //dd($PerjanjianSewa);

        $response = DB::statement('CALL insert_perjanjianSewa(:dataPerjanjianSewa)', ['dataPerjanjianSewa' => $PerjanjianSewa]);

        if ($response) {
            return redirect()->route('Perjanjian.index')->with('success', 'Perjanjian Sewa Berhasil Ditambahkan!');
        } else {
            return redirect()->route('Perjanjian.create')->with('error', 'Perjanjian Sewa Gagal Disimpan!');
        }
    }

    public function edit($id)
    {
        $pegawai = DB::select('CALL cbo_pegawai()');
        $perjanjianData = DB::select('CALL view_perjanjianSewaById(' . $id . ')');
        $perjanjianSewa = $perjanjianData[0];

        $saksiPerjanjian = DB::select('CALL view_saksiPerjanjianById(' . $id . ')');
        //dd($permohonanData);
        //$statusData = DB::select('CALL view_statusById(' . $id . ')');
        //$status = $statusData[0];

        /*if ($status) {
            return view('admin.PengaturanDanKonfigurasi.Status.edit', ['statusType' => $statusTypeCombo], ['status' => $status]);
         } else {
             return redirect()->route('Status.index')->with('error', 'Status Tidak Ditemukan!');
         }*/

        return view('admin.SewaAset.Perjanjian.edit', compact('perjanjianSewa', 'pegawai', 'saksiPerjanjian'));
    }


    public function update(Request $request, $id)
    {
        $Status = json_encode([
            'IdStatus' => $id,
            'IdJenisStatus' => $request->get('jenisStatus'),
            'Status' => $request->get('namaStatus'),
            'Keterangan' => $request->get('keterangan')
        ]);

        //dd($Status);

        $statusData = DB::select('CALL view_statusById(' . $id . ')');
        $statusTemp = $statusData[0];

        if ($statusTemp) {
            $response = DB::statement('CALL update_status(:dataStatus)', ['dataStatus' => $Status]);

            if ($response) {
                return redirect()->route('Status.index')->with('success', 'Status Berhasil Diubah!');
            } else {
                return redirect()->route('Status.edit', $id)->with('error', 'Status Gagal Diubah!');
            }

        } else {
            return redirect()->route('Status.index')->with('error', 'Status Tidak Ditemukan!');
        }
    }

    public function updateFilePerjanjianSewa(Request $request)
    {
        $perjanjianSewaData = DB::select('CALL view_perjanjianSewaById(' . $request->get('idFilePerjanjian') . ')');
        $perjanjianSewa = $perjanjianSewaData[0];

        //dd($perjanjianSewa);

        $file = Storage::disk('biznet')->get($perjanjianSewa->fileSuratPerjanjian);

        //dd($file);

        if ($file) {
            Storage::disk('biznet')->delete($perjanjianSewa->fileSuratPerjanjian);

            if ($request->hasFile('filePerjanjianSewa')) {
                $uploadedFile = $request->file('filePerjanjianSewa');
                $filePerjanjian = "SuratPerjanjian-" . $perjanjianSewa->npwrd . "-" . time() . "." . $uploadedFile->getClientOriginalExtension();
                $filePath = Storage::disk('biznet')->putFileAs("documents/perjanjianSewa", $uploadedFile, $filePerjanjian);
            } else {
                $filePath = "";
            }

            $dataSuratPerjanjian = json_encode([
                'IdPerjanjianSewa' => $request->get('idFilePerjanjian'),
                'FileSuratPerjanjian' => $filePath
            ]);

            //dd($dataSuratPerjanjian);


            if ($perjanjianSewa) {
                $response = DB::statement('CALL update_fileSuratPerjanjian(:dataSuratPerjanjian)', ['dataSuratPerjanjian' => $dataSuratPerjanjian]);

                if ($response) {
                    return redirect()->route('Perjanjian.edit', $perjanjianSewa->idPerjanjianSewa)->with('success', 'File Surat Perjanjian Berhasil Diubah!');
                } else {
                    return redirect()->route('Perjanjian.edit', $perjanjianSewa->idPerjanjianSewa)->with('error', 'File Surat Perjanjian Gagal Diubah!');
                }

            }
        } else {
            //return redirect()->route('ObjekRetribusi.edit', $objekRetribusi->idObjekRetribusi)->with('error', 'File/Gambar Denah Tanah Tidak Ditemukan!');

            if ($request->hasFile('filePerjanjianSewa')) {
                $uploadedFile = $request->file('filePerjanjianSewa');
                $filePerjanjian = "SuratPerjanjian-" . $perjanjianSewa->npwrd . "-" . time() . "." . $uploadedFile->getClientOriginalExtension();
                $filePath = Storage::disk('biznet')->putFileAs("documents/perjanjianSewa", $uploadedFile, $filePerjanjian);
            } else {
                $filePath = "";
            }

            $dataSuratPerjanjian = json_encode([
                'IdPerjanjianSewa' => $request->get('idFilePerjanjian'),
                'FileSuratPerjanjian' => $filePath
            ]);

            //dd($dataSuratPerjanjian);


            if ($perjanjianSewa) {
                $response = DB::statement('CALL update_fileSuratPerjanjian(:dataSuratPerjanjian)', ['dataSuratPerjanjian' => $dataSuratPerjanjian]);

                if ($response) {
                    return redirect()->route('Perjanjian.edit', $perjanjianSewa->idPerjanjianSewa)->with('success', 'File Surat Perjanjian Berhasil Diubah!');
                } else {
                    return redirect()->route('Perjanjian.edit', $perjanjianSewa->idPerjanjianSewa)->with('error', 'File Surat Perjanjian Gagal Diubah!');
                }

            }
        }
    }

    public function delete(Request $request)
    {
        $statusData = DB::select('CALL view_statusById(' . $request->get('idStatus') . ')');
        $statusTemp = $statusData[0];

        if ($statusTemp) {
            $id = $request->get('idStatus');

            $response = DB::statement('CALL delete_status(?)', [$id]);

            return response()->json([
                'status' => 200,
                'message' => 'Status Berhasil Dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Status Tidak Ditemukan.'
            ]);
        }
    }

    public function detail($id)
    {        
        $perjanjianData = DB::select('CALL view_perjanjianSewaById(' . $id . ')');

        $saksiPerjanjian = DB::select('CALL view_saksiPerjanjianById(' . $id . ')');
        //dd($perjanjianData);

        if ($perjanjianData) {

            $perjanjianSewa = $perjanjianData[0];

            return view('admin.SewaAset.Perjanjian.detail', compact('perjanjianSewa', 'saksiPerjanjian'));
        } else {
             return redirect()->route('Perjanjian.index')->with('error', 'Data Perjanjian Sewa Tidak Ditemukan!');
        }
    }

    public function storeStatusType(Request $request)
    {

        $JenisStatus = json_encode([
            'JenisStatus' => $request->get('jenisStatusModal'),
            'Keterangan' => $request->get('jenisKeteranganModal')
        ]);

        //dd($JenisStatus);

        $response = DB::statement('CALL insert_jenisStatus(:dataJenisStatus)', ['dataJenisStatus' => $JenisStatus]);

        if ($response) {
            return response()->json([
                'status' => 200,
                'message' => 'Jenis Status Berhasil Ditambahkan.'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Jenis Status Gagal Ditambahkan.'
            ]);
        }
    }

    public function generateDraftPerjanjianPdf($id)
    {
        $perjanjianData = DB::select('CALL view_perjanjianSewaById(?)', [$id]);

        if ($perjanjianData) {
            $draftPerjanjian = $perjanjianData[0];
            $saksiPerjanjian = DB::select('CALL view_saksiPerjanjianById(?)', [$id]);

            //$firstPageContent = view('admin.SewaAset.Perjanjian.partialsDraft.first-page', compact('draftPerjanjian'))->render();
            //$otherPageContent = view('admin.SewaAset.Perjanjian.partialsDraft.other-pages', compact('draftPerjanjian'))->render();

            /*$pdf = Pdf::view('admin.SewaAset.Perjanjian.draft', compact('draftPerjanjian', 'saksiPerjanjian'))
            ->paperSize(210, 297)
            ->margins(0, 0, 0, 0)
            ->inline('invoice.pdf');

        return $pdf->inline('laporan.pdf');*/

            $pdf = Pdf::loadView('admin.SewaAset.Perjanjian.draft', compact('draftPerjanjian', 'saksiPerjanjian'))
                ->setPaper('a4', 'portrait'); // a4 = ukuran, portrait/landscape = orientasi

            return $pdf->stream('dokumen.pdf');
        }
    }

    public function getComboJenisStatus()
    {
        $statusTypeCombo = DB::select('CALL cbo_JenisStatus()');

        return response()->json($statusTypeCombo);
    }
}