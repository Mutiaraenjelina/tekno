<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class JenisDokumenController extends Controller
{
    public function index()
    {
        $dokumenType = DB::select('CALL viewAll_jenisDokumen()'); 

        return view('admin.PengaturanDanKonfigurasi.JenisDokumen.index', compact('dokumenType'));

        //return view('admin.PengaturanDanKonfigurasi.JenisStatus.index');
        
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.JenisDokumen.create');
    }

    public function store(Request $request)
    {
        // Encode request data to JSON
        $dokumenType = json_encode([
            'JenisDokumen' => $request->get('jenisDokumen'),
            'Keterangan'  => $request->get('keterangan')
        ]);

        // Execute stored procedure with JSON parameter
        $response = DB::statement('CALL insert_jenisDokumen(:dataJenisDokumen)', ['dataJenisDokumen' => $dokumenType]);

        // Check response and redirect accordingly
        if ($response) {
            return redirect()->route('JenisDokumen.index')->with('success', 'Jenis Dokumen Berhasil Ditambahkan!');
        } else {
            return redirect()->route('JenisDokumen.create')->with('error', 'Jenis Dokumen Gagal Disimpan!');
        }
    }

    public function edit($id)
    {   
        $dokumenTypeData = DB::select('CALL view_jenisDokumenById(' . $id . ')');
        $dokumenType = $dokumenTypeData[0];

        if ($dokumenType) {
            return view('admin.PengaturanDanKonfigurasi.JenisDokumen.edit', ['dokumenType' => $dokumenType]);
        } else {
            return redirect()->route('JenisDokumen.index')->with('error', 'Jenis Dokumen Tidak Ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        $dokumenType = json_encode([
            'IdJenisDokumen' => $id,
            'JenisDokumen' => $request->get('jenisDokumen'),
            'Keterangan' => $request->get('keterangan')
        ]);

        $dokumenTypeData = DB::select('CALL view_jenisDokumenById(?)', [$id]);
        $dokumenTypeTemp = $dokumenTypeData[0] ?? null;

        if (!empty($dokumenTypeTemp)) {
            // Memanggil stored procedure untuk update
            $response = DB::statement('CALL update_jenisDokumen(?)', [$dokumenType]);

            if ($response) {
                return redirect()->route('JenisDokumen.index')->with('success', 'Jenis Jenis Dokumen Berhasil Diubah!');
            } else {
                return redirect()->route('JenisDokumen.edit', $id)->with('error', 'Jenis Jenis Dokumen Gagal Diubah!');
            }
        } else {
            return redirect()->route('JenisDokumen.index')->with('error', 'Data Jenis Jenis Dokumen Tidak Ditemukan!');
        }
    }

    public function delete(Request $request)
    {
        $dokumenTypeData = DB::select('CALL view_jenisDokumenById(' . $request -> get('idJenisDokumen') . ')');
        $dokumenTypeType = $dokumenTypeData[0];

            if ($dokumenTypeType) {
                $id = $request -> get('idJenisDokumen');

                $response = DB::select('CALL delete_jenisDokumen(?)', [$id]);
                
                return response()->json([
                    'status' => 200,
                    'message'=> 'Jenis Dokumen Berhasil Dihapus.'
                ]);
            }else{
                return response()->json([
                    'status'=> 404,
                    'message' => 'Data Jenis Dokumen Tidak Ditemukan.'
                ]);
            }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $dokumenTypeData = DB::select('CALL view_jenisDokumenById(' . $id . ')');
        $dokumenType = $dokumenTypeData[0];

        if ($dokumenType) {
            return response()->json([
                'status' => 200,
                'dokumenType' => $dokumenType
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Jenis Dokumen Tidak Ditemukan.'
            ]);
        }
    }

}