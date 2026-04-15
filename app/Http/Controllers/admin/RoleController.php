<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        // Retrieve all non-deleted Bidang records
        $role = DB::select('CALL viewAll_roles()');

        return view('admin.PengaturanDanKonfigurasi.Role.index', compact('role'));
    }

    public function create()
    {
        return view('admin.PengaturanDanKonfigurasi.Role.create');
    }

    public function store(Request $request)
    {
        // Encode input data as JSON and call the insert stored procedure
        $dataRole = json_encode([
            'NamaRole' => $request->get('namaRole'),
            'Keterangan' => $request->get('keterangan')
        ]);

        $response = DB::statement('CALL insert_role(:dataRole)', ['dataRole' => $dataRole]);

        if ($response) {
            return redirect()->route('Role.index')->with('success', 'Role Berhasil Ditambahkan!');
        } else {
            return redirect()->route('Role.create')->with('error', 'Role Gagal Disimpan!');
        }
    }

    public function edit($id)
    {
        // Retrieve a single Role record by ID for editing
        $roleData = DB::select('CALL view_roleById(:id)', ['id' => $id]);

        if ($roleData) {
            $role = $roleData[0];

            return view('admin.PengaturanDanKonfigurasi.Role.edit', compact('role'));
        } else {
            return redirect()->route('Role.index')->with('error', 'Role Tidak Ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        // Encode input data as JSON and call the update stored procedure
        $dataRole = json_encode([
            'RoleId' => $id,
            'NamaRole' => $request->get('namaRole'),
            'Keterangan' => $request->get('keterangan')
        ]);

        $roleData = DB::select('CALL view_roleById(:id)', ['id' => $id]);
        $role = $roleData[0];

        if ($roleData) {
            $role = $roleData[0];
            
            $response = DB::statement('CALL update_role(:dataRole)', ['dataRole' => $dataRole]);

            if ($response) {
                return redirect()->route('Role.index')->with('success', 'Role Berhasil Diubah!');
            } else {
                return redirect()->route('Role.edit', $id)->with('error', 'Role Gagal Diubah!');
            }
        } else {
            return redirect()->route('Role.index')->with('error', 'Data Role Tidak Ditemukan!');
        }
    }

    public function delete(Request $request)
    {
        // Retrieve a single Bidang record by ID for deletion
        $roleData = DB::select('CALL view_roleById(:id)', ['id' => $request->get('idRole')]);
        $role = $roleData[0] ?? null;

        if ($role) {
            $response = DB::statement('CALL delete_role(:id)', ['id' => $request->get('idRole')]);

            return response()->json([
                'status' => 200,
                'message' => 'Role Berhasil Dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Role Tidak Ditemukan.'
            ]);
        }
    }

    public function detail(Request $request)
    {
        // Retrieve details of a single Bidang record by ID
        $roleData = DB::select('CALL view_roleById(:id)', ['id' => $request->id]);
        $role = $roleData[0] ?? null;

        if ($role) {
            return response()->json([
                'status' => 200,
                'role' => $role
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Role Tidak Ditemukan.'
            ]);
        }
    }
}
