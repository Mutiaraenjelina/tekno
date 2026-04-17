@extends('layouts.admin.template')
@section('content')

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Dashboard</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Summary Cards Row -->
<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-2 fs-13 fw-medium text-muted">Total Tagihan</p>
                        <h3 class="mb-0 fw-semibold text-primary fs-28">{{ $stats->tagihanTotal ?? 0 }}</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background: rgba(35, 144, 190, 0.1);">
                        <i class="ti ti-receipt fs-24" style="color: #2390be;"></i>
                    </div>
                </div>
                <p class="text-muted text-end mb-0 fs-12 mt-2">Bulan Ini</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-2 fs-13 fw-medium text-muted">Sudah Dibayar</p>
                        <h3 class="mb-0 fw-semibold text-success fs-28">{{ $stats->totalBayar ?? 0 }}</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background: rgba(40, 167, 69, 0.1);">
                        <i class="ti ti-check-circle fs-24" style="color: #28a745;"></i>
                    </div>
                </div>
                <p class="text-muted text-end mb-0 fs-12 mt-2">Bulan Ini</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-2 fs-13 fw-medium text-muted">Belum Dibayar</p>
                        <h3 class="mb-0 fw-semibold text-danger fs-28">{{ $stats->totalBelumBayar ?? 0 }}</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background: rgba(220, 53, 69, 0.1);">
                        <i class="ti ti-alert-circle fs-24" style="color: #dc3545;"></i>
                    </div>
                </div>
                <p class="text-muted text-end mb-0 fs-12 mt-2">Bulan Ini</p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-2 fs-13 fw-medium text-muted">Total Pemasukan</p>
                        <h3 class="mb-0 fw-semibold text-warning fs-20">Rp {{ number_format($stats->totalNominal ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background: rgba(255, 193, 7, 0.1);">
                        <i class="ti ti-wallet fs-24" style="color: #ffc107;"></i>
                    </div>
                </div>
                <p class="text-muted text-end mb-0 fs-12 mt-2">Bulan Ini</p>
            </div>
        </div>
    </div>
</div>
<!-- End::row-1 -->

<!-- Charts and Tables Row -->
<div class="row mt-4">
    <div class="col-xl-6">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0"><i class="ti ti-chart-pie me-2"></i>Ringkasan Pembayaran</h5>
            </div>
            <div class="card-body">
                <div style="max-height: 300px; position: relative;">
                    <canvas id="paymentChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0"><i class="ti ti-building-skyscraper me-2"></i>Tagihan Terbaru</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <tbody>
                            @forelse ($recentTagihan ?? [] as $item)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $item->nama_tagihan }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($item->tagihan_created_at)->format('d M Y') }}</small>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-info">Rp. {{ number_format($item->nominal, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center py-4 text-muted">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div class="row mt-4">
    <div class="col-xl-12">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0"><i class="ti ti-cash me-2"></i>Transaksi Terbaru</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Penerima</th>
                                <th>Tagihan</th>
                                <th>Nominal</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentTransaksi ?? [] as $item)
                                <tr>
                                    <td class="fw-bold">{{ $item->username ?? '-' }}</td>
                                    <td>{{ $item->nama_tagihan ?? '-' }}</td>
                                    <td>Rp. {{ number_format($item->amount, 0, ',', '.') }}</td>
                                    <td>{{ ucfirst($item->metode) }}</td>
                                    <td>
                                        <span class="badge @if($item->status === 'success') bg-success @elseif($item->status === 'pending') bg-warning @else bg-danger @endif">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->transaksi_created_at)->format('d M Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('paymentChart');
        if (ctx) {
            const chartLabels = @json($paymentChart['labels'] ?? ['Belum Ada Pembayaran']);
            const chartData = @json($paymentChart['data'] ?? [1]);
            const chartColors = @json($paymentChart['colors'] ?? ['#e9ecef']);

            var chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        data: chartData,
                        backgroundColor: chartColors,
                        borderColor: chartColors.map(() => '#fff'),
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    });
</script>

@endsection
