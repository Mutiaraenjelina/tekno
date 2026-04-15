<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class JenisStatusController extends Controller
{
    public function index()
    {
        $statusType = DB::select('CALL viewAll_JenisStatus()');  

        return view('admin.PengaturanDanKonfigurasi.JenisStatus.index', compact('statusType'));

        //return view('admin.PengaturanDanKonfigurasi.JenisStatus.index');
        
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.JenisStatus.create');
    }

    public function store(Request $request)
    {
        
            $JenisStatus = json_encode([
                'JenisStatus' => $request->get('jenisStatus'),
                'Keterangan'  => $request->get('keterangan')
            ]);
    
            $response = DB::statement('CALL insert_jenisStatus(:dataJenisStatus)', ['dataJenisStatus' => $JenisStatus]);
        
            //print_r($response);

            if ($response) {
                return redirect()->route('JenisStatus.index')->with('success', 'Jenis Status Berhasil Ditambahkan!');
                //return redirect()->route('JenisStatus.create');
            } else {
                return redirect()->route('JenisStatus.create')->with('error', 'Jenis Status Gagal Disimpan!');
                //return redirect()->route('JenisStatus.index');
            }
    }

    public function edit($id)
    {   
        $statusTypeData = DB::select('CALL view_jenisStatusById(' . $id . ')');
        $statusType = $statusTypeData[0];

        if ($statusType) {
            return view('admin.PengaturanDanKonfigurasi.JenisStatus.edit', ['statusType' => $statusType]);
         } else {
             return redirect()->route('JenisStatus.index')->with('error', 'Jenis Status Tidak Ditemukan!');
         }
        //return view('admin.PengaturanDanKonfigurasi.JenisStatus.edit');
    }


    public function update(Request $request, $id)
    {
        $jenisStatus = json_encode([
            'IdJenisStatus' => $id,
            'JenisStatus' => $request -> get('jenisStatus'),
            'Keterangan'  => $request->get('keterangan')
        ]);

            $statusTypeData = DB::select('CALL view_jenisStatusById(' . $id . ')');
            $statusTypeTemp = $statusTypeData[0];

        if ($statusTypeTemp) {
            $response = DB::statement('CALL update_jenisStatus(:dataJenisStatus)', ['dataJenisStatus' => $jenisStatus]);

            //dd($response);
            if ($response) {
                return redirect()->route('JenisStatus.index')->with('success', 'Jenis Status Berhasil Diubah!');
            } else {
                return redirect()->route('JenisStatus.edit', $id)->with('error', 'Jenis Status Gagal Diubah!');
            }

         } else {
             return redirect()->route('JenisStatus.index')->with('error', 'Data Jenis Status Tidak Ditemukan!');
         }      
    }

    public function delete(Request $request)
    {
        $statusTypeData = DB::select('CALL view_jenisStatusById(' . $request -> get('idJenisStatus') . ')');
        $statusType = $statusTypeData[0];

            if ($statusType) {
                $id = $request -> get('idJenisStatus');

                $response = DB::select('CALL delete_jenisStatus(?)', [$id]);
                
                return response()->json([
                    'status' => 200,
                    'message'=> 'Jenis Status Berhasil Dihapus.'
                ]);
            }else{
                return response()->json([
                    'status'=> 404,
                    'message' => 'Data Jenis Status Tidak Ditemukan.'
                ]);
            }
    }

    public function detail(Request $request)
    {      
        $id = $request->id;

        $statusTypeData = DB::select('CALL view_jenisStatusById(' . $id . ')');
        $statusType = $statusTypeData[0];

        //dd($fieldEducation);

        if ($statusType) {
            return response()->json([
                'status'=> 200,
                'statusType' => $statusType
            ]);
        }else{
            return response()->json([
                'status'=> 404,
                'message' => 'Data Jenis Status Tidak Ditemukan.'
            ]);
        }
    }
}
