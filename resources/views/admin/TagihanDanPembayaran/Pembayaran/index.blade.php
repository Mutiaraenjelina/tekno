@extends('layouts.admin.template')
@section('content')

<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Pembayaran</h1>
        <div>
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('Dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Pembayaran</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row mb-3 g-3">
    <div class="col-md-4">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Total Transaksi</p>
                <h3 class="mb-0">{{ count($pembayaranSewa ?? []) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Pending</p>
                <h3 class="mb-0 text-warning">{{ collect($pembayaranSewa ?? [])->where('status', 'pending')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Sukses</p>
                <h3 class="mb-0 text-success">{{ collect($pembayaranSewa ?? [])->where('status', 'success')->count() }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header justify-content-between bg-light border-0">
                <div class="card-title mb-0">Daftar Transaksi Pembayaran</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="responsiveDataTable" class="table table-bordered table-hover text-nowrap w-100 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Order ID</th>
                                <th>Tagihan</th>
                                <th>Nama User</th>
                                <th>Metode</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 10px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pembayaranSewa ?? [] as $pS)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($pS->transaksi_created_at)->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $pS->order_id }}</div>
                                        <small class="text-muted">ID #{{ $pS->id }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $pS->nama_tagihan ?? '-' }}</div>
                                        <small class="text-muted">Jatuh tempo: {{ $pS->jatuh_tempo ? \Carbon\Carbon::parse($pS->jatuh_tempo)->format('d M Y') : '-' }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $pS->username ?? '-' }}</div>
                                        <small class="text-muted">{{ $pS->email ?? '-' }}</small>
                                    </td>
                                    <td>{{ strtoupper($pS->metode ?? '-') }}</td>
                                    <td>Rp {{ number_format($pS->amount, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge @if($pS->status === 'success') bg-success @elseif($pS->status === 'pending') bg-warning text-dark @elseif($pS->status === 'expired') bg-secondary @else bg-danger @endif">
                                            {{ ucfirst($pS->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fe fe-align-justify"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('Pembayaran.detail', $pS->id) }}">
                                                        <i class="ri-eye-line me-1 align-middle d-inline-block"></i>Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('Pembayaran.verifikasi', $pS->id) }}">
                                                        <i class="ri-check-line me-1 align-middle d-inline-block"></i>Verifikasi
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('Pembayaran.destroy', $pS->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi pembayaran ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="ri-delete-bin-line me-1 align-middle d-inline-block"></i>Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">Belum ada transaksi pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
