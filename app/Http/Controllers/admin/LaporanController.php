<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = (string) $request->query('periode', 'all');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = DB::table('transaksi as tr')
            ->leftJoin('tagihan as t', 'tr.tagihan_id', '=', 't.id')
            ->leftJoin('users as u', 'tr.user_id', '=', 'u.id')
            ->select(
                'tr.id',
                'tr.order_id',
                'tr.amount',
                'tr.metode',
                'tr.status',
                'tr.created_at',
                't.nama_tagihan',
                'u.username'
            );

        $query->whereIn('tr.id', function ($subQuery) {
            $subQuery->from('transaksi as trx_latest')
                ->selectRaw('MAX(trx_latest.id)')
                ->groupBy('trx_latest.user_id', 'trx_latest.tagihan_id');
        });

        $query = $this->applyPeriodFilter($query, $periode, $startDate, $endDate);

        $transaksi = $query->orderByDesc('tr.created_at')->get();

        $stats = [
            'total_transaksi' => $transaksi->count(),
            'total_pemasukan' => $transaksi
                ->whereIn('status', ['success', 'settlement', 'capture'])
                ->sum('amount'),
            'sudah_bayar' => $transaksi
                ->whereIn('status', ['success', 'settlement', 'capture'])
                ->count(),
            'pending' => $transaksi
                ->where('status', 'pending')
                ->count(),
            'gagal' => $transaksi
                ->whereIn('status', ['failed', 'expired', 'deny', 'cancel'])
                ->count(),
        ];

        return view('admin.Laporan.index', compact('transaksi', 'stats', 'periode', 'startDate', 'endDate'));
    }

    private function applyPeriodFilter($query, string $periode, ?string $startDate, ?string $endDate)
    {
        return match ($periode) {
            'harian' => $query->whereDate('tr.created_at', now()->toDateString()),
            'mingguan' => $query->whereBetween('tr.created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'bulanan' => $query->whereYear('tr.created_at', now()->year)
                ->whereMonth('tr.created_at', now()->month),
            'custom' => $this->applyCustomRange($query, $startDate, $endDate),
            default => $query,
        };
    }

    private function applyCustomRange($query, ?string $startDate, ?string $endDate)
    {
        if ($startDate && $endDate) {
            return $query->whereBetween('tr.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        if ($startDate) {
            return $query->whereDate('tr.created_at', '>=', $startDate);
        }

        if ($endDate) {
            return $query->whereDate('tr.created_at', '<=', $endDate);
        }

        return $query;
    }
}
