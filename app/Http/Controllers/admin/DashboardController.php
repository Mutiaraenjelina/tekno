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

        $stats = (object) [
            'tagihanTotal' => $tagihanTotal,
            'totalBayar' => $totalBayar,
            'totalBelumBayar' => $totalBelumBayar,
        ];

        return view('admin.Dashboard.index', compact('stats'));
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
