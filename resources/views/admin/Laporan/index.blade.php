@extends('layouts.admin.template')
@section('content')

<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Laporan Pembayaran</h1>
        <nav>
            <ol class="breadcrumb breadcrumb-example1 mb-0">
                <li class="breadcrumb-item"><a href="{{ route('Dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Laporan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card custom-card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Total Transaksi</p>
                <h3 class="mb-0">{{ $stats['total_transaksi'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card custom-card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Sudah Bayar</p>
                <h3 class="mb-0 text-success">{{ $stats['sudah_bayar'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card custom-card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Pending</p>
                <h3 class="mb-0 text-warning">{{ $stats['pending'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card custom-card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Total Pemasukan</p>
                <h3 class="mb-0 text-primary">Rp {{ number_format($stats['total_pemasukan'], 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <div class="card-title mb-0">Filter Laporan</div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('Laporan.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Periode</label>
                        <select name="periode" class="form-select">
                            <option value="all" {{ $periode === 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="harian" {{ $periode === 'harian' ? 'selected' : '' }}>Harian</option>
                            <option value="mingguan" {{ $periode === 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                            <option value="bulanan" {{ $periode === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                            <option value="custom" {{ $periode === 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>
                    @if($isSuperAdmin ?? false)
                        <div class="col-md-3">
                            <label class="form-label fw-medium">Admin UMKM</label>
                            <select name="admin_user_id" class="form-select">
                                <option value="">Semua Admin UMKM</option>
                                @foreach(($adminOptions ?? []) as $admin)
                                    <option value="{{ $admin->id }}" {{ (string)($adminUserId ?? '') === (string)$admin->id ? 'selected' : '' }}>
                                        {{ $admin->username }}
                                        @if(!empty($admin->nama_usaha)) - {{ $admin->nama_usaha }} @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Dari</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Sampai</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">Terapkan</button>
                        <a href="{{ route('Laporan.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card custom-card border-0 shadow-sm">
    <div class="card-header bg-light border-0">
        <div class="card-title mb-0">Daftar Transaksi</div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Order ID</th>
                        @if($isSuperAdmin ?? false)
                            <th>Admin UMKM</th>
                        @endif
                        <th>Nama Penerima</th>
                        <th>Tagihan</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksi as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</td>
                            <td>{{ $item->order_id }}</td>
                            @if($isSuperAdmin ?? false)
                                <td>{{ $item->admin_umkm_username ?? '-' }}</td>
                            @endif
                            <td>{{ $item->username ?? '-' }}</td>
                            <td>{{ $item->nama_tagihan ?? '-' }}</td>
                            <td>{{ ucfirst($item->metode ?? '-') }}</td>
                            <td>
                                <span class="badge @if(in_array($item->status, ['success', 'settlement', 'capture'])) bg-success @elseif($item->status === 'pending') bg-warning text-dark @else bg-danger @endif">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ ($isSuperAdmin ?? false) ? 8 : 7 }}" class="text-center py-4 text-muted">Belum ada data transaksi pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
