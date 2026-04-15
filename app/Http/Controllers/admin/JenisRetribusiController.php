<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class JenisRetribusiController extends Controller
{
    public function index()
    {
        $retribusi = DB::select('CALL viewAll_JenisRetribusi()');

        return view('admin.PengaturanDanKonfigurasi.JenisRetribusi.index', compact('retribusi'));
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.JenisRetribusi.create');
    }

    public function store(Request $request)
    {
        $retribusi = json_encode([
            'JenisRetribusi' => $request->get('JenisRetribusi'),
            'Keterangan' => $request->get('Keterangan')
        ]);

        $response = DB::statement('CALL insert_JenisRetribusi(:dataJenisRetribusi)', ['dataJenisRetribusi' => $retribusi]);

        if ($response) {
            return redirect()->route('JenisRetribusi.index')->with('success', 'Jenis Retribusi Berhasil Ditambahkan!');
        } else {
            return redirect()->route('JenisRetribusi.create')->with('error', 'Jenis Retribusi Gagal Disimpan!');
        }
    }

    public function edit($id)
    {
        $retribusiData = DB::select('CALL view_JenisRetribusiById(' . $id . ')');
        $retribusi = $retribusiData[0];

        if ($retribusi) {
            return view('admin.PengaturanDanKonfigurasi.JenisRetribusi.edit', ['retribusi' => $retribusi]);
        } else {
            return redirect()->route('JenisRetribusi.index')->with('error', 'Jenis Retribusi Tidak Ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        $retribusi = json_encode([
            'IdJenisRetribusi' => $id,
            'JenisRetribusi' => $request->get('JenisRetribusi'),
            'Keterangan' => $request->get('Keterangan')
        ]);

        $retribusiData = DB::select('CALL view_JenisRetribusiById(' . $id . ')');
        $retribusiTemp = $retribusiData[0];

        if ($retribusiTemp) {
            $response = DB::statement('CALL update_JenisRetribusi(:dataJenisRetribusi)', ['dataJenisRetribusi' => $retribusi]);

            if ($response) {
                return redirect()->route('JenisRetribusi.index')->with('success', 'Jenis Retribusi Berhasil Diubah!');
            } else {
                return redirect()->route('JenisRetribusi.edit', $id)->with('error', 'Jenis Retribusi Gagal Diubah!');
            }
        } else {
            return redirect()->route('JenisRetribusi.index')->with('error', 'Data Jenis Retribusi Tidak Ditemukan!');
        }
    }

    public function delete(Request $request)
    {
        $retribusiData = DB::select('CALL view_JenisRetribusiById(' . $request->get('idJenisRetribusi') . ')');
        $retribusi = $retribusiData[0];

        if ($retribusi) {
            $id = $request->get('idJenisRetribusi');

            $response = DB::select('CALL delete_JenisRetribusi(?)', [$id]);

            return response()->json([
                'status' => 200,
                'message' => 'Jenis Retribusi Berhasil Dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Jenis Retribusi Tidak Ditemukan.'
            ]);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $retribusiData = DB::select('CALL view_JenisRetribusiById(' . $id . ')');
        $retribusi = $retribusiData[0];

        if ($retribusi) {
            return response()->json([
                'status' => 200,
                'retribusi' => $retribusi
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Jenis Retribusi Tidak Ditemukan.'
            ]);
        }
    }
}
