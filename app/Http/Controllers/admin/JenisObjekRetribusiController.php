<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisObjekRetribusiController extends Controller
{
    public function index()
    {
        $objekRetribusi = DB::select('CALL viewAll_JenisObjekRetribusi()');

        return view('admin.PengaturanDanKonfigurasi.JenisObjekRetribusi.index', compact('objekRetribusi'));
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.JenisObjekRetribusi.create');
    }

    public function store(Request $request)
    {
        $objekRetribusi = json_encode([
            'JenisObjekRetribusi' => $request->get('JenisObjekRetribusi'),
            'Keterangan' => $request->get('Keterangan')
        ]);

        //dd($objekRetribusi);

        $response = DB::statement('CALL insert_JenisObjekRetribusi(:dataJenisObjekRetribusi)', ['dataJenisObjekRetribusi' => $objekRetribusi]);

        if ($response) {
            return redirect()->route('JenisObjekRetribusi.index')->with('success', 'Jenis Objek Retribusi Berhasil Ditambahkan!');
        } else {
            return redirect()->route('JenisObjekRetribusi.create')->with('error', 'Jenis Objek Retribusi Gagal Disimpan!');
        }
    }

    public function edit($id)
    {
        $objekRetribusiData = DB::select('CALL view_JenisObjekRetribusiById(' . $id . ')');
        $objekRetribusi = $objekRetribusiData[0];

        if ($objekRetribusi) {
            return view('admin.PengaturanDanKonfigurasi.JenisObjekRetribusi.edit', ['objekRetribusi' => $objekRetribusi]);
        } else {
            return redirect()->route('JenisObjekRetribusi.index')->with('error', 'Jenis Objek Retribusi Tidak Ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        $objekRetribusi = json_encode([
            'IdJenisObjekRetribusi' => $id,
            'JenisObjekRetribusi' => $request->get('JenisObjekRetribusi'),
            'Keterangan' => $request->get('Keterangan')
        ]);

        $objekRetribusiData = DB::select('CALL view_JenisObjekRetribusiById(' . $id . ')');
        $objekRetribusiTemp = $objekRetribusiData[0];

        if ($objekRetribusiTemp) {
            $response = DB::statement('CALL update_JenisObjekRetribusi(:dataJenisObjekRetribusi)', ['dataJenisObjekRetribusi' => $objekRetribusi]);

            if ($response) {
                return redirect()->route('JenisObjekRetribusi.index')->with('success', 'Jenis Objek Retribusi Berhasil Diubah!');
            } else {
                return redirect()->route('JenisObjekRetribusi.edit', $id)->with('error', 'Jenis Objek Retribusi Gagal Diubah!');
            }
        } else {
            return redirect()->route('JenisObjekRetribusi.index')->with('error', 'Data Jenis Objek Retribusi Tidak Ditemukan!');
        }
    }

    public function delete(Request $request)
    {
        $objekRetribusiData = DB::select('CALL view_JenisObjekRetribusiById(' . $request->get('idJenisObjekRetribusi') . ')');
        $objekRetribusi = $objekRetribusiData[0];

        if ($objekRetribusi) {
            $id = $request->get('idJenisObjekRetribusi');

            $response = DB::select('CALL delete_JenisObjekRetribusi(?)', [$id]);

            return response()->json([
                'status' => 200,
                'message' => 'Jenis Objek Retribusi Berhasil Dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Jenis Objek Retribusi Tidak Ditemukan.'
            ]);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $objekRetribusiData = DB::select('CALL view_JenisObjekRetribusiById(' . $id . ')');
        $objekRetribusi = $objekRetribusiData[0];

        if ($objekRetribusi) {
            return response()->json([
                'status' => 200,
                'objekRetribusi' => $objekRetribusi
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Jenis Objek Retribusi Tidak Ditemukan.'
            ]);
        }
    }
}
