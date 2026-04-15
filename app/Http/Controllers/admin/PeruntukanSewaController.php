<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PeruntukanSewaController extends Controller
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
        $peruntukanSewa = DB::select('CALL viewAll_peruntukanSewa()'); 

        return view('admin.PengaturanDanKonfigurasi.PeruntukanSewa.index', ['peruntukanSewa' => $peruntukanSewa]);

        //return view('admin.PengaturanDanKonfigurasi.Status.index');
        
    }

    public function create()
    {
        $peruntukanSewaCombo = DB::select('CALL cbo_jenisKegiatan()');  

        return view('admin.PengaturanDanKonfigurasi.PeruntukanSewa.create', compact('peruntukanSewaCombo'));

        //return view('admin.PengaturanDanKonfigurasi.Status.create');
    }

    public function store(Request $request)
    {

        $PeruntukanSewa = json_encode([
            'JenisKegiatan' => $request->get('jenisKegiatan'),
            'PeruntukanSewa' => $request->get('peruntukanSewa'),
            'Keterangan'  => $request->get('keterangan')
        ]);
    
            $response = DB::statement('CALL insert_peruntukanSewa(:dataPeruntukanSewa)', ['dataPeruntukanSewa' => $PeruntukanSewa]);

            if ($response) {
                return redirect()->route('PeruntukanSewa.index')->with('success', 'Peruntukan Sewa Berhasil Ditambahkan!');
            } else {
                return redirect()->route('PeruntukanSewa.create')->with('error', 'Peruntukan Sewa Gagal Disimpan!');
            }
    }

    public function edit($id)
    {      
        $peruntukanSewaCombo = DB::select('CALL cbo_jenisKegiatan()');

        $peruntukanSewaData = DB::select('CALL view_peruntukanSewaById(' . $id . ')');
        $peruntukanSewa = $peruntukanSewaData[0];

        if ($peruntukanSewa) {
            return view('admin.PengaturanDanKonfigurasi.PeruntukanSewa.edit', ['peruntukanSewaCombo' => $peruntukanSewaCombo], ['peruntukanSewa' => $peruntukanSewa]);
         } else {
             return redirect()->route('PeruntukanSewa.index')->with('error', 'Peruntukan Sewa Tidak Ditemukan!');
         }

         //return view('admin.PengaturanDanKonfigurasi.Status.edit');
    }

    public function update(Request $request, $id)
    {
        $peruntukanSewa = json_encode([
            'IdPeruntukanSewa' => $id,
            'IdJenisKegiatan' => $request -> get('jenisKegiatan'),
            'PeruntukanSewa' => $request->get('peruntukanSewa'),
            'Keterangan'  => $request->get('keterangan')
        ]);

        //dd($Status);

            $peruntukanSewaData = DB::select('CALL view_peruntukanSewaById(' . $id . ')');
            $peruntukanSewaTemp = $peruntukanSewaData[0];
            
        if ($peruntukanSewaTemp) {
            $response = DB::statement('CALL update_peruntukanSewa(:dataPeruntukanSewa)', ['dataPeruntukanSewa' => $peruntukanSewa]);

            if ($response) {
                return redirect()->route('PeruntukanSewa.index')->with('success', 'Peruntukan Sewa Berhasil Diubah!');
            } else {
                return redirect()->route('PeruntukanSewa.edit', $id)->with('error', 'Peruntukan Sewa Gagal Diubah!');
            }

         } else {
             return redirect()->route('PeruntukanSewa.index')->with('error', 'Peruntukan Sewa Tidak Ditemukan!');
         }     
    }

    public function delete(Request $request)
    {
        $peruntukanSewaData = DB::select('CALL view_peruntukanSewaById(' . $request -> get('idperuntukanSewa') . ')');
        $peruntukanSewaTemp = $peruntukanSewaData[0];

            if ($peruntukanSewaTemp) {
                $id = $request -> get('idperuntukanSewa');

                $response = DB::statement('CALL delete_peruntukanSewa(?)', [$id]);
                
                return response()->json([
                    'status' => 200,
                    'message'=> 'Peruntukan Sewa Berhasil Dihapus!'
                ]);
            }else{
                return response()->json([
                    'status'=> 404,
                    'message' => 'Data Peruntukan Sewa Tidak Ditemukan.'
                ]);
            }
    }

    public function detail(Request $request)
    {      
        $id = $request->id;

        $peruntukanSewaData = DB::select('CALL view_peruntukanSewaById('  . $id . ')');
        $peruntukanSewa = $peruntukanSewaData[0];

        //dd($fieldEducation);

        if ($peruntukanSewa) {
            return response()->json([
                'status'=> 200,
                'peruntukanSewa' => $peruntukanSewa
            ]);
        }else{
            return response()->json([
                'status'=> 404,
                'message' => 'Data Peruntukan Sewa Tidak Ditemukan.'
            ]);
        }
    }
}
