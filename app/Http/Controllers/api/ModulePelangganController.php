<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModulePelangganController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 200,
            'data' => DB::table('pelanggan')->orderByDesc('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'max:30'],
        ]);

        $id = DB::table('pelanggan')->insertGetId([
            'nama' => $validated['nama'],
            'no_wa' => $validated['no_wa'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 200, 'message' => 'Pelanggan dibuat.', 'id' => $id]);
    }

    public function show($id)
    {
        $row = DB::table('pelanggan')->where('id', $id)->first();

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

        $updated = DB::table('pelanggan')->where('id', $id)->update([
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
        $deleted = DB::table('pelanggan')->where('id', $id)->delete();

        if (! $deleted) {
            return response()->json(['status' => 404, 'message' => 'Pelanggan tidak ditemukan.'], 404);
        }

        return response()->json(['status' => 200, 'message' => 'Pelanggan dihapus.']);
    }
}
