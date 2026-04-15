<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    private $stat = 13;

    public function index()
    {
        $pembayaranSewa = DB::select('CALL viewAll_pembayaranSewa()');

        return view('admin.TagihanDanPembayaran.Pembayaran.index', compact('pembayaranSewa'));

    }

    public function uploadBukti(Request $request)
    {
        //dd($request->all());
        $idTagihan = $request->input('idTagihan');

        $detailTagihan = [];

        for ($count = 0; $count < collect($idTagihan)->count(); $count++) {

            $detailTagihan[] = [
                'idTagihan' => $idTagihan[$count]
            ];
        }

        $dataTagihanTemp = json_encode([
            'idPembayaran' => $request->get('idPembayaranSewa'), 
            'detailPembayaran' =>  $detailTagihan
        ]);

        $dataTagihan = json_decode($dataTagihanTemp);

        //dd($dataTagihan);
        return view('admin.TagihanDanPembayaran.Pembayaran.uploadBukti', compact('dataTagihan'));
    }

    public function storeBukti(Request $request)
    {
        //dd($request->all());

        if ($request->hasFile('fileBukti')) {
            //dd($request->file('fileSuratPerjanjian'));
            $uploadedFile = $request->file('fileBukti');
            $filePenilaian = $request->get('idPembayaranSewa') . "-" . time() . "." . $uploadedFile->getClientOriginalExtension();
            $filePath = Storage::disk('biznet')->putFileAs("images/BuktiBayar", $uploadedFile, $filePenilaian);
        }else{
            $filePath="";
        }

        $idTagihan = $request->input('idTagihan');

        $detailTagihan = [];

        for ($count = 0; $count < collect($idTagihan)->count(); $count++) {

            $detailTagihan[] = [
                'idTagihan' => $idTagihan[$count]
            ];
        }

        $dataPembayaran = json_encode([
            'IdPembayaran' => $request->get('idPembayaranSewa'), 
            'NamaBank' => $request->get('namaBank'), 
            'NamaPemilikRek' => $request->get('namaPemilikRek'), 
            'JumlahDana' => $request->get('jumlahDana'), 
            'Keterangan' => $request->get('keterangan'), 
            'FileBuktiBayar' => $filePath, 
            'DetailTagihan' =>  $detailTagihan
        ]);

        //dd($dataPembayaran);

        $response = DB::statement('CALL insert_BuktiPembayaran(:dataPembayaran)', ['dataPembayaran' => $dataPembayaran]);

        if ($response) {
            return redirect()->route('Pembayaran.index')->with('success', 'Upload Bukti Bayar Berhasil Ditambahkan!');
        } else {
            return redirect()->route('Pembayaran.index')->with('error', 'Upload Bukti Bayar Gagal Disimpan!');
        }

        //return view('admin.TagihanDanPembayaran.Pembayaran.uploadBukti');
    }

    public function detail($id)
    {
        $headPembayaranData = DB::select('CALL view_pembayaranSewaById(' . $id . ')');

        if ($headPembayaranData) {

            $headPembayaran = $headPembayaranData[0];
            //$detailPembayaran = DB::select('CALL view_detailPembayaranByIdPembayaran(' . $id . ')');

            //dd($checkoutDetail);

            return view('admin.TagihanDanPembayaran.Pembayaran.detail', compact('headPembayaran'));
        } else {
            return redirect()->route('Pembayaran.index')->with('error', 'Data Pembayaran Tidak Ditemukan!');
        }
    }


    public function verifikasi($id)
    {
        $headPembayaranData = DB::select('CALL view_detailVerifikasiPembayaran(' . $id . ')');

        if ($headPembayaranData) {

            $headPembayaran = $headPembayaranData[0];
            //$detailPembayaran = DB::select('CALL view_detailPembayaranByIdPembayaran(' . $id . ')');

            //dd($checkoutDetail);

            return view('admin.TagihanDanPembayaran.Pembayaran.verifikasi', compact('headPembayaran'));
        } else {
            return redirect()->route('Pembayaran.index')->with('error', 'Data Pembayaran Tidak Ditemukan!');
        }
    }

    public function storeVerifikasi(Request $request)
    {
        //dd($request->all());

        $dataVerifikasi= json_encode([
            'IdPembayaran' => $request->get('idPembayaran'), 
            'Keterangan' =>  $request->get('keterangan')
        ]);

        $response = DB::statement('CALL update_verifikasiPembayaran(:dataVerifikasi)', ['dataVerifikasi' => $dataVerifikasi]);

        if ($response) {
            return redirect()->route('Pembayaran.index')->with('success', 'Pembayaran Sewa Berhasil Diverifikasi!');
        } else {
            return redirect()->route('Pembayaran.index')->with('error', 'Pembayaran Sewa Gagal Diverifikasi!');
        }

    }
}