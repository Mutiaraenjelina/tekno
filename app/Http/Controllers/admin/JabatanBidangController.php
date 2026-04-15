<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class JabatanBidangController extends Controller
{
    public function index()
    {
        $jabatanbidang = DB::select('CALL viewAll_jabatanBidang()');

        return view('admin.PengaturanDanKonfigurasi.JabatanBidang.index', compact('jabatanbidang'));

        //return view('admin.PengaturanDanKonfigurasi.JenisStatus.index');

    }

    public function create()
    {
        $jabatanCombo = DB::select('CALL cbo_jabatan()');
        $bidangCombo = DB::select('CALL cbo_bidang()');

        return view('admin.PengaturanDanKonfigurasi.JabatanBidang.create', compact('jabatanCombo','bidangCombo'));

        //return view('admin.PengaturanDanKonfigurasi.Status.create');
    }

    public function store(Request $request)
    {
        // Data yang akan dikirim ke stored procedure
        $jabatanBidang = json_encode([
            'IdJabatan' => $request->get('jabatan'),
            'IdBidang' => $request->get('bidang'),
            'NamaJabatanBidang' => $request->get('namaJabatanBidang'),
            'Keterangan' => $request->get('keterangan')
        ]);

        // Memanggil stored procedure untuk insert
        $response = DB::statement('CALL insert_jabatanBidang(?)', [$jabatanBidang]);

        if ($response) {
            return redirect()->route('JabatanBidang.index')->with('success', 'Jabatan Bidang Berhasil Ditambahkan!');
        } else {
            return redirect()->route('JabatanBidang.create')->with('error', 'Jabatan Bidang Gagal Disimpan!');
        }

    }

    public function edit($id)
    {
        $jabatanCombo = DB::select('CALL cbo_jabatan()');
        $bidangCombo = DB::select('CALL cbo_bidang()');

        $jabatanBidangData = DB::select('CALL view_jabatanBidangById(' . $id . ')');
        $jabatanBidang = $jabatanBidangData[0];

        if ($jabatanBidang) {
            return view('admin.PengaturanDanKonfigurasi.JabatanBidang.edit', [
                'jabatanCombo' => $jabatanCombo,
                'bidangCombo' => $bidangCombo,
                'jabatanBidang' => $jabatanBidang
            ]);
        } else {
            return redirect()->route('JabatanBidang.index')->with('error', 'Jabatan Bidang Tidak Ditemukan!');
        }
    }

    public function update(Request $request, $id)
    {
        $jabatanBidang = json_encode([
            'IdJabatanBidang' => $id,
            'IdJabatan' => $request->get('jabatan'),
            'IdBidang' => $request->get('bidang'),
            'NamaJabatanBidang' => $request->get('namajabatanBidang'),
            'Keterangan' => $request->get('keterangan')
        ]);

        $jabatanBidangData = DB::select('CALL view_jabatanBidangById(?)', [$id]);
        $jabatanBidangTemp = $jabatanBidangData[0] ?? null;

        if ($jabatanBidangTemp) {
            $response = DB::statement('CALL update_jabatanBidang(?)', [$jabatanBidang]);

            if ($response) {
                return redirect()->route('JabatanBidang.index')->with('success', 'Jabatan Bidang Berhasil Diubah!');
            } else {
                return redirect()->route('JabatanBidang.edit', $id)->with('error', 'Jabatan Bidang Gagal Diubah!');
            }
        } else {
            return redirect()->route('JabatanBidang.index')->with('error', 'Jabatan Bidang Tidak Ditemukan!');
        }
    }

    public function delete(Request $request)
    {
        $jabatanBidangData = DB::select('CALL view_jabatanBidangById(' . $request -> get('idJabatanBidang') . ')');
        $jabatanBidangTemp = $jabatanBidangData[0];

            if ($jabatanBidangTemp) {
                $id = $request -> get('idJabatanBidang');

                $response = DB::statement('CALL delete_jabatanBidang(?)', [$id]);

                return response()->json([
                    'status' => 200,
                    'message'=> 'Jabatan Bidang Berhasil Dihapus!'
                ]);
            }else{
                return response()->json([
                    'status'=> 404,
                    'message' => 'Data Jabatan Bidang Sewa Tidak Ditemukan.'
                ]);
            }
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $jabatanBidangData = DB::select('CALL view_jabatanBidangById('  . $id . ')');
        $jabatanBidang = $jabatanBidangData[0];

        //dd($fieldEducation);

        if ($jabatanBidang) {
            return response()->json([
                'status'=> 200,
                'jabatanBidang' => $jabatanBidang
            ]);
        }else{
            return response()->json([
                'status'=> 404,
                'message' => 'Data Jabatan Bidang Tidak Ditemukan.'
            ]);
        }
    }

}
