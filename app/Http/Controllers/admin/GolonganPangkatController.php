<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GolonganPangkatController extends Controller
{
    public function index()
    {
        // Retrieve all non-deleted Bidang records
        $golonganPangkat = DB::select('CALL viewAll_golonganPangkat()');

        return view('admin.PengaturanDanKonfigurasi.GolonganPangkat.index', compact('golonganPangkat'));
    }

    public function create()
    {

        return view('admin.PengaturanDanKonfigurasi.GolonganPangkat.create');
    }

    public function store(Request $request)
    {
        // Encode input data as JSON and call the insert stored procedure
        $dataGolonganPangkat = json_encode([
            'Golongan' => $request->get('golongan'),
            'Pangkat' => $request->get('pangkat'),
            'Keterangan' => $request->get('keterangan')
        ]);

        $response = DB::statement('CALL insert_golonganPangkat(:dataGolonganPangkat)', ['dataGolonganPangkat' => $dataGolonganPangkat]);

        if ($response) {
            return redirect()->route('GolonganPangkat.index')->with('success', 'Golongan dan Pangkat Berhasil Ditambahkan!');
        } else {
            return redirect()->route('GolonganPangkat.create')->with('error', 'Golongan dan Pangkat Gagal Disimpan!');
        }
    }

    public function edit($id)
    {
        // Retrieve a single Bidang record by ID for editing
        $golonganData = DB::select('CALL view_golonganPangkatById(:id)', ['id' => $id]);
        $golonganPangkat = $golonganData[0] ?? null;

        if ($golonganPangkat) {
            return view('admin.PengaturanDanKonfigurasi.GolonganPangkat.edit', compact('golonganPangkat'));
        } else {
            return redirect()->route('GolonganPangkat.index')->with('error', 'Golongan dan Pangkat Tidak Ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        // Encode input data as JSON and call the update stored procedure
        $dataGolonganPangkat = json_encode([
            'IdGolonganPangkat' => $id,
            'Golongan' => $request->get('golongan'),
            'Pangkat' => $request->get('pangkat'),
            'Keterangan' => $request->get('keterangan')
        ]);

        $golonganData = DB::select('CALL view_golonganPangkatById(:id)', ['id' => $id]);
        $golonganPangkat = $golonganData[0] ?? null;

        if ($golonganPangkat) {
            $response = DB::statement('CALL update_golonganPangkat(:dataGolonganPangkat)', ['dataGolonganPangkat' => $dataGolonganPangkat]);

            if ($response) {
                return redirect()->route('GolonganPangkat.index')->with('success', 'Golongan dan Pangkat Berhasil Diubah!');
            } else {
                return redirect()->route('GolonganPangkat.edit', $id)->with('error', 'Golongan dan Pangkat Gagal Diubah!');
            }
        } else {
            return redirect()->route('GolonganPangkat.index')->with('error', 'Data Golongan dan Pangkat Tidak Ditemukan!');
        }
    }

    public function delete(Request $request)
    {
        // Retrieve a single Bidang record by ID for deletion
        $golonganData = DB::select('CALL view_golonganPangkatById(:id)', ['id' => $request->get('idGol')]);
        $golonganPangkat = $golonganData[0] ?? null;

        if ($golonganPangkat) {
            $response = DB::statement('CALL delete_golonganPangkat(:id)', ['id' => $request->get('idGol')]);

            return response()->json([
                'status' => 200,
                'message' => 'Golongan dan Pangkat Berhasil Dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Golongan dan Pangkat Tidak Ditemukan.'
            ]);
        }
    }

    public function detail(Request $request)
    {
        // Retrieve details of a single GolonganPangkat record by ID
        $golonganData = DB::select('CALL view_golonganPangkatById(:id)', ['id' => $request->id]);
        $golonganPangkat = $golonganData[0] ?? null;

        if ($golonganPangkat) {
            return response()->json([
                'status' => 200,
                'golonganPangkat' => $golonganPangkat
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Golongan dan Pangkat Tidak Ditemukan.'
            ]);
        }
    }

}
