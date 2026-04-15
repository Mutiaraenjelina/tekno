<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        // Retrieve all non-deleted Bidang records
        $users = DB::select('CALL viewAll_user()');

        return view('admin.PengaturanDanKonfigurasi.Pengguna.index', compact('users'));
    }

    public function create()
    {
        $userType = DB::select('CALL cbo_jenisUser()');
        $userRole = DB::select('CALL cbo_userRole()');

        return view('admin.PengaturanDanKonfigurasi.Pengguna.create', compact('userType', 'userRole'));
    }

    public function store(Request $request)
    {
        // Encode input data as JSON and call the insert stored procedure
        $dataUser = json_encode([
            'IdJenisUser' => $request->get('idJenisUser'),
            'IdPersonal' => $request->get('idPersonal'),
            'UserRole' => $request->get('userRole'),
            'Username' => $request->get('username'),
            'Password' => Hash::make($request->get('password')),
            'Email' => $request->get('email'),
        ]);

        $response = DB::statement('CALL insert_user(:dataUser)', ['dataUser' => $dataUser]);

        if ($response) {
            return redirect()->route('User.index')->with('success', 'User Berhasil Ditambahkan!');
        } else {
            return redirect()->route('User.create')->with('error', 'User Gagal Disimpan!');
        }
    }

    public function edit($id)
    {
        // Retrieve a single user record by ID for editing
        $userRole = DB::select('CALL cbo_userRole()');

        $userData = DB::select('CALL view_userById(:id)', ['id' => $id]);

        if ($userData) {
            $user = $userData[0];

            return view('admin.PengaturanDanKonfigurasi.Pengguna.edit', compact('user', 'userRole'));
        } else {
            return redirect()->route('User.index')->with('error', 'Data User Tidak Ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        // Encode input data as JSON and call the update stored procedure
        if(is_null($request->get('password'))){
            $dataUser = json_encode([
                'IdUser' => $id,
                'IdJenisUser' => $request->get('idJenisUser'),
                'IdPersonal' => $request->get('idPersonal'),
                'UserRole' => $request->get('userRole'),
                'Username' => $request->get('username'),
                'Email' => $request->get('email'),
            ]);
        }else{
            $dataUser = json_encode([
                'IdUser' => $id,
                'IdJenisUser' => $request->get('idJenisUser'),
                'IdPersonal' => $request->get('idPersonal'),
                'UserRole' => $request->get('userRole'),
                'Username' => $request->get('username'),
                'Password' => Hash::make($request->get('password')),
                'Email' => $request->get('email'),
            ]);
        }

        //dd( $dataUser);

        $userData = DB::select('CALL view_userById(:id)', ['id' => $id]);

        if ($userData) {            
            $response = DB::statement('CALL update_user(:dataUser)', ['dataUser' => $dataUser]);

            if ($response) {
                return redirect()->route('User.index')->with('success', 'User Berhasil Diubah!');
            } else {
                return redirect()->route('User.edit', $id)->with('error', 'User Gagal Diubah!');
            }
        } else {
            return redirect()->route('User.index')->with('error', 'Data User Tidak Ditemukan!');
        }
    }

    public function delete(Request $request)
    {
        // Retrieve a single user record by ID for deletion
        $userData = DB::select('CALL view_userById(:id)', ['id' => $request->get('idUser')]);

        if ($userData) {

            $response = DB::statement('CALL delete_user(:id)', ['id' => $request->get('idUser')]);

            return response()->json([
                'status' => 200,
                'message' => 'User Berhasil Dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'User Role Tidak Ditemukan.'
            ]);
        }
    }

    public function detail(Request $request)
    {
        // Retrieve details of a single user record by ID
        $userData = DB::select('CALL view_userById(:id)', ['id' => $request->id]);
        
        if ($userData) {
            $user = $userData[0];

            return response()->json([
                'status' => 200,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data user Tidak Ditemukan.'
            ]);
        }
    }
}
