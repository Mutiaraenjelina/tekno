<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display user's dashboard
     */
    public function index()
    {
        $user = Auth::user();

        $assignmentCount = DB::table('tagihan_user as tu')
            ->join('tagihan as t', 't.id', '=', 'tu.tagihan_id')
            ->where('tu.user_id', $user->id)
            ->count();

        $tagihanCount = DB::table('tagihan_user')
            ->where('user_id', $user->id)
            ->distinct('tagihan_id')
            ->count('tagihan_id');

        $pelangganExists = false;
        if (!empty($user->idPersonal)) {
            $pelangganExists = DB::table('pelanggan')
                ->where('id', $user->idPersonal)
                ->exists();
        }

        $transaksiCount = DB::table('tagihan_user as tu')
            ->leftJoin('transaksi as tr', 'tr.id', '=', 'tu.payment_id')
            ->where('tu.user_id', $user->id)
            ->whereNotNull('tu.payment_id')
            ->count();

        $syncStatus = [
            'tagihan' => [
                'exists' => $tagihanCount > 0,
                'count' => $tagihanCount,
                'label' => $tagihanCount > 0 ? 'Ada data tagihan dari admin' : 'Belum ada tagihan dari admin',
            ],
            'pelanggan' => [
                'exists' => $pelangganExists,
                'count' => $pelangganExists ? 1 : 0,
                'label' => $pelangganExists ? 'Data pelanggan terhubung' : 'Data pelanggan belum terhubung',
            ],
            'assignment' => [
                'exists' => $assignmentCount > 0,
                'count' => $assignmentCount,
                'label' => $assignmentCount > 0 ? 'Ada assignment dari admin' : 'Belum ada assignment dari admin',
            ],
            'transaksi' => [
                'exists' => $transaksiCount > 0,
                'count' => $transaksiCount,
                'label' => $transaksiCount > 0 ? 'Ada bukti transaksi' : 'Belum ada bukti transaksi',
            ],
        ];

        return view('user.Dashboard.index', compact('syncStatus'));
    }
}
