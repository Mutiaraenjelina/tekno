<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class WajibRetribusiController extends Controller
{
    public function index()
    {
        $wajibRetribusi = DB::select('CALL viewAll_wajibRetribusi()');

        return view('admin.Master.WajibRetribusi.index', compact('wajibRetribusi'));

        //return view('admin.Master.ObjekRetribusi.index');

    }

    public function create()
    {
        $perkerjaan = DB::select('CALL cbo_pekerjaan()');
        $jenisWajibRetribusi = DB::select('CALL cbo_JenisWajibRetribusi()');
        $province = DB::select('CALL cbo_province()');
        $dokumenKelengkapan = DB::select('CALL cbo_dokumenKelengkapan(' . 2 . ')');

        return view('admin.Master.WajibRetribusi.create', compact('perkerjaan', 'jenisWajibRetribusi', 'province', 'dokumenKelengkapan'));

        //return view('admin.PengaturanDanKonfigurasi.Status.create');
    }

    public function store(Request $request)
    {
        if ($request->hasFile('photoWajibRetribusi')) {
            $uploadedFile = $request->file('photoWajibRetribusi');
            $photo = $request->get('namaWajibRetribusi') . " - " . time() . "." . $uploadedFile->getClientOriginalExtension();
            $photoPath = Storage::disk('biznet')->putFileAs("images/wajibRetribusi", $uploadedFile, $photo);
        } else {
            $photoPath = "";
        }

        $wajibRetribusi = json_encode([
            'Nik' => $request->get('nik'),
            'IdJenisWajibRetribusi' => $request->get('jenisWajib'),
            'NPWRD' => $request->get('npwrd'),
            'NamaWajibRetribusi' => $request->get('namaWajibRetribusi'),
            'NamaPekerjaan' => $request->get('pekerjaan'),
            'SubdisName' => $request->get('kelurahan'),
            'Alamat' => $request->get('alamatWajibRetribusi'),
            'NomorPonsel' => $request->get('nomorPonsel'),
            'NomorWhatsapp' => $request->get('nomorWhatsapp'),
            'Email' => $request->get('email'),
            'JenisRetribusi' => '1',
            'FotoWajibRetribusi' => $photoPath
        ]);

        $response = DB::statement('CALL insert_wajibRetribusi(:dataWajibRetribusi)', ['dataWajibRetribusi' => $wajibRetribusi]);

        if ($response) {
            return redirect()->route('WajibRetribusi.index')->with('success', 'Wajib Retribusi Berhasil Ditambahkan!');
        } else {
            return redirect()->route('WajibRetribusi.create')->with('error', 'Wajib Retribusi Gagal Disimpan!');
        }
    }

    public function edit($id)
    {
        $province = DB::select('CALL cbo_province()');

        $wajibRetribusiData = DB::select('CALL view_WajibRetribusiById(' . $id . ')');
        $wajibRetribusi = $wajibRetribusiData[0];

        $kota = DB::select('CALL cbo_cities(' . $wajibRetribusi->prov_id . ')');
        $kecamatan = DB::select('CALL cbo_districts(' . $wajibRetribusi->city_id . ')');
        $kelurahan = DB::select('CALL cbo_subdistricts(' . $wajibRetribusi->dis_id . ')');

        $pekerjaan = DB::select('CALL cbo_pekerjaan()');
        $jenisWajibRetribusi = DB::select('CALL cbo_JenisWajibRetribusi()');

        $file = Storage::disk('biznet')->get($wajibRetribusi->fotoWajibRetribusi);

        return view('admin.Master.WajibRetribusi.edit', compact('pekerjaan', 'file', 'province', 'kota', 'kecamatan', 'kelurahan', 'wajibRetribusi', 'jenisWajibRetribusi'));
    }


    public function update(Request $request)
    {
        //dd($request->all());

        $wajibRetribusiData = DB::select('CALL view_WajibRetribusiById(' . $request->get('idWajibRetribusi') . ')');
        $wajibRetribusi = $wajibRetribusiData[0];

        $file = Storage::disk('biznet')->get($wajibRetribusi->fotoWajibRetribusi);

        //dd($file);

        if ($file) {
            Storage::disk('biznet')->delete($wajibRetribusi->fotoWajibRetribusi);

            if ($request->hasFile('photoWajibRetribusi')) {
                $uploadedFile = $request->file('photoWajibRetribusi');
                $photo = $wajibRetribusi->namaWajibRetribusi . " - " . time() . "." . $uploadedFile->getClientOriginalExtension();
                $photoPath = Storage::disk('biznet')->putFileAs("images/wajibRetribusi", $uploadedFile, $photo);
            } else {
                $photoPath = "";
            }

        } else {
            if ($request->hasFile('photoWajibRetribusi')) {
                $uploadedFile = $request->file('photoWajibRetribusi');
                $photo = $wajibRetribusi->namaWajibRetribusi . " - " . time() . "." . $uploadedFile->getClientOriginalExtension();
                $photoPath = Storage::disk('biznet')->putFileAs("images/wajibRetribusi", $uploadedFile, $photo);
            } else {
                $photoPath = "";
            }
        }
        
        $wajibRetribusi = json_encode([
            'IdWajibRetribusi' => $request->get('idWajibRetribusi'),
            'Nik' => $request->get('nik'),
            'IdJenisWajibRetribusi' => $request->get('jenisWajib'),
            'NPWRD' => $request->get('npwrd'),
            'NamaWajibRetribusi' => $request->get('namaWajib'),
            'NamaPekerjaan' => $request->get('pekerjaan'),
            'SubdisName' => $request->get('kelurahan'),
            'Alamat' => $request->get('alamatWajibRetribusi'),
            'NomorPonsel' => $request->get('nomorPonsel'),
            'NomorWhatsapp' => $request->get('nomorWhatsapp'),
            'Email' => $request->get('email'),
            'FotoWajibRetribusi' => $photoPath
        ]);

        //dd($wajibRetribusi);

        if ($wajibRetribusi) {
            $response = DB::statement('CALL update_wajibRetribusi(:dataWajibRetribusi)', ['dataWajibRetribusi' => $wajibRetribusi]);

            if ($response) {
                return redirect()->route('WajibRetribusi.index')->with('success', 'Wajib Retribusi Berhasil Diubah!');
            } else {
                return redirect()->route('WajibRetribusi.edit', $wajibRetribusi->idWajibRetribusi)->with('error', 'Wajib Retribusi Gagal Diubah!');
            }
        }
    }

    public function delete(Request $request)
    {
        $wajibRetribusiData = DB::select('CALL view_WajibRetribusiById(' . $request->get('idWajib') . ')');
        $wajibRetribusiTemp = $wajibRetribusiData[0];

        if ($wajibRetribusiTemp) {
            $id = $request->get('idWajib');

            $response = DB::statement('CALL delete_wajibRetribusi(?)', [$id]);

            return response()->json([
                'status' => 200,
                'message' => 'Data Wajib Retribusi Berhasil Dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Wajib Retribusi Tidak Ditemukan.'
            ]);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->idWajib;

        $wajibRetribusiData = DB::select('CALL view_WajibRetribusiById(' . $id . ')');
        $wajibRetribusi = $wajibRetribusiData[0];

        //dd($fieldEducation);

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
}