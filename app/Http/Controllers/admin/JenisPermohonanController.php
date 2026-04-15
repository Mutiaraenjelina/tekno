<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class JenisPermohonanController extends Controller
{
    public function index()
    {
        $PermohonanType = DB::select('CALL viewAll_jenisPermohonan()'); 

        return view('admin.PengaturanDanKonfigurasi.JenisPermohonan.index', compact('PermohonanType'));

        //return view('admin.PengaturanDanKonfigurasi.JenisStatus.index');
        
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.JenisPermohonan.create');
    }

    public function store(Request $request)
    {
        // Encode request data to JSON
        $JenisPermohonan = json_encode([
            'ParentId' => $request->get('parentId'),
            'JenisPermohonan' => $request->get('jenisPermohonan'),
            'Keterangan'  => $request->get('keterangan')
        ]);

        // Execute stored procedure with JSON parameter
        $response = DB::statement('CALL insert_jenisPermohonan(:dataJenisPermohonan)', ['dataJenisPermohonan' => $JenisPermohonan]);

        // Check response and redirect accordingly
        if ($response) {
            return redirect()->route('JenisPermohonan.index')->with('success', 'Jenis Permohonan Berhasil Ditambahkan!');
        } else {
            return redirect()->route('JenisPermohonan.create')->with('error', 'Jenis Permohonan Gagal Disimpan!');
        }
    }

    public function edit($id)
    {   
        $PermohonanTypeData = DB::select('CALL view_jenisPermohonanById(?)', [$id]);
        $PermohonanType = $PermohonanTypeData[0];

        if ($PermohonanType) {
            return view('admin.PengaturanDanKonfigurasi.JenisPermohonan.edit', ['PermohonanType' => $PermohonanType]);
        } else {
            return redirect()->route('JenisPermohonan.index')->with('error', 'Jenis Permohonan Tidak Ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        $JenisPermohonan = json_encode([
            'idJenisPermohonan' => $id,
            'ParentId' => $request -> get('parentId'),
            'JenisPermohonan' => $request -> get('jenisPermohonan'),
            'Keterangan'  => $request->get('keterangan')
        ]);

        $PermohonanTypeData = DB::select('CALL view_jenisPermohonanById(?)', [$id]);
        $PermohonanTypeTemp = $PermohonanTypeData[0];
            
            //dd($statusTypeTemp);

        if ($PermohonanTypeTemp) {
            $response = DB::statement('CALL update_jenisPermohonan(:dataJenisPermohonan)', ['dataJenisPermohonan' => $JenisPermohonan]);

            //dd($response);
            if ($response) {
                return redirect()->route('JenisPermohonan.index')->with('success', 'Jenis Permohonan Berhasil Diubah!');
            } else {
                return redirect()->route('JenisPermohonan.edit', $id)->with('error', 'Jenis Permohonan Gagal Diubah!');
            }

         } else {
             return redirect()->route('JenisPermohonan.index')->with('error', 'Data Jenis Permohonan Tidak Ditemukan!');
         }      
    }

    public function delete(Request $request)
    {
        $PermohonanTypeData = DB::select('CALL view_jenisPermohonanById(' . $request -> get('idJenisPermohonan') . ')');
        $PermohonanType = $PermohonanTypeData[0];

            if ($PermohonanType) {
                $id = $request -> get('idJenisPermohonan');

                $response = DB::select('CALL delete_jenisPermohonan(?)', [$id]);
                
                return response()->json([
                    'status' => 200,
                    'message'=> 'Jenis Permohonan Berhasil Dihapus.'
                ]);
            }else{
                return response()->json([
                    'status'=> 404,
                    'message' => 'Data Jenis Permohonan Tidak Ditemukan.'
                ]);
            }
    }

    public function detail(Request $request)
    {      
        $id = $request->id;

        $PermohonanTypeData = DB::select('CALL view_jenisPermohonanById(' . $id . ')');
        $PermohonanType = $PermohonanTypeData[0];

        //dd($fieldEducation);

        if ($PermohonanType) {
            return response()->json([
                'status'=> 200,
                'PermohonanType' => $PermohonanType
            ]);
        }else{
            return response()->json([
                'status'=> 404,
                'message' => 'Data Jenis Permohonan Tidak Ditemukan.'
            ]);
        }
    }
}

