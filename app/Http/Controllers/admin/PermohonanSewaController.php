<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PermohonanSewaController extends Controller
{
    private $stat = 1;

    private $parentIdPermohonan = 1;

    public function index()
    {
        $permohonanSewa = DB::select('CALL viewAll_permohonanSewa()');

        return view('admin.SewaAset.Permohonan.index', compact('permohonanSewa'));

        //return view('admin.SewaAset.Permohonan.index');
    }

    public function create()
    {
        $jenisPermohonan = DB::select('CALL cbo_jenisPermohonanByParentId(' . $this->parentIdPermohonan . ')');
        $wajibRetribusi = DB::select('CALL cbo_wajibRetribusi()');
        $objekRetribusi = DB::select('CALL cbo_objekRetribusi()');
        $jangkaWaktu = DB::select('CALL cbo_jenisJangkaWaktu()');
        $peruntukanSewa = DB::select('CALL cbo_peruntukanSewa()');
        $dokumenKelengkapan = DB::select('CALL cbo_dokumenKelengkapan(' . 2 . ')');
        $satuan = DB::select('CALL cbo_satuan(' . 1 . ')');

        return view('admin.SewaAset.Permohonan.create', compact('jenisPermohonan', 'wajibRetribusi', 'objekRetribusi', 'jangkaWaktu', 'peruntukanSewa', 'dokumenKelengkapan', 'satuan'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $jenisDokumen = $request->input('jenisDokumen');
        $fileDokumen = $request->file('fileDokumen');
        $keteranganDokumen = $request->input('keteranganDokumen');

        $dokumenKelengkapan = [];

        for ($count = 0; $count < collect($jenisDokumen)->count(); $count++) {
            $uploadedFileDokumen = $fileDokumen[$count];
            $dokumenPermohonan = $count . "-" . time() . "." . $uploadedFileDokumen->getClientOriginalExtension();
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
            'Status' => $this->stat,
            'Catatan' => $request->get('catatan'),
            'DibuatOleh' => Auth::user()->id,
            'DokumenKelengkapan' => $dokumenKelengkapan
        ]);

        //dd($Permohonan);

        $response = DB::statement('CALL insert_permohonanSewa(:dataPermohonan)', ['dataPermohonan' => $Permohonan]);

        if ($response) {
            return redirect()->route('PermohonanSewa.index')->with('success', 'Permohonan Sewa Berhasil Ditambahkan!');
        } else {
            return redirect()->route('PermohonanSewa.create')->with('error', 'Permohonan Sewa Gagal Disimpan!');
        }
    }

    public function edit($id)
    {
        $jenisPermohonan = DB::select('CALL cbo_jenisPermohonanByParentId(' . $this->parentIdPermohonan . ')');
        $wajibRetribusi = DB::select('CALL cbo_wajibRetribusi()');
        $objekRetribusi = DB::select('CALL cbo_objekRetribusi()');
        $jangkaWaktu = DB::select('CALL cbo_jenisJangkaWaktu()');
        $peruntukanSewa = DB::select('CALL cbo_peruntukanSewa()');
        $dokumenKelengkapan = DB::select('CALL cbo_dokumenKelengkapan(' . 2 . ')');
        $satuan = DB::select('CALL cbo_satuan(' . 1 . ')');
        $dokumenPermohonan = DB::select('CALL view_dokumenPermohonanById(' . $id . ')');

        $permohonanData = DB::select('CALL view_permohonanById(' . $id . ')');
        $permohonanSewa = $permohonanData[0];


        return view('admin.SewaAset.Permohonan.edit', compact('jenisPermohonan', 'wajibRetribusi', 'objekRetribusi', 'jangkaWaktu', 'peruntukanSewa', 'dokumenKelengkapan', 'satuan', 'permohonanSewa', 'dokumenPermohonan'));
    }

    public function editDokumenPermohonan(Request $request){
        //$dokumenKelengkapan = DB::select('CALL cbo_dokumenKelengkapan(' . 2 . ')');
        $dokumenPermohonanData = DB::select('CALL view_dokumenPermohonanByIdDokumen(:idDokumen)', ['idDokumen' => $request->id]);
        $dokumenPermohonan = $dokumenPermohonanData[0];

        if ($dokumenPermohonan) {
            return response()->json([
                'status' => 200,
                'dokumenPermohonan' => $dokumenPermohonan
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Dokumen Permohonan Sewa Tidak Ditemukan.'
            ]);
        }
    }

    public function updateDokumenPermohonan(Request $request)
    {
        $dokumenPermohonanData = DB::select('CALL view_dokumenPermohonanByIdDokumen(:idDokumen)', ['idDokumen' => $request->idDokumenPermohonan]);
        $dokumenPermohonan = $dokumenPermohonanData[0];

        //dd($dokumenPermohonan );
        //var_dump($dokumenPermohonan);

        $strAwalDokumen = substr($dokumenPermohonan->fileName, 0, strpos($dokumenPermohonan->fileName, '-'));
        $file = Storage::disk('biznet')->get($dokumenPermohonan->namaFileDokumen);

        if ($dokumenPermohonan) {
            if ($request->hasFile('fileDokumen')) {
                if ($file) {
                    Storage::disk('biznet')->delete($dokumenPermohonan->namaFileDokumen);
                }

                $uploadedFileDokumen = $request->file('fileDokumen');
                $dokumenPermohonan = $strAwalDokumen . "-" . time() . "." . $uploadedFileDokumen->getClientOriginalExtension();
                $dokumenPermohonanPath = Storage::disk('biznet')->putFileAs("documents/permohonanSewa", $uploadedFileDokumen, $dokumenPermohonan);
            } else {
                $dokumenPermohonanPath = "";
            }

            $dataDokumenPermohonan = json_encode([
                'IdDokumenPermohonanSewa' => $request->get('idDokumenPermohonan'),
                'IdDokumenKelengkapan' => $request->get('jenisDokumen'),
                'Keterangan' => $request->get('keteranganDokumen'),
                'FileDokumen' => $dokumenPermohonanPath,
            ]);

            //dd($dataDokumenPermohonan);

            $response = DB::statement('CALL update_dokumenPermohonan(:dataDokumenPermohonan)', ['dataDokumenPermohonan' => $dataDokumenPermohonan]);

            //$dokumenPermohonan = json_decode($dokumenPermohonan, true);

            if ($response) {
                return redirect()->route('PermohonanSewa.edit', $dokumenPermohonan->idPermohonanSewa)->with('success', 'Dokumen Permohonan Sewa Berhasil Diubah!');
            } else {
                return redirect()->route('PermohonanSewa.edit', $dokumenPermohonan->idPermohonanSewa)->with('error', 'Dokumen Permohonan Sewa Gagal Diubah!');
            }

        } else {
            return redirect()->route('PermohonanSewa.edit', $dokumenPermohonan->idPermohonanSewa)->with('error', 'Dokumen Permohonan Sewa Tidak Ditemukan!');
        }
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
        $idStatus = "0";

        
        $dokumenKelengkapan = DB::select('CALL cbo_dokumenKelengkapan(' . 2 . ')');
        $dokumenPermohonan = DB::select('CALL view_dokumenPermohonanById(' . $id . ')');

        $permohonanData = DB::select('CALL view_PermohonanSewaByIdAndStatus(?, ?)', [$id, $idStatus]);
        $permohonanSewa = $permohonanData[0];

        //dd($fieldEducation);

        return view('admin.SewaAset.Permohonan.detail', compact('permohonanSewa', 'dokumenKelengkapan', 'dokumenPermohonan'));
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

    public function getComboJenisStatus()
    {
        $statusTypeCombo = DB::select('CALL cbo_JenisStatus()');

        return response()->json($statusTypeCombo);
    }

    public function approvePermohonanList()
    {
        $permohonanSewa = DB::select('CALL viewAll_permohonanSewaByStatus()');

        //dd($fieldEducation);

        return view('admin.SewaAset.Permohonan.approvePermohonanList', compact('permohonanSewa'));
    }

    public function approvePermohonanDetail($id)
    {
        $idStatus = "0";

        $permohonanData = DB::select('CALL view_PermohonanSewaByIdAndStatus(?, ?)', [$id, $idStatus]);
        $permohonanSewa = $permohonanData[0];

        //dd($fieldEducation);

        return view('admin.SewaAset.Permohonan.approvePermohonan', compact('permohonanSewa'));
    }

    public function storeApprovePermohonan(Request $request)
    {
        $permohonanData = DB::select('CALL view_permohonanById(' . $request->get('idPermohonan') . ')');
        $permohonanTemp = $permohonanData[0];

        if ($permohonanTemp) {
            $approvePermohonan = json_encode([
                'IdPermohonan' => $request->get('idPermohonan'),
                'NamaStatus' => $request->get('namaStatus'),
            ]);

            //dd($approvePermohonan);

            $response = DB::statement('CALL approve_permohonanSewa(:dataPermohonan)', ['dataPermohonan' => $approvePermohonan]);

            return response()->json([
                'status' => 200,
                'message' => 'Permohonan Berhasil Disetujui!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Permohonan Tidak Ditemukan.'
            ]);
        }
    }
}