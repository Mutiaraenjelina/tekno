<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LokasiObjekRetribusiController extends Controller
{
    public function index()
    {
        $lokasiObjekRetribusi = DB::select('CALL viewAll_LokasiObjekRetribusi()');

        return view('admin.PengaturanDanKonfigurasi.LokasiObjekRetribusi.index', compact('lokasiObjekRetribusi'));
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.LokasiObjekRetribusi.create');
    }

    public function store(Request $request)
    {
        $lokasiObjekRetribusi = json_encode([
            'LokasiObjekRetribusi' => $request->get('LokasiObjekRetribusi'),
            'Keterangan' => $request->get('Keterangan')
        ]);

        $response = DB::statement('CALL insert_LokasiObjekRetribusi(:dataLokasiObjekRetribusi)', ['dataLokasiObjekRetribusi' => $lokasiObjekRetribusi]);

        if ($response) {
            return redirect()->route('LokasiObjekRetribusi.index')->with('success', 'Lokasi Objek Retribusi Berhasil Ditambahkan!');
        } else {
            return redirect()->route('LokasiObjekRetribusi.create')->with('error', 'Lokasi Objek Retribusi Gagal Disimpan!');
        }
    }

    public function edit($id)
    {
        $lokasiObjekRetribusiData = DB::select('CALL view_LokasiObjekRetribusiById(' . $id . ')');
        $lokasiObjekRetribusi = $lokasiObjekRetribusiData[0];

        if ($lokasiObjekRetribusi) {
            return view('admin.PengaturanDanKonfigurasi.LokasiObjekRetribusi.edit', ['lokasiObjekRetribusi' => $lokasiObjekRetribusi]);
        } else {
            return redirect()->route('LokasiObjekRetribusi.index')->with('error', 'Lokasi Objek Retribusi Tidak Ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        $lokasiObjekRetribusi = json_encode([
            'IdLokasiObjekRetribusi' => $id,
            'LokasiObjekRetribusi' => $request->get('LokasiObjekRetribusi'),
            'Keterangan' => $request->get('Keterangan')
        ]);

        $lokasiObjekRetribusiData = DB::select('CALL view_LokasiObjekRetribusiById(' . $id . ')');
        $lokasiObjekRetribusiTemp = $lokasiObjekRetribusiData[0];

        if ($lokasiObjekRetribusiTemp) {
            $response = DB::statement('CALL update_LokasiObjekRetribusi(:dataLokasiObjekRetribusi)', ['dataLokasiObjekRetribusi' => $lokasiObjekRetribusi]);

            if ($response) {
                return redirect()->route('LokasiObjekRetribusi.index')->with('success', 'Lokasi Objek Retribusi Berhasil Diubah!');
            } else {
                return redirect()->route('LokasiObjekRetribusi.edit', $id)->with('error', 'Lokasi Objek Retribusi Gagal Diubah!');
            }
        } else {
            return redirect()->route('LokasiObjekRetribusi.index')->with('error', 'Data Lokasi Objek Retribusi Tidak Ditemukan!');
        }
    }

    public function delete(Request $request)
    {
        $lokasiObjekRetribusiData = DB::select('CALL view_LokasiObjekRetribusiById(' . $request->get('idLokasiObjekRetribusi') . ')');
        $lokasiObjekRetribusi = $lokasiObjekRetribusiData[0];

        if ($lokasiObjekRetribusi) {
            $id = $request->get('idLokasiObjekRetribusi');

            $response = DB::select('CALL delete_LokasiObjekRetribusi(?)', [$id]);

            return response()->json([
                'status' => 200,
                'message' => 'Lokasi Objek Retribusi Berhasil Dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Lokasi Objek Retribusi Tidak Ditemukan.'
            ]);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $lokasiObjekRetribusiData = DB::select('CALL view_LokasiObjekRetribusiById(' . $id . ')');
        $lokasiObjekRetribusi = $lokasiObjekRetribusiData[0];

        if ($lokasiObjekRetribusi) {
            return response()->json([
                'status' => 200,
                'lokasiObjekRetribusi' => $lokasiObjekRetribusi
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Lokasi Objek Retribusi Tidak Ditemukan.'
            ]);
        }
    }
}
