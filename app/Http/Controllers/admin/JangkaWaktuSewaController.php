<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class JangkaWaktuSewaController extends Controller
{
    protected $rules = array(
        'jenisStatus'=> 'required',
        'namaStatus'=> 'required'
    );

    protected $messages = array(
        'jenisStatus.required' => 'Jenis Status tidak boleh kosong.',
        'namaStatus.required' => 'Status tidak boleh kosong.'
    );
    
    public function index()
    {
        $jangkaWaktuSewa = DB::select('CALL viewAll_jangkaWaktuSewa()');  

        return view('admin.PengaturanDanKonfigurasi.JangkaWaktuSewa.index', compact('jangkaWaktuSewa'));

        //return view('admin.PengaturanDanKonfigurasi.JenisStatus.index');
        
    }

    public function create()
    {
        $jangkaWaktuTypeCombo = DB::select('CALL cbo_jenisJangkaWaktu()');  

        return view('admin.PengaturanDanKonfigurasi.JangkaWaktuSewa.create', compact('jangkaWaktuTypeCombo'));

        //return view('admin.PengaturanDanKonfigurasi.Status.create');
    }

    public function store(Request $request)
    {
            // Data yang akan dikirim ke stored procedure
        $dataJangkaWaktuSewa = json_encode([
            'JenisJangkaWaktu' => $request->get('jenisJangkaWaktu'),
            'JangkaWaktu' => $request->get('jangkaWaktu'),
            'Keterangan' => $request->get('keterangan')
        ]);

        // Memanggil stored procedure untuk insert
        $response = DB::statement('CALL insert_jangkaWaktuSewa(?)', [$dataJangkaWaktuSewa]);

        if ($response) {
            return redirect()->route('JangkaWaktuSewa.index')->with('success', 'Jangka Waktu Sewa Berhasil Ditambahkan!');
        } else {
            return redirect()->route('JangkaWaktuSewa.create')->with('error', 'Jangka Waktu Sewa Gagal Disimpan!');
        }

    }

    public function edit($id)
    {      
        $jangkaWaktuTypeCombo = DB::select('CALL cbo_jenisJangkaWaktu()');

        $JangkaWaktuSewaData = DB::select('CALL view_jangkaWaktuSewaById(' . $id . ')');
        $JangkaWaktuSewa = $JangkaWaktuSewaData[0];

        if ($JangkaWaktuSewa) {
            return view('admin.PengaturanDanKonfigurasi.JangkaWaktuSewa.edit', ['jangkaWaktuTypeCombo' => $jangkaWaktuTypeCombo], ['JangkaWaktuSewa' => $JangkaWaktuSewa]);
         } else {
             return redirect()->route('JangkaWaktuSewa.index')->with('error', 'Jangka Waktu Sewa Tidak Ditemukan!');
         }

         //return view('admin.PengaturanDanKonfigurasi.Status.edit');
    }

    public function update(Request $request, $id)
    {
        $jangkawaktusewa = json_encode([
            'IdJenisStatus' => $id,
            'IdJenisJangkaWaktu' => $request -> get('jenisJangkaWaktu'),
            'JangkaWaktu' => $request->get('jangkaWaktu'),
            'Keterangan'  => $request->get('keterangan')
        ]);

        //dd($Status);

            $jangkawaktusewaData = DB::select('CALL view_jangkaWaktuSewaById(' . $id . ')');
            $jangkawaktusewaTemp = $jangkawaktusewaData[0];
            
        if ($jangkawaktusewaTemp) {
            $response = DB::statement('CALL update_jangkaWaktuSewa(:dataJangkaWaktuSewa)', ['dataJangkaWaktuSewa' => $jangkawaktusewa]);

            if ($response) {
                return redirect()->route('JangkaWaktuSewa.index')->with('success', 'Jangka Waktu sewa Berhasil Diubah!');
            } else {
                return redirect()->route('JangkaWaktuSewa.edit', $id)->with('error', 'Jangka Waktu Sewa Gagal Diubah!');
            }

         } else {
             return redirect()->route('JangkaWaktuSewa.index')->with('error', 'jangka Waktu Sewa Tidak Ditemukan!');
         }     
    }

    public function delete(Request $request)
    {
        $jangkawaktusewaData = DB::select('CALL view_jangkaWaktuSewaById(' . $request -> get('idJangkaWaktuSewa') . ')');
        $jangkawaktusewaTemp = $jangkawaktusewaData[0];

            if ($jangkawaktusewaTemp) {
                $id = $request -> get('idJangkaWaktuSewa');

                $response = DB::statement('CALL delete_jangkaWaktuSewa(?)', [$id]);
                
                return response()->json([
                    'status' => 200,
                    'message'=> 'Jangka Waktu Berhasil Dihapus!'
                ]);
            }else{
                return response()->json([
                    'status'=> 404,
                    'message' => 'Data Jangka Waktu Sewa Tidak Ditemukan.'
                ]);
            }
    }

    public function detail(Request $request)
    {      
        $id = $request->id;

        $jangkawaktusewaData = DB::select('CALL view_jangkaWaktuSewaById('  . $id . ')');
        $jangkawaktusewa = $jangkawaktusewaData[0];

        //dd($fieldEducation);

        if ($jangkawaktusewa) {
            return response()->json([
                'status'=> 200,
                'status' => $jangkawaktusewa
            ]);
        }else{
            return response()->json([
                'status'=> 404,
                'message' => 'Data Jangka Waktu Sewa Tidak Ditemukan.'
            ]);
        }
    }

    
}