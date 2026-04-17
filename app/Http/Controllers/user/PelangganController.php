<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    /**
     * Show logged-in user's pelanggan profile (if any).
     */
    public function index()
    {
        $user = Auth::user();

        $pelanggan = DB::table('pelanggan')
            ->where('id', $user->idPersonal)
            ->first();

        return view('user.Pelanggan.index', compact('user', 'pelanggan'));
    }
}
