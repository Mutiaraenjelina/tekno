@extends('layouts.admin.template')
@section('content')

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Daftar Tagihan Saya</h1>
        <p class="text-muted mb-0">Kelola dan bayar tagihan Anda dengan mudah</p>
        <nav>
            <ol class="breadcrumb breadcrumb-example1 mb-0 mt-2">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tagihan Saya</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start::row-1 -->
<div class="row">
    <div class="col-xl-12">
        @if($tagihan->count() > 0)
            <div class="card custom-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Tagihan</th>
                                    <th>Nominal</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tagihan as $index => $item)
                                    <tr class="align-middle">
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $item->nama_tagihan }}</strong>
                                            </div>
                                            <small class="text-muted">ID: #{{ $item->id }}</small>
                                        </td>
                                        <td>
                                            <strong>Rp. {{ number_format($item->nominal, 0, ',', '.') }}</strong>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d M Y') }}</td>
                                        <td>
                                            @if($item->status === 'sudah')
                                                <span class="badge bg-success">
                                                    <i class="ti ti-check me-1"></i>Sudah Bayar
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="ti ti-alert-circle me-1"></i>Belum Bayar
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('user.tagihan.show', $item->id) }}" class="btn btn-outline-info" title="Lihat Detail">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                @if($item->status !== 'sudah')
                                                    <a href="{{ route('PaymentPage.show', [$item->id, $item->user_id]) }}" class="btn btn-primary" title="Bayar">
                                                        <i class="ti ti-credit-card me-1"></i>Bayar
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="card custom-card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="text-success opacity-50" viewBox="0 0 16 16">
                            <path d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 1 1-1.06-1.06L12.72 4.22a.75.75 0 0 1 1.06 0Z"/>
                            <path d="M2.06 4.22a.75.75 0 0 1 1.06 0L9 10.19l3.47-3.47a.75.75 0 1 1 1.06 1.06l-4 4a.75.75 0 0 1-1.06 0l-6-6a.75.75 0 0 1 0-1.06Z"/>
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-2">Tidak Ada Tagihan</h5>
                    <p class="text-muted mb-0">Anda tidak memiliki tagihan saat ini. Semua baik-baik saja! 🎉</p>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- End::row-1 -->

@endsection
