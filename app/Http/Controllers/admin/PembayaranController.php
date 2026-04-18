<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    private function baseTransactionQuery()
    {
        return DB::table('transaksi as tr')
            ->leftJoin('tagihan as t', 't.id', '=', 'tr.tagihan_id')
            ->leftJoin('tagihan_user as tu', function ($join) {
                $join->on('tu.tagihan_id', '=', 'tr.tagihan_id')
                    ->on('tu.user_id', '=', 'tr.user_id');
            })
            ->leftJoin('users as u', 'u.id', '=', 'tr.user_id')
            ->leftJoin('pelanggan as p', 'p.id', '=', 'u.idPersonal')
            ->when(Auth::check() && (string) Auth::user()->roleId === '2', function ($query) {
                $query->where('p.owner_user_id', Auth::id());
            })
            ->select([
                'tr.id',
                'tr.order_id',
                'tr.status',
                'tr.amount',
                'tr.metode',
                'tr.tagihan_id',
                'tr.user_id',
                'tr.snap_token',
                'tr.payment_url',
                'tr.created_at as transaksi_created_at',
                'tr.updated_at as transaksi_updated_at',
                't.nama_tagihan',
                't.nominal as tagihan_nominal',
                't.tipe',
                't.jatuh_tempo',
                'u.username',
                'u.email',
                'p.nama as pelanggan_nama',
                'p.no_wa as pelanggan_no_wa',
                'tu.status as assignment_status',
                'tu.payment_id',
            ]);
    }

    public function index()
    {
        $pembayaranSewa = $this->baseTransactionQuery()
            ->whereIn('tr.id', function ($subQuery) {
                $subQuery->from('transaksi as trx_latest')
                    ->selectRaw('MAX(trx_latest.id)')
                    ->groupBy('trx_latest.user_id', 'trx_latest.tagihan_id');
            })
            ->orderByDesc('tr.id')
            ->get();

        return view('admin.TagihanDanPembayaran.Pembayaran.index', compact('pembayaranSewa'));
    }

    public function uploadBukti(Request $request)
    {
        return redirect()->route('Pembayaran.index')->with('error', 'Upload bukti manual tidak tersedia pada schema pembayaran aktif.');
    }

    public function storeBukti(Request $request)
    {
        return redirect()->route('Pembayaran.index')->with('error', 'Upload bukti manual belum didukung pada pembayaran modern.');
    }

    public function detail($id)
    {
        $headPembayaran = $this->baseTransactionQuery()
            ->where('tr.id', $id)
            ->first();

        if ($headPembayaran) {
            return view('admin.TagihanDanPembayaran.Pembayaran.detail', compact('headPembayaran'));
        }

        return redirect()->route('Pembayaran.index')->with('error', 'Data Pembayaran Tidak Ditemukan!');
    }


    public function verifikasi($id)
    {
        $headPembayaran = $this->baseTransactionQuery()
            ->where('tr.id', $id)
            ->first();

        if ($headPembayaran) {
            return view('admin.TagihanDanPembayaran.Pembayaran.verifikasi', compact('headPembayaran'));
        }

        return redirect()->route('Pembayaran.index')->with('error', 'Data Pembayaran Tidak Ditemukan!');
    }

    public function storeVerifikasi(Request $request)
    {
        $validated = $request->validate([
            'idPembayaran' => ['required', 'integer', 'exists:transaksi,id'],
            'status' => ['required', 'in:pending,success,failed,expired'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        DB::table('transaksi')->where('id', $validated['idPembayaran'])->update([
            'status' => $validated['status'],
            'updated_at' => now(),
        ]);

        $trx = DB::table('transaksi')->where('id', $validated['idPembayaran'])->first();

        if ($trx) {
            DB::table('tagihan_user')
                ->where('tagihan_id', $trx->tagihan_id)
                ->where('user_id', $trx->user_id)
                ->update([
                    'status' => $validated['status'] === 'success' ? 'sudah' : 'belum',
                    'payment_id' => $trx->id,
                    'updated_at' => now(),
                ]);
        }

        return redirect()->route('Pembayaran.index')->with('success', 'Status transaksi berhasil diperbarui.');

    }

    public function destroy($id)
    {
        $trx = DB::table('transaksi')->where('id', $id)->first();

        if (! $trx) {
            return redirect()->route('Pembayaran.index')->with('error', 'Data transaksi tidak ditemukan.');
        }

        DB::transaction(function () use ($trx) {
            DB::table('tagihan_user')
                ->where('tagihan_id', $trx->tagihan_id)
                ->where('user_id', $trx->user_id)
                ->update([
                    'status' => 'belum',
                    'payment_id' => null,
                    'updated_at' => now(),
                ]);

            DB::table('transaksi')->where('id', $trx->id)->delete();
        });

        return redirect()->route('Pembayaran.index')->with('success', 'Transaksi pembayaran berhasil dihapus.');
    }
}
