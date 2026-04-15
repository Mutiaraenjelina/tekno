<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ModuleDashboardController extends Controller
{
    public function index()
    {
        $totalTagihan = DB::table('tagihan')->count();
        $totalBayar = DB::table('tagihan_user')->where('status', 'sudah')->count();
        $totalBelumBayar = DB::table('tagihan_user')->where('status', 'belum')->count();

        return response()->json([
            'status' => 200,
            'data' => [
                'total_tagihan' => $totalTagihan,
                'total_bayar' => $totalBayar,
                'total_belum_bayar' => $totalBelumBayar,
            ],
        ]);
    }
}
