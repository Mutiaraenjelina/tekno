<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class PenggunaController extends Controller
{
    private function roleNameFromId(?int $roleId): string
    {
        return match ((string) $roleId) {
            '1' => 'Super Admin',
            '2' => 'Admin',
            '3' => 'User',
            default => 'Unknown',
        };
    }

    private function roleOptions()
    {
        if (Schema::hasTable('roles')) {
            return DB::table('roles')
                ->select('id', 'roleName')
                ->where('isDeleted', 0)
                ->orderBy('id')
                ->get();
        }

        return collect([
            (object) ['id' => 1, 'roleName' => 'Super Admin'],
            (object) ['id' => 2, 'roleName' => 'Admin'],
            (object) ['id' => 3, 'roleName' => 'User'],
        ]);
    }

    private function baseUsersQuery()
    {
        return DB::table('users as u')
            ->leftJoin('pelanggan as p', 'p.id', '=', 'u.idPersonal')
            ->select(
                'u.id',
                'u.idJenisUser',
                'u.idPersonal',
                'u.roleId',
                'u.username',
                'u.password',
                'u.email',
                DB::raw('NULL as fotoUser'),
                DB::raw("COALESCE(p.nama, u.username) as namaLengkap"),
                DB::raw("CASE WHEN u.idJenisUser = 2 THEN 'Pelanggan' ELSE 'Admin' END as jenisUser"),
                DB::raw("CASE WHEN u.roleId = 1 THEN 'Super Admin' WHEN u.roleId = 2 THEN 'Admin' WHEN u.roleId = 3 THEN 'User' ELSE 'Unknown' END as roleName")
            );
    }

    private function findUserById(int $id)
    {
        return $this->baseUsersQuery()->where('u.id', $id)->first();
    }

    public function index()
    {
        $users = $this->baseUsersQuery()
            ->where('u.isDeleted', 0)
            ->orderByDesc('u.id')
            ->get();

        return view('admin.PengaturanDanKonfigurasi.Pengguna.index', compact('users'));
    }

    public function create()
    {
        $userType = collect([
            (object) ['idJenisUser' => 1, 'jenisUser' => 'Admin'],
            (object) ['idJenisUser' => 2, 'jenisUser' => 'Pelanggan'],
        ]);
        $userRole = $this->roleOptions();

        return view('admin.PengaturanDanKonfigurasi.Pengguna.create', compact('userType', 'userRole'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idJenisUser' => ['required', 'integer'],
            'idPersonal' => ['nullable', 'integer'],
            'userRole' => ['required', 'integer'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
        ]);

        DB::table('users')->insert([
            'roleId' => $validated['userRole'],
            'idJenisUser' => $validated['idJenisUser'],
            'idPersonal' => $validated['idPersonal'] ?? null,
            'username' => $validated['username'],
            'email' => $validated['email'] ?? null,
            'password' => Hash::make($validated['password']),
            'created_at' => now(),
            'updated_at' => now(),
            'isDeleted' => 0,
        ]);

        return redirect()->route('User.index')->with('success', 'User Berhasil Ditambahkan!');
    }

    public function edit($id)
    {
        $userRole = $this->roleOptions();
        $user = $this->findUserById((int) $id);

        if (! $user) {
            return redirect()->route('User.index')->with('error', 'Data User Tidak Ditemukan!');
        }

        return view('admin.PengaturanDanKonfigurasi.Pengguna.edit', compact('user', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $existingUser = DB::table('users')->where('id', $id)->where('isDeleted', 0)->first();

        if (! $existingUser) {
            return redirect()->route('User.index')->with('error', 'Data User Tidak Ditemukan!');
        }

        $validated = $request->validate([
            'idJenisUser' => ['required', 'integer'],
            'idPersonal' => ['nullable', 'integer'],
            'userRole' => ['required', 'integer'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'password' => ['nullable', 'string', 'min:6'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email,' . $id],
        ]);

        $payload = [
            'roleId' => $validated['userRole'],
            'idJenisUser' => $validated['idJenisUser'],
            'idPersonal' => $validated['idPersonal'] ?? null,
            'username' => $validated['username'],
            'email' => $validated['email'] ?? null,
            'updated_at' => now(),
        ];

        if (! empty($validated['password'])) {
            $payload['password'] = Hash::make($validated['password']);
        }

        DB::table('users')->where('id', $id)->update($payload);

        return redirect()->route('User.index')->with('success', 'User Berhasil Diubah!');
    }

    public function delete(Request $request)
    {
        $idUser = (int) $request->get('idUser');
        $userData = DB::table('users')->where('id', $idUser)->where('isDeleted', 0)->first();

        if (! $userData) {
            return response()->json([
                'status' => 404,
                'message' => 'User Role Tidak Ditemukan.'
            ]);
        }

        DB::table('users')->where('id', $idUser)->update([
            'isDeleted' => 1,
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'User Berhasil Dihapus!'
        ]);
    }

    public function detail(Request $request)
    {
        $user = $this->findUserById((int) $request->id);

        if (! $user) {
            return response()->json([
                'status' => 404,
                'message' => 'Data user Tidak Ditemukan.'
            ]);
        }

        return response()->json([
            'status' => 200,
            'user' => $user
        ]);
    }
}
