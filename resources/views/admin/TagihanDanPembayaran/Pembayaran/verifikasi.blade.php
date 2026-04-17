@extends('layouts.admin.template')
@section('content')

<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Verifikasi Transaksi Pembayaran</h1>
        <ol class="breadcrumb breadcrumb-example1 mb-0">
            <li class="breadcrumb-item"><a href="{{ route('Dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Pembayaran.index') }}">Pembayaran</a></li>
            <li class="breadcrumb-item active" aria-current="page">Verifikasi</li>
        </ol>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-8">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <div class="card-title mb-0">Detail Transaksi</div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Order ID</p>
                        <div class="fw-semibold">{{ $headPembayaran->order_id }}</div>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Tagihan</p>
                        <div class="fw-semibold">{{ $headPembayaran->nama_tagihan ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">User</p>
                        <div class="fw-semibold">{{ $headPembayaran->username ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Nominal</p>
                        <div class="fw-semibold">Rp {{ number_format($headPembayaran->amount, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Status Saat Ini</p>
                        <span class="badge @if($headPembayaran->status === 'success') bg-success @elseif($headPembayaran->status === 'pending') bg-warning text-dark @elseif($headPembayaran->status === 'expired') bg-secondary @else bg-danger @endif">
                            {{ ucfirst($headPembayaran->status) }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Tanggal Transaksi</p>
                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($headPembayaran->transaksi_created_at)->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <div class="card-title mb-0">Ubah Status</div>
            </div>
            <div class="card-body">
                <form action="{{ route('Pembayaran.storeVerifikasi') }}" method="post">
                    @csrf
                    <input type="hidden" name="idPembayaran" value="{{ $headPembayaran->id }}">

                    <div class="mb-3">
                        <label class="form-label fw-medium">Status Baru</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $headPembayaran->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="success" {{ $headPembayaran->status === 'success' ? 'selected' : '' }}>Success</option>
                            <option value="failed" {{ $headPembayaran->status === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="expired" {{ $headPembayaran->status === 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Catatan</label>
                        <textarea name="keterangan" class="form-control" rows="4" placeholder="Opsional">{{ old('keterangan') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan Verifikasi</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
