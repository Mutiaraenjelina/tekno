<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModulePelangganController extends Controller
{
    private function isSuperAdmin(): bool
    {
        return Auth::check() && (string) Auth::user()->roleId === '1';
    }

    private function pelangganScope()
    {
        $query = DB::table('pelanggan');

        if (Auth::check() && (string) Auth::user()->roleId === '2') {
            $query->where('owner_user_id', Auth::id());
        }

        return $query;
    }

    public function index()
    {
        return response()->json([
            'status' => 200,
            'data' => $this->pelangganScope()->orderByDesc('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'max:30'],
        ]);

        $ownerUserId = (Auth::check() && (string) Auth::user()->roleId === '2') ? Auth::id() : null;

        $id = DB::table('pelanggan')->insertGetId([
            'nama' => $validated['nama'],
            'no_wa' => $validated['no_wa'],
            'owner_user_id' => $ownerUserId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 200, 'message' => 'Pelanggan dibuat.', 'id' => $id]);
    }

    public function show($id)
    {
        $row = $this->pelangganScope()->where('id', $id)->first();

        if (! $row) {
            return response()->json(['status' => 404, 'message' => 'Pelanggan tidak ditemukan.'], 404);
        }

        return response()->json(['status' => 200, 'data' => $row]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'max:30'],
        ]);

        $updated = $this->pelangganScope()->where('id', $id)->update([
            'nama' => $validated['nama'],
            'no_wa' => $validated['no_wa'],
            'updated_at' => now(),
        ]);

        if (! $updated) {
            return response()->json(['status' => 404, 'message' => 'Pelanggan tidak ditemukan.'], 404);
        }

        return response()->json(['status' => 200, 'message' => 'Pelanggan diubah.']);
    }

    public function destroy($id)
    {
        $deleted = $this->pelangganScope()->where('id', $id)->delete();

        if (! $deleted) {
            return response()->json(['status' => 404, 'message' => 'Pelanggan tidak ditemukan.'], 404);
        }

        return response()->json(['status' => 200, 'message' => 'Pelanggan dihapus.']);
    }
}
