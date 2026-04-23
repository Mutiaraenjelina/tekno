<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    private function isSuperAdmin(): bool
    {
        return Auth::check() && (string) Auth::user()->roleId === '1';
    }

    public function index(Request $request)
    {
        $periode = (string) $request->query('periode', 'all');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $adminUserId = $request->filled('admin_user_id') ? (int) $request->query('admin_user_id') : null;
        $isSuperAdmin = $this->isSuperAdmin();

        $query = DB::table('transaksi as tr')
            ->leftJoin('tagihan as t', 'tr.tagihan_id', '=', 't.id')
            ->leftJoin('users as u', 'tr.user_id', '=', 'u.id')
            ->leftJoin('pelanggan as p', 'p.id', '=', 'u.idPersonal')
            ->leftJoin('users as owner', 'owner.id', '=', 'p.owner_user_id')
            ->select(
                'tr.id',
                'tr.order_id',
                'tr.amount',
                'tr.metode',
                'tr.status',
                'tr.created_at',
                't.nama_tagihan',
                'u.username',
                'owner.id as admin_umkm_id',
                'owner.username as admin_umkm_username'
            );

        if (! $isSuperAdmin) {
            $query->where('p.owner_user_id', Auth::id())
                ->where('t.created_by', Auth::id());
        } elseif ($adminUserId) {
            $query->where('p.owner_user_id', $adminUserId)
                ->where('t.created_by', $adminUserId);
        }

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

        $adminOptions = collect();
        if ($isSuperAdmin) {
            $adminOptions = DB::table('users as u')
                ->leftJoin('pelanggan as p', 'p.id', '=', 'u.idPersonal')
                ->where('u.roleId', 2)
                ->select('u.id', 'u.username', 'p.nama as namaAdmin', 'p.nama_usaha')
                ->orderBy('u.username')
                ->get();
        }

        return view('admin.Laporan.index', compact(
            'transaksi',
            'stats',
            'periode',
            'startDate',
            'endDate',
            'isSuperAdmin',
            'adminOptions',
            'adminUserId'
        ));
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
