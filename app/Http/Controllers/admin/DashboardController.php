<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $tagihanTotal = DB::table('tagihan')->count();
        $totalBayar = DB::table('tagihan_user')->where('status', 'sudah')->count();
        $totalBelumBayar = DB::table('tagihan_user')->where('status', 'belum')->count();
        $totalNominal = DB::table('tagihan')->sum('nominal') ?? 0;

        $recentTagihan = DB::table('tagihan')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get(['id', 'nama_tagihan', 'nominal', 'created_at as tagihan_created_at']);

        $recentTransaksi = DB::table('transaksi as tr')
            ->join('tagihan as t', 'tr.tagihan_id', '=', 't.id')
            ->join('users as u', 'tr.user_id', '=', 'u.id')
            ->orderByDesc('tr.created_at')
            ->limit(10)
            ->get([
                'u.username',
                't.nama_tagihan',
                'tr.amount',
                'tr.metode',
                'tr.status',
                'tr.created_at as transaksi_created_at'
            ]);

        $stats = (object) [
            'tagihanTotal' => $tagihanTotal,
            'totalBayar' => $totalBayar,
            'totalBelumBayar' => $totalBelumBayar,
            'totalNominal' => $totalNominal,
        ];

        return view('admin.Dashboard.index', compact('stats', 'recentTagihan', 'recentTransaksi'));
    }

    public function permohonanBaru()
    {
        return redirect()->route('Dashboard.index');

    }

    public function permohonanDisetujui()
    {
        return redirect()->route('Dashboard.index');

    }

    public function tagihanJatuhTempo()
    {
        $tagihanJatuhTempo = DB::table('tagihan')
            ->whereDate('jatuh_tempo', '<', now()->toDateString())
            ->get();

        return view('admin.Dashboard.tagihanJatuhTempo', compact('tagihanJatuhTempo'));

    }
}
