<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class JenisKegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = DB::select('CALL viewAll_jenisKegiatan()');

        return view('admin.PengaturanDanKonfigurasi.JenisKegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.JenisKegiatan.create');
    }

    public function store(Request $request)
    {
        $kegiatan = json_encode([
            'JenisKegiatan' => $request->get('jenisKegiatan'),
            'Keterangan' => $request->get('keterangan')
        ]);

        $response = DB::statement('CALL insert_jenisKegiatan(:dataJenisKegiatan)', ['dataJenisKegiatan' => $kegiatan]);

        if ($response) {
            return redirect()->route('JenisKegiatan.index')->with('success', 'Jenis Kegiatan Berhasil Ditambahkan!');
        } else {
            return redirect()->route('JenisKegiatan.create')->with('error', 'Jenis Kegiatan Gagal Disimpan!');
        }
    }

    public function edit($id)
    {
        $kegiatanData = DB::select('CALL view_jenisKegiatanById(' . $id . ')');
        $kegiatan = $kegiatanData[0];

        if ($kegiatan) {
            return view('admin.PengaturanDanKonfigurasi.JenisKegiatan.edit', ['kegiatan' => $kegiatan]);
        } else {
            return redirect()->route('JenisKegiatan.index')->with('error', 'Jenis Kegiatan Tidak Ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        $kegiatan = json_encode([
            'IdJenisKegiatan' => $id,
            'JenisKegiatan' => $request->get('jenisKegiatan'),
            'Keterangan' => $request->get('keterangan')
        ]);

        $kegiatanData = DB::select('CALL view_jenisKegiatanById(' . $id . ')');
        $kegiatanTemp = $kegiatanData[0];

        if ($kegiatanTemp) {
            $response = DB::statement('CALL update_jenisKegiatan(:dataJenisKegiatan)', ['dataJenisKegiatan' => $kegiatan]);

            if ($response) {
                return redirect()->route('JenisKegiatan.index')->with('success', 'Jenis Kegiatan Berhasil Diubah!');
            } else {
                return redirect()->route('JenisKegiatan.edit', $id)->with('error', 'Jenis Kegiatan Gagal Diubah!');
            }
        } else {
            return redirect()->route('JenisKegiatan.index')->with('error', 'Data Jenis Kegiatan Tidak Ditemukan!');
        }
    }

    public function delete(Request $request)
    {
        $kegiatanData = DB::select('CALL view_jenisKegiatanById(' . $request->get('idJenisKegiatan') . ')');
        $kegiatan = $kegiatanData[0];

        if ($kegiatan) {
            $id = $request->get('idJenisKegiatan');

            $response = DB::select('CALL delete_jenisKegiatan(?)', [$id]);

            return response()->json([
                'status' => 200,
                'message' => 'Jenis Kegiatan Berhasil Dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Jenis Kegiatan Tidak Ditemukan.'
            ]);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $kegiatanData = DB::select('CALL view_jenisKegiatanById(' . $id . ')');
        $kegiatan = $kegiatanData[0];

        if ($kegiatan) {
            return response()->json([
                'status' => 200,
                'kegiatan' => $kegiatan
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Jenis Kegiatan Tidak Ditemukan.'
            ]);
        }
    }
}
