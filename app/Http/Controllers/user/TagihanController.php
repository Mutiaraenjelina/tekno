<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
    /**
     * Display user's tagihan list
     */
    public function index()
    {
        $userId = Auth::id();
        
        // Get all tagihan for the authenticated user
        $tagihan = DB::table('tagihan_user')
            ->join('tagihan', 'tagihan_user.tagihan_id', '=', 'tagihan.id')
            ->where('tagihan_user.user_id', $userId)
            ->select(
                'tagihan.id',
                'tagihan.nama_tagihan',
                'tagihan.nominal',
                'tagihan.jatuh_tempo',
                'tagihan.deskripsi',
                'tagihan_user.status',
                'tagihan_user.user_id'
            )
            ->orderBy('tagihan.jatuh_tempo', 'desc')
            ->get();

        return view('user.Tagihan.index', compact('tagihan'));
    }

    /**
     * Display tagihan detail
     */
    public function show($tagihanId)
    {
        $userId = Auth::id();
        
        $tagihan = DB::table('tagihan_user')
            ->join('tagihan', 'tagihan_user.tagihan_id', '=', 'tagihan.id')
            ->where('tagihan.id', $tagihanId)
            ->where('tagihan_user.user_id', $userId)
            ->select(
                'tagihan.id',
                'tagihan.nama_tagihan',
                'tagihan.nominal',
                'tagihan.jatuh_tempo',
                'tagihan.deskripsi',
                'tagihan_user.status',
                'tagihan_user.user_id'
            )
            ->first();

        if (!$tagihan) {
            return redirect()->route('user.tagihan.index')->with('error', 'Tagihan tidak ditemukan');
        }

        return view('user.Tagihan.show', compact('tagihan'));
    }
}
