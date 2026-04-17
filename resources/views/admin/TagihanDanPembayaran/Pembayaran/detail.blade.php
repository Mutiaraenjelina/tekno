@extends('layouts.admin.template')
@section('content')

<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Detail Transaksi Pembayaran</h1>
        <ol class="breadcrumb breadcrumb-example1 mb-0">
            <li class="breadcrumb-item"><a href="{{ route('Dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Pembayaran.index') }}">Pembayaran</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Transaksi</li>
        </ol>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-8">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <div class="card-title mb-0">Informasi Transaksi</div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Order ID</p>
                        <div class="fw-semibold">{{ $headPembayaran->order_id }}</div>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Tanggal Transaksi</p>
                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($headPembayaran->transaksi_created_at)->format('d M Y H:i') }}</div>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Tagihan</p>
                        <div class="fw-semibold">{{ $headPembayaran->nama_tagihan ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">User</p>
                        <div class="fw-semibold">{{ $headPembayaran->username ?? '-' }}</div>
                        <small class="text-muted">{{ $headPembayaran->email ?? '-' }}</small>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Metode</p>
                        <div class="fw-semibold">{{ strtoupper($headPembayaran->metode ?? '-') }}</div>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Status</p>
                        <span class="badge @if($headPembayaran->status === 'success') bg-success @elseif($headPembayaran->status === 'pending') bg-warning text-dark @elseif($headPembayaran->status === 'expired') bg-secondary @else bg-danger @endif">
                            {{ ucfirst($headPembayaran->status) }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Nominal</p>
                        <div class="fw-semibold">Rp {{ number_format($headPembayaran->amount, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Snap Token</p>
                        <div class="fw-semibold text-break">{{ $headPembayaran->snap_token ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <div class="card-title mb-0">Ringkasan Tagihan</div>
            </div>
            <div class="card-body">
                <p class="mb-1 text-muted">Nominal Tagihan</p>
                <div class="fw-semibold mb-3">Rp {{ number_format($headPembayaran->tagihan_nominal ?? $headPembayaran->amount, 0, ',', '.') }}</div>
                <p class="mb-1 text-muted">Tipe</p>
                <div class="fw-semibold mb-3">{{ ucfirst($headPembayaran->tipe ?? '-') }}</div>
                <p class="mb-1 text-muted">Jatuh Tempo</p>
                <div class="fw-semibold">{{ $headPembayaran->jatuh_tempo ? \Carbon\Carbon::parse($headPembayaran->jatuh_tempo)->format('d M Y') : '-' }}</div>
            </div>
        </div>

        <div class="card custom-card border-0 shadow-sm mt-3">
            <div class="card-body">
                <a href="{{ route('Pembayaran.verifikasi', $headPembayaran->id) }}" class="btn btn-primary w-100">Verifikasi Status</a>
            </div>
        </div>
    </div>
</div>

@endsection
