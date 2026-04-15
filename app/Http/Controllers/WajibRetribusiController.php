<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class WajibRetribusiController extends Controller
{
    private $stat = 1;
    protected $dataUser;
    private $parentIdPermohonan = 1;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Try to get userSession from session
            $sessionData = Session::get('userSession');
            
            // If userSession doesn't exist, fetch from database
            if (!$sessionData) {
                $userId = Session::get('user_id');
                $user = \App\Models\User::findOrFail($userId);
                $sessionData = [(object)[
                    'id' => $user->id,
                    'idPersonal' => $user->idPersonal,
                    'username' => $user->username,
                    'roleId' => $user->roleId,
                    'idJenisUser' => $user->idJenisUser
                ]];
            }

            // Pastikan jadi Collection tanpa json_decode
            $this->dataUser = collect($sessionData);

            return $next($request);
        });
    }

    public function dashboardUser()
    {
        return view('user.Dashboard.index');
    }

   
    public function objekRetribusi()
    {
        $objekRetribusi = DB::select('CALL viewAll_objekRetribusi()');

        return view('user.ObjekRetribusi.index', compact('objekRetribusi'));
    }

    public function objekRetribusiDetail($id)
    {
        $objekRetribusiData = DB::select('CALL view_objekRetribusiById(' . $id . ')');
        $objekRetribusi = $objekRetribusiData[0];

        $fotoObjek = DB::select('CALL view_photoObjekRetribusiById(' . $id . ')');

        //dd($fieldEducation);

        return view('user.ObjekRetribusi.detail', compact('objekRetribusi', 'fotoObjek'));
    }

    public function tarifObjekRetribusi()
    {
        $tarifRetribusi = DB::select('CALL viewAll_tarifObjekRetribusi()');

        return view('user.TarifObjekRetribusi.index', compact('tarifRetribusi'));
    }

    public function detailTarif(Request $request)
    {
        $id = $request->idTarif;

        $tarifObjekData = DB::select('CALL view_TarifObjekRetribusiById(' . $id . ')');
        $tarifObjek = $tarifObjekData[0];

        if ($tarifObjek) {
            return response()->json([
                'status' => 200,
                'tarifObjek' => $tarifObjek
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Tarif Objek Retribusi Tidak Ditemukan.'
            ]);
        }
    }

    public function permohonanSewa()
    {
        $id = $this->dataUser[0]->idPersonal;
        $permohonanSewa = DB::select('CALL viewAll_permohonanSewaByIdWajibRetribusi(' . $id . ')');

        return view('user.PermohonanSewa.index', compact('permohonanSewa'));

        //dd($permohonanSewa);
    }

    public function detailPermohonanSewa($id)
    {
         $idStatus = "0";

        
        $dokumenKelengkapan = DB::select('CALL cbo_dokumenKelengkapan(' . 2 . ')');
        $dokumenPermohonan = DB::select('CALL view_dokumenPermohonanById(' . $id . ')');

        $permohonanData = DB::select('CALL view_PermohonanSewaByIdAndStatus(?, ?)', [$id, $idStatus]);
        $permohonanSewa = $permohonanData[0];

        //dd($fieldEducation);

        return view('user.PermohonanSewa.detail', compact('permohonanSewa', 'dokumenKelengkapan', 'dokumenPermohonan'));
    }

    public function createPermohonanSewa()
    {
        $jenisPermohonan = DB::select('CALL cbo_jenisPermohonanByParentId(' . $this->parentIdPermohonan . ')');
        $wajibRetribusi = DB::select('CALL cbo_wajibRetribusi()');
        $objekRetribusi = DB::select('CALL cbo_objekRetribusi()');
        $jangkaWaktu = DB::select('CALL cbo_jenisJangkaWaktu()');
        $peruntukanSewa = DB::select('CALL cbo_peruntukanSewa()');
        $dokumenKelengkapan = DB::select('CALL cbo_dokumenKelengkapan(' . 2 . ')');
        $satuan = DB::select('CALL cbo_satuan(' . 1 . ')');

        return view('user.PermohonanSewa.create', compact('jenisPermohonan', 'wajibRetribusi', 'objekRetribusi', 'jangkaWaktu', 'peruntukanSewa', 'dokumenKelengkapan', 'satuan'));
    }

    public function storePermohonanSewa(Request $request)
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
            'WajibRetribusi' => $this->dataUser[0]->idPersonal,
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

        dd($Permohonan);

        $response = DB::statement('CALL insert_permohonanSewa(:dataPermohonan)', ['dataPermohonan' => $Permohonan]);

        if ($response) {
            return redirect()->route('WajibRetribusi.permohonanSewa')->with('success', 'Permohonan Sewa Berhasil Ditambahkan!');
        } else {
            return redirect()->route('WajibRetribusi.permohonanSewa')->with('error', 'Permohonan Sewa Gagal Disimpan!');
        }
    }
}
