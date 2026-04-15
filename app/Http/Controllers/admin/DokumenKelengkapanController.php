<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class DokumenKelengkapanController extends Controller
{
    public function index()
    {
        $dokumenKelengkapan = DB::select('CALL viewAll_dokumenKelengkapan()');  

        return view('admin.PengaturanDanKonfigurasi.DokumenKelengkapan.index', compact('dokumenKelengkapan'));

        //return view('admin.PengaturanDanKonfigurasi.JenisStatus.index');
        
    }

    public function create()
    {
        $dokumenKelengkapanCombo = DB::select('CALL cbo_jenisDokumen()');  

        return view('admin.PengaturanDanKonfigurasi.DokumenKelengkapan.create', compact('dokumenKelengkapanCombo'));

        //return view('admin.PengaturanDanKonfigurasi.Status.create');
    }

    public function store(Request $request)
    {
            // Data yang akan dikirim ke stored procedure
        $dataDokumenKelengkapan = json_encode([
            'JenisDokumen' => $request->get('jenisDokumen'),
            'DokumenKelengkapan' => $request->get('dokumenKelengkapan'),
            'Keterangan' => $request->get('keterangan')
        ]);

        // Memanggil stored procedure untuk insert
        $response = DB::statement('CALL insert_dokumenKelengkapan(?)', [$dataDokumenKelengkapan]);

        if ($response) {
            return redirect()->route('DokumenKelengkapan.index')->with('success', 'Dokumen Kelengkapan Berhasil Ditambahkan!');
        } else {
            return redirect()->route('DokumenKelengkapan.create')->with('error', 'Dokumen Kelengkapan Gagal Disimpan!');
        }

    }

    public function edit($id)
    {      
        $dataDokumenKelengkapanCombo = DB::select('CALL cbo_jenisDokumen()');

        $dataDokumenKelengkapanData = DB::select('CALL view_dokumenKelengkapanById(' . $id . ')');
        $dataDokumenKelengkapan = $dataDokumenKelengkapanData[0];

        if ($dataDokumenKelengkapan) {
            return view('admin.PengaturanDanKonfigurasi.DokumenKelengkapan.edit', ['dataDokumenKelengkapanCombo' => $dataDokumenKelengkapanCombo], ['dataDokumenKelengkapan' => $dataDokumenKelengkapan]);
         } else {
             return redirect()->route('JangkaWaktuSewa.index')->with('error', 'Dokumen Kelengkapan Tidak Ditemukan!');
         }

         //return view('admin.PengaturanDanKonfigurasi.Status.edit');
    }

    public function update(Request $request, $id)
    {
        $dataDokumenKelengkapan = json_encode([
            'IdDokumenKelengkapan' => $id,
            'IdJenisDokumen' => $request -> get('jenisDokumen'),
            'DokumenKelengkapan' => $request->get('dokumenKelengkapan'),
            'Keterangan'  => $request->get('keterangan')
        ]);

        //dd($Status);

            $dataDokumenKelengkapanData = DB::select('CALL view_dokumenKelengkapanById(' . $id . ')');
            $dataDokumenKelengkapanTemp = $dataDokumenKelengkapanData[0];
            
        if ($dataDokumenKelengkapanTemp) {
            $response = DB::statement('CALL update_dokumenKelengkapan(:dataDokumenKelengkapan)', ['dataDokumenKelengkapan' => $dataDokumenKelengkapan]);

            if ($response) {
                return redirect()->route('DokumenKelengkapan.index')->with('success', 'Dokumen Kelengkapan Berhasil Diubah!');
            } else {
                return redirect()->route('DokumenKelengkapan.edit', $id)->with('error', 'Dokumen Kelengkapan Gagal Diubah!');
            }

         } else {
             return redirect()->route('DokumenKelengkapan.index')->with('error', 'Dokumen Kelengkapan Tidak Ditemukan!');
         }     
    }

    public function delete(Request $request)
    {
        $dataDokumenKelengkapanData = DB::select('CALL view_dokumenKelengkapanById(' . $request -> get('idDokumenKelengkapan') . ')');
        $dataDokumenKelengkapanTemp = $dataDokumenKelengkapanData[0];

            if ($dataDokumenKelengkapanTemp) {
                $id = $request -> get('idDokumenKelengkapan');

                $response = DB::statement('CALL delete_dokumenKelengkapan(?)', [$id]);
                
                return response()->json([
                    'status' => 200,
                    'message'=> 'Dokumen Kelengkapan Berhasil Dihapus!'
                ]);
            }else{
                return response()->json([
                    'status'=> 404,
                    'message' => 'Data Dokumen Kelengkapan Sewa Tidak Ditemukan.'
                ]);
            }
    }

    public function detail(Request $request)
    {      
        $id = $request->id;

        $dataDokumenKelengkapanData = DB::select('CALL view_dokumenKelengkapanById('  . $id . ')');
        $dataDokumenKelengkapan = $dataDokumenKelengkapanData[0];

        //dd($fieldEducation);

        if ($dataDokumenKelengkapan) {
            return response()->json([
                'status'=> 200,
                'dataDokumenKelengkapan' => $dataDokumenKelengkapan
            ]);
        }else{
            return response()->json([
                'status'=> 404,
                'message' => 'Data Dokumen Kelengkapan Tidak Ditemukan.'
            ]);
        }
    }

}