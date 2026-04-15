@extends('layouts.admin.template')
@section('content')

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Dashboard Saya</h1>
        <p class="text-muted mb-0">Selamat datang kembali, {{ Auth::user()->username }}!</p>
        <nav>
            <ol class="breadcrumb breadcrumb-example1 mb-0 mt-2">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('user.tagihan.index') }}" class="btn btn-primary">
            <i class="ti ti-list me-2"></i>Lihat Semua Tagihan
        </a>
    </div>
</div>
<!-- Page Header Close -->

<!-- Alert Section -->
<div class="row mb-4">
    <div class="col-xl-12">
        <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle me-2 flex-shrink-0 mt-1" viewBox="0 0 16 16">
                    <path d="m8.93.456 2.357 1.36a2 2 0 0 1 1.183 2.357l-.852 2.481c.05.163.083.33.083.5 0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3c.17 0 .337.033.5.083l2.481-.852a2 2 0 0 1 2.357 1.184l1.36 2.357a2 2 0 0 1-.437 2.36l-1.761 1.761a2 2 0 0 1-2.36.437l-2.357-1.36a2 2 0 0 1-1.183-2.357l.852-2.481A3.007 3.007 0 0 0 8 3.5c-.17 0-.337.033-.5.083l-2.481.852a2 2 0 0 1-2.357-1.184L1.303 2.21a2 2 0 0 1 .437-2.36l1.761-1.761a2 2 0 0 1 2.36-.437l2.357 1.36z"/>
                </svg>
                <div>
                    <strong>Informasi Penting!</strong> Pastikan Anda menyelesaikan semua pembayaran tagihan tepat waktu untuk menghindari denda keterlambatan.
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Start::row-1 - Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fw-medium">Total Tagihan</p>
                        <h4 class="mb-0 fw-bold">-</h4>
                    </div>
                    <div>
                        <span class="avatar avatar-lg bg-primary svg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16">
                                <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm0 2A.5.5 0 0 1 5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-12a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3z"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fw-medium">Sudah Dibayar</p>
                        <h4 class="mb-0 fw-bold text-success">-</h4>
                    </div>
                    <div>
                        <span class="avatar avatar-lg bg-success svg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="m10.97 4.97-.02.02-3.6 3.85-1.74-1.85a.75.75 0 0 0-1.08.02.75.75 0 0 0 .02 1.08l2.5 2.5a.75.75 0 0 0 1.08-.02l4.5-4.84a.75.75 0 0 0-.02-1.08.75.75 0 0 0-1.08.02z"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-3">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 fw-medium">Belum Dibayar</p>
                        <h4 class="mb-0 fw-bold text-warning">-</h4>
                    </div>
                    <div>
                        <span class="avatar avatar-lg bg-warning svg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="m8.93-.456 2.357 1.36a2 2 0 0 1 1.183 2.357l-.852 2.481c.05.163.083.33.083.5 0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3c.17 0 .337.033.5.083l2.481-.852a2 2 0 0 1 2.357 1.184l1.36 2.357a2 2 0 0 1-.437 2.36l-1.761 1.761a2 2 0 0 1-2.36.437l-2.357-1.36a2 2 0 0 1-1.183-2.357l.852-2.481A3.007 3.007 0 0 0 8 3.5"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End::row-1 -->

<!-- Quick Actions -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <a href="{{ route('user.tagihan.index') }}" class="btn btn-outline-primary w-100">
                            <i class="ti ti-list me-2"></i>Lihat Semua Tagihan
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-secondary w-100" disabled>
                            <i class="ti ti-message me-2"></i>Hubungi Customer Service
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
