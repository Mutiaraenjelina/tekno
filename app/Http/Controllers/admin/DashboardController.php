<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private function isSuperAdmin(): bool
    {
        return Auth::check() && (string) Auth::user()->roleId === '1';
    }

    public function index()
    {
        $tagihanQuery = DB::table('tagihan');
        if (! $this->isSuperAdmin()) {
            $tagihanQuery->where('created_by', Auth::id());
        }

        $tagihanTotal = (clone $tagihanQuery)->count();
        $totalBayar = DB::table('tagihan_user as tu')
            ->join('tagihan as t', 'tu.tagihan_id', '=', 't.id')
            ->where('tu.status', 'sudah')
            ->when(! $this->isSuperAdmin(), function ($query) {
                $query->where('t.created_by', Auth::id());
            })
            ->count();
        $totalBelumBayar = DB::table('tagihan_user as tu')
            ->join('tagihan as t', 'tu.tagihan_id', '=', 't.id')
            ->where('tu.status', 'belum')
            ->when(! $this->isSuperAdmin(), function ($query) {
                $query->where('t.created_by', Auth::id());
            })
            ->count();
        $totalNominal = DB::table('tagihan_user as tu')
            ->join('tagihan as t', 'tu.tagihan_id', '=', 't.id')
            ->where('tu.status', 'sudah')
            ->when(! $this->isSuperAdmin(), function ($query) {
                $query->where('t.created_by', Auth::id());
            })
            ->sum('t.nominal') ?? 0;

        $paymentSummary = DB::table('tagihan_user')
            ->selectRaw("LOWER(COALESCE(status, 'unknown')) as status_key, COUNT(*) as total")
            ->groupBy(DB::raw("LOWER(COALESCE(status, 'unknown'))"))
            ->orderByDesc('total')
            ->get();

        $statusLabelMap = [
            'sudah' => 'Sudah Dibayar',
            'belum' => 'Belum Dibayar',
            'unknown' => 'Unknown',
        ];

        $statusColorMap = [
            'sudah' => '#28a745',
            'belum' => '#dc3545',
            'unknown' => '#adb5bd',
        ];

        $paymentChart = [
            'labels' => $paymentSummary->map(function ($item) use ($statusLabelMap) {
                return $statusLabelMap[$item->status_key] ?? ucfirst($item->status_key);
            })->values(),
            'data' => $paymentSummary->pluck('total')->map(fn ($value) => (int) $value)->values(),
            'colors' => $paymentSummary->map(function ($item) use ($statusColorMap) {
                return $statusColorMap[$item->status_key] ?? '#6c757d';
            })->values(),
        ];

        if (empty($paymentChart['labels']) || count($paymentChart['labels']) === 0) {
            $paymentChart = [
                'labels' => ['Belum Ada Pembayaran'],
                'data' => [1],
                'colors' => ['#e9ecef'],
            ];
        }

        $recentTagihan = (clone $tagihanQuery)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get(['id', 'nama_tagihan', 'nominal', 'created_at as tagihan_created_at']);

        $recentTransaksi = DB::table('transaksi as tr')
            ->join('tagihan as t', 'tr.tagihan_id', '=', 't.id')
            ->join('users as u', 'tr.user_id', '=', 'u.id')
            ->when(! $this->isSuperAdmin(), function ($query) {
                $query->where('t.created_by', Auth::id());
            })
            ->whereIn('tr.id', function ($query) {
                $query->from('transaksi as trx_latest')
                    ->selectRaw('MAX(trx_latest.id)')
                    ->groupBy('trx_latest.user_id', 'trx_latest.tagihan_id');
            })
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

        return view('admin.Dashboard.index', compact('stats', 'recentTagihan', 'recentTransaksi', 'paymentChart'));
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
