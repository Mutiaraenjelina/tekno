<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ObjekRetribusiController extends Controller
{
    public function index()
    {
        $objekRetribusi = DB::select('CALL viewAll_objekRetribusi()');

        return view('admin.Master.ObjekRetribusi.index', compact('objekRetribusi'));

    }

    public function create()
    {
        $objectType = DB::select('CALL cbo_jenisObjekRetribusi()');
        $objectLocation = DB::select('CALL cbo_lokasiObjekRetribusi()');
        $province = DB::select('CALL cbo_province()');

        return view('admin.Master.ObjekRetribusi.create', compact('objectType', 'objectLocation', 'province'));
    }

    public function store(Request $request)
    {
        //dd($request->all());

        if ($request->hasFile('fileGambarDenahTanah')) {
            $uploadedFile = $request->file('fileGambarDenahTanah');
            $photo = $request->get('kodeObjekRetribusi') . "-Denah Tanah-" . time() . "." . $uploadedFile->getClientOriginalExtension();
            $photoPath = Storage::disk('biznet')->putFileAs("images/objekRetribusi", $uploadedFile, $photo);
        } else {
            $photoPath = "";
        }

        $namaFoto = $request->input('namaFoto');
        $fileFoto = $request->file('fileFoto');
        $gambarUtama = $request->input('gambarUtama');
        $keteranganFoto = $request->input('keteranganFoto');

        $detailobjekRetribusi = [];

        for ($count = 0; $count < collect($namaFoto)->count(); $count++) {
            //dd($fileFoto[$count]);
            if ($fileFoto[$count]) {
                $uploadedFileFoto = $fileFoto[$count];
                $fotoObjek = $count + 1 . "-" . $request->get('kodeObjekRetribusi') . "-" . time() . "." . $uploadedFileFoto->getClientOriginalExtension();
                $fotoObjekPath = Storage::disk('biznet')->putFileAs("images/fotoObjekRetribusi", $uploadedFileFoto, $fotoObjek);
            } else {
                $fotoObjekPath = "";
            }

            if (is_null($request->input('gambarUtama[' . $count . ']'))) {
                $isGambarUtama = 0;
            } else {
                $isGambarUtama = 1;
            }

            $detailobjekRetribusi[] = [
                'NamaFoto' => $namaFoto[$count],
                'FileFoto' => $fotoObjekPath,
                'GambarUtama' => $isGambarUtama,
                'KeteranganFoto' => $keteranganFoto[$count],
            ];
        }

        $userId = Auth::user()->id;

        $objekRetribusi = json_encode([
            'KodeObjekRetribusi' => $request->get('kodeObjekRetribusi'),
            'NoBangunan' => $request->get('nomorBangunan'),
            'NPWRD' => $request->get('npwrd'),
            'ObjekRetribusi' => $request->get('namaObjekRetribusi'),
            'IdLokasiObjekRetribusi' => $request->get('lokasiObjekRetribusi'),
            'IdJenisObjekRetribusi' => $request->get('jenisObjekRetribusi'),
            'PanjangTanah' => $request->get('panjangTanah'),
            'LebarTanah' => $request->get('lebarTanah'),
            'LuasTanah' => $request->get('luasTanah'),
            'PanjangBangunan' => $request->get('panjangBangunan'),
            'LebarBangunan' => $request->get('lebarBangunan'),
            'LuasBangunan' => $request->get('luasBangunan'),
            'Subdis_Id' => $request->get('kelurahan'),
            'Alamat' => $request->get('alamatObjekRetribusi'),
            'Latitute' => $request->get('latitude'),
            'Longitude' => $request->get('longitudu'),
            'Keterangan' => $request->get('keterangan'),
            'JumlahLantai' => $request->get('jumlahLantai'),
            'Kapasitas' => $request->get('kapasitas'),
            'BatasUtara' => $request->get('batasUtara'),
            'BatasSelatan' => $request->get('batasSelatan'),
            'BatasTimur' => $request->get('batasTimur'),
            'BatasBarat' => $request->get('batasBarat'),
            'GambarDenahTanah' => $photoPath,
            'CreatedBy' => $userId,
            'FotoObjekRetribusi' => $detailobjekRetribusi
        ]);

        $response = DB::statement('CALL insert_objekRetribusi(:dataObjekRetribusi)', ['dataObjekRetribusi' => $objekRetribusi]);

        if ($response) {
            return redirect()->route('ObjekRetribusi.index')->with('success', 'Objek Retribusi Berhasil Ditambahkan!');
        } else {
            return redirect()->route('ObjekRetribusi.create')->with('error', 'Objek Retribusi Gagal Disimpan!');
        }
    }

    public function edit($id)
    {
        $province = DB::select('CALL cbo_province()');
        $objectType = DB::select('CALL cbo_jenisObjekRetribusi()');
        $objectLocation = DB::select('CALL cbo_lokasiObjekRetribusi()');

        $objekRetribusiData = DB::select('CALL view_objekRetribusiById(' . $id . ')');
        $objekRetribusi = $objekRetribusiData[0];

        $fotoObjekRetribusi = DB::select('CALL view_fotoObjekRetribusiById(' . $id . ')');
        //$fotoObjekRetribusi = $fotoObjekRetribusiData[0];

        $kota = DB::select('CALL cbo_cities(' . $objekRetribusi->prov_id . ')');
        $kecamatan = DB::select('CALL cbo_districts(' . $objekRetribusi->city_id . ')');
        $kelurahan = DB::select('CALL cbo_subdistricts(' . $objekRetribusi->dis_id . ')');

        return view('admin.Master.ObjekRetribusi.edit', compact('objectType', 'objectLocation', 'province', 'objekRetribusi', 'kota', 'kecamatan', 'kelurahan', 'fotoObjekRetribusi'));
    }


    public function update(Request $request)
    {
        //dd($request->all());
        $dataObjekRetribusi = json_encode([
            'IdObjekRetribusi' => $request->get('idObjekRetribusi'),
            'KodeObjekRetribusi' => $request->get('kodeObjekRetribusi'),
            'NoBangunan' => $request->get('nomorBangunan'),
            'NPWRD' => $request->get('npwrd'),
            'ObjekRetribusi' => $request->get('namaObjekRetribusi'),
            'IdLokasiObjekRetribusi' => $request->get('lokasiObjekRetribusi'),
            'IdJenisObjekRetribusi' => $request->get('jenisObjekRetribusi'),
            'PanjangTanah' => $request->get('panjangTanah'),
            'LebarTanah' => $request->get('lebarTanah'),
            'LuasTanah' => $request->get('luasTanah'),
            'PanjangBangunan' => $request->get('panjangBangunan'),
            'LebarBangunan' => $request->get('lebarBangunan'),
            'LuasBangunan' => $request->get('luasBangunan'),
            'Subdis_Id' => $request->get('kelurahan'),
            'Alamat' => $request->get('alamatObjekRetribusi'),
            'Latitute' => $request->get('latitude'),
            'Longitude' => $request->get('longitudu'),
            'Keterangan' => $request->get('keterangan'),
            'JumlahLantai' => $request->get('jumlahLantai'),
            'Kapasitas' => $request->get('kapasitas'),
            'BatasUtara' => $request->get('batasUtara'),
            'BatasSelatan' => $request->get('batasSelatan'),
            'BatasTimur' => $request->get('batasTimur'),
            'BatasBarat' => $request->get('batasBarat'),
        ]);

        //dd($dataObjekRetribusi);

        $objekRetribusiData = DB::select('CALL view_objekRetribusiById(' . $request->get('idObjekRetribusi') . ')');
        $objekRetribusiTemp = $objekRetribusiData[0];

        if ($objekRetribusiTemp) {
            $response = DB::statement('CALL update_objekRetribusi(:dataObjekRetribusi)', ['dataObjekRetribusi' => $dataObjekRetribusi]);

            if ($response) {
                return redirect()->route('ObjekRetribusi.index')->with('success', 'Objek Retribusi Berhasil Diubah!');
            } else {
                return redirect()->route('ObjekRetribusi.edit', $objekRetribusiTemp->idObjekRetribusi)->with('error', 'Objek Retribusi Gagal Diubah!');
            }

        } else {
            return redirect()->route('ObjekRetribusi.index')->with('error', 'Objek Retribusi Tidak Ditemukan!');
        }
    }

    public function delete(Request $request)
    {
        $objekRetribusiData = DB::select('CALL view_objekRetribusiById(' . $request->get('idObjekRetribusi') . ')');
        $objekRetribusiTemp = $objekRetribusiData[0];

        if ($objekRetribusiTemp) {
            $id = $request->get('idObjekRetribusi');

            $response = DB::statement('CALL delete_objekRetribusi(?)', [$id]);

            return response()->json([
                'status' => 200,
                'message' => 'Objek Retribusi Berhasil Dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Objek Retribusi Tidak Ditemukan.'
            ]);
        }
    }

    public function detail($id)
    {
        $objekRetribusiData = DB::select('CALL view_objekRetribusiById(' . $id . ')');
        $objekRetribusi = $objekRetribusiData[0];

        $fotoObjek = DB::select('CALL view_photoObjekRetribusiById(' . $id . ')');

        //dd($fieldEducation);

        return view('admin.Master.ObjekRetribusi.detail', compact('objekRetribusi', 'fotoObjek'));
    }

    public function updateDenahTanah(Request $request)
    {
        $objekRetribusiData = DB::select('CALL view_objekRetribusiById(' . $request->get('idFileDenah') . ')');
        $objekRetribusi = $objekRetribusiData[0];

        //dd($objekRetribusi);

        $file = Storage::disk('biznet')->get($objekRetribusi->gambarDenahTanah);

        //dd($file);

        if ($file) {
            Storage::disk('biznet')->delete($objekRetribusi->gambarDenahTanah);

            if ($request->hasFile('fileDenahTanah')) {
                $uploadedFile = $request->file('fileDenahTanah');
                $photo = $objekRetribusi->kodeObjekRetribusi . "-Denah Tanah-" . time() . "." . $uploadedFile->getClientOriginalExtension();
                $photoPath = Storage::disk('biznet')->putFileAs("images/objekRetribusi", $uploadedFile, $photo);
            } else {
                $photoPath = "";
            }

            $dataDenahTanah = json_encode([
                'IdObjekReribusi' => $request->get('idFileDenah'),
                'FileDenahTanah' => $photoPath
            ]);


            if ($objekRetribusi) {
                $response = DB::statement('CALL update_fileDenahTanah(:dataDenahTanah)', ['dataDenahTanah' => $dataDenahTanah]);

                if ($response) {
                    return redirect()->route('ObjekRetribusi.edit', $objekRetribusi->idObjekRetribusi)->with('success', 'File/Gambar Denah Tanah Berhasil Diubah!');
                } else {
                    return redirect()->route('ObjekRetribusi.edit', $objekRetribusi->idObjekRetribusi)->with('error', 'File/Gambar Denah Tanah Gagal Diubah!');
                }

            }
        } else {
            //return redirect()->route('ObjekRetribusi.edit', $objekRetribusi->idObjekRetribusi)->with('error', 'File/Gambar Denah Tanah Tidak Ditemukan!');

            if ($request->hasFile('fileDenahTanah')) {
                $uploadedFile = $request->file('fileDenahTanah');
                $photo = $objekRetribusi->kodeObjekRetribusi . "-Denah Tanah-" . time() . "." . $uploadedFile->getClientOriginalExtension();
                $photoPath = Storage::disk('biznet')->putFileAs("images/objekRetribusi", $uploadedFile, $photo);
            } else {
                $photoPath = "";
            }

            $dataDenahTanah = json_encode([
                'IdObjekReribusi' => $request->get('idFileDenah'),
                'FileDenahTanah' => $photoPath
            ]);


            if ($objekRetribusi) {
                $response = DB::statement('CALL update_fileDenahTanah(:dataDenahTanah)', ['dataDenahTanah' => $dataDenahTanah]);

                if ($response) {
                    return redirect()->route('ObjekRetribusi.edit', $objekRetribusi->idObjekRetribusi)->with('success', 'File/Gambar Denah Tanah Berhasil Diubah!');
                } else {
                    return redirect()->route('ObjekRetribusi.edit', $objekRetribusi->idObjekRetribusi)->with('error', 'File/Gambar Denah Tanah Gagal Diubah!');
                }

            }
        }
    }

    public function editFotoObjek(Request $request)
    {
        $fotoObjekRetribusiData = DB::select('CALL view_fotoObjekRetribusiByPhotoId(:id)', ['id' => $request->id]);
        $fotoObjekRetribusi = $fotoObjekRetribusiData[0];

        if ($fotoObjekRetribusi) {
            return response()->json([
                'status' => 200,
                'fotoObjekRetribusi' => $fotoObjekRetribusi
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Foto Objek Retribusi Tidak Ditemukan.'
            ]);
        }
    }

    public function updateFotoObjek(Request $request)
    {
        $fotoObjekRetribusiData = DB::select('CALL view_fotoObjekRetribusiByPhotoId(:id)', ['id' => $request->idFotoObjek]);
        $fotoObjekRetribusi = $fotoObjekRetribusiData[0];

        $strAwalFoto = substr($fotoObjekRetribusi->fileName, 0, strpos($fotoObjekRetribusi->fileName, '-'));
        $file = Storage::disk('biznet')->get($fotoObjekRetribusi->photoObjekRetribusi);

        if ($fotoObjekRetribusi) {
            if ($request->hasFile('fileFoto')) {
                if ($file) {
                    Storage::disk('biznet')->delete($fotoObjekRetribusi->photoObjekRetribusi);
                }

                $uploadedFileFoto = $request->file('fileFoto');
                $fotoObjek = $strAwalFoto . "-" . $fotoObjekRetribusi->kodeObjekRetribusi . "-" . time() . "." . $uploadedFileFoto->getClientOriginalExtension();
                $fotoObjekPath = Storage::disk('biznet')->putFileAs("images/fotoObjekRetribusi", $uploadedFileFoto, $fotoObjek);
            } else {
                $fotoObjekPath = "";
            }

            $dataFotoObjek = json_encode([
                'IdPhotoObjekRetribusi' => $request->get('idFotoObjek'),
                'NamaPhotoObjekRetribusi' => $request->get('namaFoto'),
                'Keterangan' => $request->get('keteranganFoto'),
                'FileFoto' => $fotoObjekPath,
                'IsGambarUtama' => $request->get('isGambarUtama'),
            ]);

            $response = DB::statement('CALL update_fotoObjekRetribusi(:dataFotoObjek)', ['dataFotoObjek' => $dataFotoObjek]);

            if ($response) {
                return redirect()->route('ObjekRetribusi.edit', $fotoObjekRetribusi->idObjekRetribusi)->with('success', 'Foto Objek Retribusi Berhasil Diubah!');
            } else {
                return redirect()->route('ObjekRetribusi.edit', $fotoObjekRetribusi->idObjekRetribusi)->with('error', 'Foto Objek Retribusi Gagal Diubah!');
            }

        } else {
            return redirect()->route('ObjekRetribusi.edit', $fotoObjekRetribusi->idObjekRetribusi)->with('error', 'Foto Objek Retribusi Tidak Ditemukan!');
        }
    }

    public function storeFotoObjek(Request $request){

        $objekRetribusiData = DB::select('CALL view_objekRetribusiById(' . $request->get('idObjekRetribusiAdd') . ')');
        $objekRetribusi = $objekRetribusiData[0];

        if ($request->hasFile('fileFotoAdd')) {
            $uploadedFileFoto = $request->file('fileFotoAdd');
            $photo = '00' . "-" . $objekRetribusi->kodeObjekRetribusi . "-" . time() . "." . $uploadedFileFoto->getClientOriginalExtension();
            $photoPath = Storage::disk('biznet')->putFileAs("images/fotoObjekRetribusi", $uploadedFileFoto, $photo);
        } else {
            $photoPath = "";
        }

        if(is_null($request->get('gambarUtama'))){
            $isGambarUtama = 0;
        }else{
            $isGambarUtama = 1;
        }

        $fotoObjekRetribusi = json_encode([
            'IdObjekRetribusi' => $request->get('idObjekRetribusiAdd'),
            'NamaPhotoObjekRetribusi' => $request->get('namaFotoAdd'),
            'PhotoObjekRetribusi' => $photoPath,
            'Keterangan' => $request->get('keteranganFotoAdd'),
            'IsGambarUtama' => $isGambarUtama,
        ]);

        $response = DB::statement('CALL insert_fotoObjekRetribusi(:dataPhotoObjekRetribusi)', ['dataPhotoObjekRetribusi' => $fotoObjekRetribusi]);

        if ($response) {
            return redirect()->route('ObjekRetribusi.edit', $objekRetribusi->idObjekRetribusi)->with('success', 'Foto Objek Retribusi Berhasil Ditambahkan!');
        } else {
            return redirect()->route('ObjekRetribusi.edit', $objekRetribusi->idObjekRetribusi)->with('error', 'Foto Objek Retribusi Gagal Disimpan!');
        }
    }

    public function deleteFotoObjek($id)
    {
        $fotoObjekRetribusiData = DB::select('CALL view_fotoObjekRetribusiByPhotoId(:id)', ['id' => $id]);
        $fotoObjekRetribusi = $fotoObjekRetribusiData[0];

        $file = Storage::disk('biznet')->get($fotoObjekRetribusi->photoObjekRetribusi);

        if ($fotoObjekRetribusi) {
            if ($file) {
                Storage::disk('biznet')->delete($fotoObjekRetribusi->photoObjekRetribusi);
            }

            $response = DB::statement('CALL delete_fotoObjekRetribusi(:id)', ['id' => $id]);

            if ($response) {
                return redirect()->route('ObjekRetribusi.edit', $fotoObjekRetribusi->idObjekRetribusi)->with('success', 'Foto Objek Retribusi Berhasil Dihapus!');
            } else {
                return redirect()->route('ObjekRetribusi.edit', $fotoObjekRetribusi->idObjekRetribusi)->with('error', 'Foto Objek Retribusi Gagal Dihapus!');
            }

        } else {
            return redirect()->route('ObjekRetribusi.edit', $fotoObjekRetribusi->idObjekRetribusi)->with('error', 'Foto Objek Retribusi Tidak Ditemukan!');
        }
    }

    public function tarif()
    {
        $tarifRetribusi = DB::select('CALL viewAll_tarifObjekRetribusi()');

        return view('admin.Master.ObjekRetribusi.tarifObjek', compact('tarifRetribusi'));

        //return view('admin.Master.ObjekRetribusi.index');

    }

    public function createTarif()
    {
        $objekRetribusi = DB::select('CALL cbo_objekRetribusiTarif()');
        $jangkaWaktu = DB::select('CALL cbo_jenisJangkaWaktu()');

        return view('admin.Master.ObjekRetribusi.tambahTarif', compact('objekRetribusi', 'jangkaWaktu'));
    }

    public function detailObjekToTarif(Request $request)
    {
        $id = $request->idObjek;

        $objekData = DB::select('CALL view_objekRetribusiById(' . $id . ')');
        $objekRetribusi = $objekData[0];

        if ($objekRetribusi) {
            return response()->json([
                'status' => 200,
                'objekRetribusi' => $objekRetribusi
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Objek Retribusi Tidak Ditemukan.'
            ]);
        }
    }

    public function storeTarif(Request $request)
    {   
        //dd($request->all());
        if ($request->hasFile('filePenilaian')) {
            $uploadedFile = $request->file('filePenilaian');
            $filePenilaian = $request->get('objekRetribusi') . "-Dokumen Penilaian Tarif-" . time() . "." . $uploadedFile->getClientOriginalExtension();
            $filePath = Storage::disk('biznet')->putFileAs("documents/tarifObjekRetribusi", $uploadedFile, $filePenilaian);
        } else {
            $filePath = "";
        }

        if(is_null($request->get('statusPenilaian'))){
            $isStatusPenilaian = 0;
        }else{
            $isStatusPenilaian = 1;
        }

        $tarifObjekRetribusi = json_encode([
            'IdObjekRetribusi' => $request->get('objekRetribusi'),
            'IdJenisJangkaWaktu' => $request->get('jangkaWaktu'),
            'TanggalDinilai' => date("m/d/Y", strtotime($request->get('tanggalDinilai'))),
            'IsDinilai' => $isStatusPenilaian,
            'NamaPenilai' => $request->get('namaPenilai'),
            'NominalTarif' => $request->get('tarifObjek'),
            'HargaTanah' => $request->get('hargaTanah'),
            'HargaBangunan' => $request->get('hargaBangunan'),
            'Keterangan' => $request->get('keterangan'),
            'FileHasilPenilaian' => $filePath
        ]);

        $response = DB::statement('CALL insert_tarifObjekRetribusi(:dataTarifObjekRetribusi)', ['dataTarifObjekRetribusi' => $tarifObjekRetribusi]);

        if ($response) {
            return redirect()->route('ObjekRetribusi.tarif')->with('success', 'Tarif Objek Retribusi Berhasil Ditambahkan!');
        } else {
            return redirect()->route('ObjekRetribusi.createTarif')->with('error', 'Tarif Objek Retribusi Gagal Disimpan!');
        }
    }

    public function detailTarif(Request $request)
    {
        $id = $request->idTarif;

        $tarifObjekData = DB::select('CALL view_TarifObjekRetribusiById(' . $id . ')');
        $tarifObjek = $tarifObjekData[0];

        if ($tarifObjek) {
            return response()->json([
                'status' => 200,
                'tarifObjek' => $tarifObjek
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Tarif Objek Retribusi Tidak Ditemukan.'
            ]);
        }
    }

    public function editTarif($id)
    {
        $tarifObjekData = DB::select('CALL view_TarifObjekRetribusiById(' . $id . ')');
        $tarifObjek = $tarifObjekData[0];

        $file = Storage::disk('biznet')->get($tarifObjek->fileHasilPenilaian);

        //dd($file);

        $jangkaWaktu = DB::select('CALL cbo_jenisJangkaWaktu()');

        if ($tarifObjek) {
            return view('admin.Master.ObjekRetribusi.editTarifObjek', compact('tarifObjek', 'jangkaWaktu', 'file'));
        } else {
            return redirect()->route('admin.Master.ObjekRetribusi.tarif')->with('error', 'Tarif Objek Retribusi Tidak Ditemukan!');
        }
    }

    public function updateHasilPenilaian(Request $request)
    {
        //dd($request->all());

        $tarifObjekData = DB::select('CALL view_TarifObjekRetribusiById(' . $request->get('idFilePenilaian') . ')');
        $tarifObjek = $tarifObjekData[0];

        //dd($objekRetribusi->kodeObjekRetribusi);

        $file = Storage::disk('biznet')->get($tarifObjek->fileHasilPenilaian);

        //dd($file);

        if ($file) {
            Storage::disk('biznet')->delete($tarifObjek->fileHasilPenilaian);

            if ($request->hasFile('fileHasilPenelian')) {
                $uploadedFile = $request->file('fileHasilPenelian');
                $filePenilaian = $tarifObjek->idObjekRetribusi . "-Dokumen Penilaian Tarif-" . time() . "." . $uploadedFile->getClientOriginalExtension();
                $filePath = Storage::disk('biznet')->putFileAs("documents/tarifObjekRetribusi", $uploadedFile, $filePenilaian);
            } else {
                $filePath = "";
            }

            $dataHasilPenilaian = json_encode([
                'IdTarifObjekReribusi' => $request->get('idFilePenilaian'),
                'FileHasilPenilaian' => $filePath
            ]);


            if ($tarifObjek) {
                $response = DB::statement('CALL update_fileHasilPenilaian(:dataHasilPenilaian)', ['dataHasilPenilaian' => $dataHasilPenilaian]);

                if ($response) {
                    return redirect()->route('ObjekRetribusi.editTarif', $tarifObjek->idTarifObjekRetribusi)->with('success', 'File Hasil Penilaian Berhasil Diubah!');
                } else {
                    return redirect()->route('ObjekRetribusi.editTarif', $tarifObjek->idTarifObjekRetribusi)->with('error', 'File Hasil Penilaian Gagal Diubah!');
                }

            }
        } else {
            return redirect()->route('ObjekRetribusi.editTarif', $tarifObjek->idTarifObjekRetribusi)->with('error', 'File Hasil Penilaian Tidak Ditemukan!');
        }
    }

    public function updateTarif(Request $request)
    {
        //dd($request->all());

        $tarifObjekData = DB::select('CALL view_TarifObjekRetribusiById(' . $request->get('idTarifObjekRetribusi') . ')');
        $tarifObjek = $tarifObjekData[0];

        /*if(is_null($request->get('statusPenilaian'))){
            $isStatusPenilaian = 0;
        }else{
            $isStatusPenilaian = 1;
        }*/

        if ($request->hasFile('filePenilaian')) {
            $uploadedFile = $request->file('filePenilaian');
            $filePenilaian = $tarifObjek->idObjekRetribusi . "-Dokumen Penilaian Tarif-" . time() . "." . $uploadedFile->getClientOriginalExtension();
            $filePath = Storage::disk('biznet')->putFileAs("documents/tarifObjekRetribusi", $uploadedFile, $filePenilaian);
        } else {
            $filePath = "";
        }

        $tarifObjekRetribusi = json_encode([
            'IdTarifObjekRetribusi' => $request->get('idTarifObjekRetribusi'),
            'IdObjekRetribusi' => $request->get('idObjekRetribusi'),
            'IdJangkaWaktu' => $request->get('jangkaWaktu'),
            'TanggalDinilai' => date("m/d/Y", strtotime($request->get('tanggalDinilai'))),
            //'StatusPenilaian' => $isStatusPenilaian,
            'NamaPenilai' => $request->get('namaPenilai'),
            'NominalTarif' => $request->get('tarifObjek'),
            'HargaTanah' => $request->get('hargaTanah'),
            'HargaBangunan' => $request->get('hargaBangunan'),
            'Keterangan' => $request->get('keterangan'),
            'FileHasilPenilaian' => $filePath
        ]);

        if ($tarifObjek) {
            $response = DB::statement('CALL update_TarifObjekRetribusi(:dataTarifObjek)', ['dataTarifObjek' => $tarifObjekRetribusi]);

            if ($response) {
                return redirect()->route('ObjekRetribusi.tarif')->with('success', 'Tarif Objek Retribusi Berhasil Diubah!');
            } else {
                return redirect()->route('ObjekRetribusi.tarif')->with('error', 'Tarif Objek Retribusi Gagal Diubah!');
            }

        } else {
            return redirect()->route('ObjekRetribusi.tarif')->with('error', 'Tarif Objek Retribusi Tidak Ditemukan!');
        }
        
    }

    public function deleteTarif(Request $request)
    {
        $tarifData = DB::select('CALL view_TarifObjekRetribusiById(' . $request->get('idTarif') . ')');
        $tarifTemp = $tarifData[0];

        if ($tarifTemp) {
            $id = $request->get('idTarif');

            $response = DB::statement('CALL delete_tarifObjekRetribusi(?)', [$id]);

            return response()->json([
                'status' => 200,
                'message' => 'Tarif Objek Retribusi Berhasil Dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Tarif Objek Retribusi Tidak Ditemukan.'
            ]);
        }
    }
}