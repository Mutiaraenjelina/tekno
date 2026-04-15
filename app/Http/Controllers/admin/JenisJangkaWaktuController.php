<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class JenisJangkaWaktuController extends Controller
{
    public function index()
    {
        $JangkaWaktuType = DB::select('CALL viewAll_jenisJangkaWaktu()'); 

        return view('admin.PengaturanDanKonfigurasi.jenisJangkaWaktu.index', compact('JangkaWaktuType'));

        //return view('admin.PengaturanDanKonfigurasi.JenisStatus.index');
        
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.jenisJangkaWaktu.create');
    }

    public function store(Request $request)
    {
        // Encode request data to JSON
        $JenisJangkaWaktu = json_encode([
            'JenisJangkaWaktu' => $request->get('jenisJangkaWaktu'),
            'Keterangan'  => $request->get('keterangan')
        ]);

        // Execute stored procedure with JSON parameter
        $response = DB::statement('CALL insert_jenisJangkaWaktu(:dataJenisJangkaWaktu)', ['dataJenisJangkaWaktu' => $JenisJangkaWaktu]);

        // Check response and redirect accordingly
        if ($response) {
            return redirect()->route('jenisJangkaWaktu.index')->with('success', 'Perioditas Berhasil Ditambahkan!');
        } else {
            return redirect()->route('jenisJangkaWaktu.create')->with('error', 'Perioditas Gagal Disimpan!');
        }
    }

    public function edit($id)
    {   
        $JangkaWaktuTypeData = DB::select('CALL view_jenisJangkaWaktuById(' . $id . ')');
        $JangkaWaktuType = $JangkaWaktuTypeData[0];

        if ($JangkaWaktuType) {
            return view('admin.PengaturanDanKonfigurasi.jenisJangkaWaktu.edit', ['JangkaWaktuType' => $JangkaWaktuType]);
        } else {
            return redirect()->route('jenisJangkaWaktu.index')->with('error', 'Perioditas Tidak Ditemukan!');
        }
    }

    public function update(Request $request, $id)
{
    $jenisJangkaWaktu = json_encode([
        'IdJenisJangkaWaktu' => $id,
        'JenisJangkaWaktu' => $request->get('jenisJangkaWaktu'),
        'Keterangan' => $request->get('keterangan')
    ]);

    $JangkaWaktuTypeData = DB::select('CALL view_jenisJangkaWaktuById(?)', [$id]);
    $JangkaWaktuTypeTemp = $JangkaWaktuTypeData[0] ?? null;

    if (!empty($JangkaWaktuTypeTemp)) {
        // Memanggil stored procedure untuk update
        $response = DB::statement('CALL update_jenisJangkaWaktu(?)', [$jenisJangkaWaktu]);

        if ($response) {
            return redirect()->route('jenisJangkaWaktu.index')->with('success', 'Perioditas Berhasil Diubah!');
        } else {
            return redirect()->route('jenisJangkaWaktu.edit', $id)->with('error', 'JPerioditas Gagal Diubah!');
        }
    } else {
        return redirect()->route('jenisJangkaWaktu.index')->with('error', 'Data Perioditas Tidak Ditemukan!');
    }
}


    public function delete(Request $request)
    {
        $JangkaWaktuTypeData = DB::select('CALL view_jenisJangkaWaktuById(' . $request -> get('idJenisJangkaWaktu') . ')');
        $jangkaWaktuType = $JangkaWaktuTypeData[0];

            if ($jangkaWaktuType) {
                $id = $request -> get('idJenisJangkaWaktu');

                $response = DB::select('CALL delete_jenisJangkaWaktu(?)', [$id]);
                
                return response()->json([
                    'status' => 200,
                    'message'=> 'Perioditas Berhasil Dihapus.'
                ]);
            }else{
                return response()->json([
                    'status'=> 404,
                    'message' => 'Data Perioditas Tidak Ditemukan.'
                ]);
            }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $jenisJangkaWaktuData = DB::select('CALL view_jenisJangkaWaktuById(' . $id . ')');
        $jenisJangkaWaktu = $jenisJangkaWaktuData[0];

        if ($jenisJangkaWaktu) {
            return response()->json([
                'status' => 200,
                'jenisJangkaWaktu' => $jenisJangkaWaktu
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Perioditas Tidak Ditemukan.'
            ]);
        }
    }

}