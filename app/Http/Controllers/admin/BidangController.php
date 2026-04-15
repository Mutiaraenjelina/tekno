<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BidangController extends Controller
{
    public function index()
    {
        // Retrieve all non-deleted Bidang records
        $bidang = DB::select('CALL viewAll_bidang()');

        return view('admin.PengaturanDanKonfigurasi.Bidang.index', ['bidang' => $bidang]);
    }

    public function create()
    {
        // Retrieve all non-deleted Departemen records for the dropdown
        $departemenCombo = DB::select('CALL cbo_departemen()');

        return view('admin.PengaturanDanKonfigurasi.Bidang.create', compact('departemenCombo'));
    }

    public function store(Request $request)
    {
        // Encode input data as JSON and call the insert stored procedure
        $dataBidang = json_encode([
            'IdDepartemen' => $request->get('idDepartemen'),
            'ParentBidang' => $request->get('parentBidang'),
            'NamaBidang' => $request->get('namaBidang'),
            'Keterangan' => $request->get('keterangan')
        ]);

        $response = DB::statement('CALL insert_bidang(:dataBidang)', ['dataBidang' => $dataBidang]);

        if ($response) {
            return redirect()->route('Bidang.index')->with('success', 'Bidang Berhasil Ditambahkan!');
        } else {
            return redirect()->route('Bidang.create')->with('error', 'Bidang Gagal Disimpan!');
        }
    }

    public function edit($id)
    {
        // Retrieve all non-deleted Departemen records for the dropdown
        $departemenCombo = DB::select('CALL cbo_departemen()');

        // Retrieve a single Bidang record by ID for editing
        $bidangData = DB::select('CALL view_bidangById(:id)', ['id' => $id]);
        $bidang = $bidangData[0] ?? null;

        if ($bidang) {
            return view('admin.PengaturanDanKonfigurasi.Bidang.edit', ['departemen' => $departemenCombo], ['bidang' => $bidang]);
        } else {
            return redirect()->route('Bidang.index')->with('error', 'Bidang Tidak Ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        // Encode input data as JSON and call the update stored procedure
        $dataBidang = json_encode([
            'IdBidang' => $id,
            'IdDepartemen' => $request->get('idDepartemen'),
            'ParentBidang' => $request->get('parentBidang'),
            'NamaBidang' => $request->get('namaBidang'),
            'Keterangan' => $request->get('keterangan')
        ]);

        $bidangData = DB::select('CALL view_bidangById(:id)', ['id' => $id]);
        $bidang = $bidangData[0] ?? null;

        if ($bidang) {
            $response = DB::statement('CALL update_bidang(:dataBidang)', ['dataBidang' => $dataBidang]);

            if ($response) {
                return redirect()->route('Bidang.index')->with('success', 'Bidang Berhasil Diubah!');
            } else {
                return redirect()->route('Bidang.edit', $id)->with('error', 'Bidang Gagal Diubah!');
            }
        } else {
            return redirect()->route('Bidang.index')->with('error', 'Data Bidang Tidak Ditemukan!');
        }
    }

    public function delete(Request $request)
    {
        // Retrieve a single Bidang record by ID for deletion
        $bidangData = DB::select('CALL view_bidangById(:id)', ['id' => $request->get('idBidang')]);
        $bidang = $bidangData[0] ?? null;

        if ($bidang) {
            $response = DB::statement('CALL delete_bidang(:id)', ['id' => $request->get('idBidang')]);

            return response()->json([
                'status' => 200,
                'message' => 'Bidang Berhasil Dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Bidang Tidak Ditemukan.'
            ]);
        }
    }

    public function detail(Request $request)
    {
        // Retrieve details of a single Bidang record by ID
        $bidangData = DB::select('CALL view_bidangById(:id)', ['id' => $request->id]);
        $bidang = $bidangData[0] ?? null;

        if ($bidang) {
            return response()->json([
                'status' => 200,
                'bidang' => $bidang
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Bidang Tidak Ditemukan.'
            ]);
        }
    }

    public function storeDepartmen(Request $request)
    {
        $departemenData = json_encode([
            'NamaDepartmen' => $request->get('namaDepartmenModal'),
            'Keterangan' => $request->get('keteranganModal')
        ]);

        $response = DB::statement('CALL insert_departemen(:dataDepartemen)', ['dataDepartemen' => $departemenData]);

        if ($response) {
            return response()->json([
                'status' => 200,
                'message' => 'Departemen Berhasil Ditambahkan.'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Departemen Gagal Ditambahkan.'
            ]);
        }
    }

}
