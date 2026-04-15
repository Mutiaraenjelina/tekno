<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepartemenController extends Controller
{
    public function index()
    {
        // Retrieve all non-deleted Departemen records
        $departemen = DB::select('CALL viewAll_departemen()');

        return view('admin.PengaturanDanKonfigurasi.Departemen.index', compact('departemen'));
    }

    public function create()
    {
        // Display the form to create a new Departemen
        return view('admin.PengaturanDanKonfigurasi.Departemen.create');
    }

    public function store(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'NamaDepartmen' => 'required|string|max:255',
            'Keterangan' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('Departemen.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Encode input data as JSON and call the insert stored procedure
        $dataDepartemen = json_encode([
            'NamaDepartmen' => $request->get('NamaDepartmen'),
            'Keterangan' => $request->get('Keterangan'),
        ]);

        $response = DB::statement('CALL insert_departemen(:dataDepartemen)', ['dataDepartemen' => $dataDepartemen]);

        if ($response) {
            return redirect()->route('Departemen.index')->with('success', 'Badan/Dinas Berhasil Ditambahkan!');
        } else {
            return redirect()->route('Departemen.create')->with('error', 'Badan/Dinas Gagal Disimpan!');
        }
    }

    public function edit($id)
    {
        // Retrieve a single Departemen record by ID for editing
        $departemenData = DB::select('CALL view_departemenById(:id)', ['id' => $id]);
        $departemen = $departemenData[0] ?? null;

        if ($departemen) {
            return view('admin.PengaturanDanKonfigurasi.Departemen.edit', compact('departemen'));
        } else {
            return redirect()->route('Departemen.index')->with('error', 'Badan/Dinas Tidak Ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'NamaDepartmen' => 'required|string|max:255',
            'Keterangan' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('Departemen.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        // Encode input data as JSON and call the update stored procedure
        $dataDepartemen = json_encode([
            'IdDepartemen' => $id,
            'NamaDepartmen' => $request->get('NamaDepartmen'),
            'Keterangan' => $request->get('Keterangan'),
        ]);

        $departemenData = DB::select('CALL view_departemenById(:id)', ['id' => $id]);
        $departemen = $departemenData[0] ?? null;

        if ($departemen) {
            $response = DB::statement('CALL update_departemen(:dataDepartemen)', ['dataDepartemen' => $dataDepartemen]);

            if ($response) {
                return redirect()->route('Departemen.index')->with('success', 'Badan/Dinas Berhasil Diubah!');
            } else {
                return redirect()->route('Departemen.edit', $id)->with('error', 'Departemen Gagal Diubah!');
            }
        } else {
            return redirect()->route('Departemen.index')->with('error', 'Data Badan/Dinas Tidak Ditemukan!');
        }
    }

    public function delete(Request $request)
    {
        // Retrieve a single Departemen record by ID for deletion
        $departemenData = DB::select('CALL view_departemenById(:id)', ['id' => $request->get('idDepartemen')]);
        $departemen = $departemenData[0] ?? null;

        if ($departemen) {
            $response = DB::statement('CALL delete_departemen(:id)', ['id' => $request->get('idDepartemen')]);

            return response()->json([
                'status' => 200,
                'message' => 'Badan/Dinas Berhasil Dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Badan/Dinas Tidak Ditemukan.'
            ]);
        }
    }

    public function detail(Request $request)
    {
        // Retrieve details of a single Departemen record by ID
        $departemenData = DB::select('CALL view_departemenById(:id)', ['id' => $request->id]);
        $departemen = $departemenData[0] ?? null;

        if ($departemen) {
            return response()->json([
                'status' => 200,
                'departemen' => $departemen
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Badan/Dinas Tidak Ditemukan.'
            ]);
        }
    }
}
