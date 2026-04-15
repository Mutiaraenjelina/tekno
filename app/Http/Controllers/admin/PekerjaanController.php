<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PekerjaanController extends Controller
{
    public function index()
    {
        $pekerjaan = DB::select('CALL viewAll_pekerjaan()');

        return view('admin.PengaturanDanKonfigurasi.Pekerjaan.index', compact('pekerjaan'));
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.Pekerjaan.create');
    }

    public function store(Request $request)
    {
        $pekerjaan = json_encode([
            'NamaPekerjaan' => $request->get('namaPekerjaan'),
            'Keterangan' => $request->get('keterangan')
        ]);

        $response = DB::statement('CALL insert_pekerjaan(:dataPekerjaan)', ['dataPekerjaan' => $pekerjaan]);

        if ($response) {
            return redirect()->route('Pekerjaan.index')->with('success', 'Pekerjaan Berhasil Ditambahkan!');
        } else {
            return redirect()->route('Pekerjaan.create')->with('error', 'Pekerjaan Gagal Disimpan!');
        }
    }

    public function edit($id)
    {
        $pekerjaanData = DB::select('CALL view_pekerjaanById(' . $id . ')');
        $pekerjaan = $pekerjaanData[0];

        if ($pekerjaan) {
            return view('admin.PengaturanDanKonfigurasi.Pekerjaan.edit', ['pekerjaan' => $pekerjaan]);
        } else {
            return redirect()->route('Pekerjaan.index')->with('error', 'Pekerjaan Tidak Ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        $pekerjaan = json_encode([
            'IdPekerjaan' => $id,
            'NamaPekerjaan' => $request->get('namaPekerjaan'),
            'Keterangan' => $request->get('keterangan')
        ]);

        //dd($pekerjaan);

        $pekerjaanData = DB::select('CALL view_pekerjaanById(' . $id . ')');
        $pekerjaanTemp = $pekerjaanData[0];

        if ($pekerjaanTemp) {
            $response = DB::statement('CALL update_pekerjaan(:dataPekerjaan)', ['dataPekerjaan' => $pekerjaan]);

            if ($response) {
                return redirect()->route('Pekerjaan.index')->with('success', 'Pekerjaan Berhasil Diubah!');
            } else {
                return redirect()->route('Pekerjaan.edit', $id)->with('error', 'Pekerjaan Gagal Diubah!');
            }
        } else {
            return redirect()->route('Pekerjaan.index')->with('error', 'Data Pekerjaan Tidak Ditemukan!');
        }
    }

    public function delete(Request $request)
    {
        $pekerjaanData = DB::select('CALL view_pekerjaanById(' . $request->get('idPekerjaan') . ')');
        $pekerjaan = $pekerjaanData[0];

        if ($pekerjaan) {
            $id = $request->get('idPekerjaan');

            $response = DB::select('CALL delete_pekerjaan(?)', [$id]);

            return response()->json([
                'status' => 200,
                'message' => 'Pekerjaan Berhasil Dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Pekerjaan Tidak Ditemukan.'
            ]);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $pekerjaanData = DB::select('CALL view_pekerjaanById(' . $id . ')');
        $pekerjaan = $pekerjaanData[0];

        if ($pekerjaan) {
            return response()->json([
                'status' => 200,
                'pekerjaan' => $pekerjaan
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Pekerjaan Tidak Ditemukan.'
            ]);
        }
    }
}
