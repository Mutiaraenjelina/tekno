@extends('layouts.admin.template')
@section('content')

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Detail Tagihan</h1>
        <p class="text-muted mb-0">{{ $tagihan->nama_tagihan }}</p>
        <nav>
            <ol class="breadcrumb breadcrumb-example1 mb-0 mt-2">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.tagihan.index') }}">Tagihan Saya</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start::row-1 -->
<div class="row">
    <div class="col-xl-8">
        <!-- Status Alert -->
        @if($tagihan->status === 'sudah')
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
                <i class="ti ti-check-circle me-2"></i>
                <strong>Pembayaran Lunas!</strong> Tagihan ini telah berhasil dibayar.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @else
            <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
                <i class="ti ti-alert-circle me-2"></i>
                <strong>Pembayaran Tertunda</strong> Segera lakukan pembayaran untuk menghindari denda keterlambatan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Invoice Card -->
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Informasi Tagihan</h5>
                    <span class="badge 
                        @if($tagihan->status === 'sudah')
                            bg-success
                        @else
                            bg-warning
                        @endif
                    ">
                        @if($tagihan->status === 'sudah')
                            <i class="ti ti-check me-1"></i>Sudah Bayar
                        @else
                            <i class="ti ti-alert-circle me-1"></i>Belum Bayar
                        @endif
                    </span>
                </div>
            </div>
            <div class="card-body">
                <!-- Nominal Section -->
                <div class="text-center p-3 bg-light rounded mb-4">
                    <p class="text-muted mb-1">Jumlah Tagihan</p>
                    <h2 class="text-primary mb-0">Rp. {{ number_format($tagihan->nominal, 0, ',', '.') }}</h2>
                </div>

                <!-- Details Grid -->
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted fw-medium">Nama Tagihan</label>
                        <p class="mb-0 fw-bold">{{ $tagihan->nama_tagihan }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted fw-medium">Jatuh Tempo</label>
                        <p class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d M Y') }}</p>
                    </div>
                </div>

                <hr class="my-3">

                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label text-muted fw-medium">Deskripsi / Keterangan</label>
                        <p class="mb-0">{{ $tagihan->deskripsi ?? 'Tidak ada keterangan tambahan' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-xl-4">
        <!-- Action Card -->
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0">Tindakan</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($tagihan->status !== 'sudah')
                        <a href="{{ route('PaymentPage.show', [$tagihan->id, $tagihan->user_id]) }}" class="btn btn-primary btn-lg">
                            <i class="ti ti-credit-card me-2"></i>Bayar Sekarang
                        </a>
                    @else
                        <button class="btn btn-success btn-lg" disabled>
                            <i class="ti ti-check me-2"></i>Sudah Dibayar
                        </button>
                    @endif
                    <a href="{{ route('user.tagihan.index') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card custom-card border-0 shadow-sm mt-3">
            <div class="card-body">
                <h6 class="text-muted fw-bold mb-3">Perlu Bantuan?</h6>
                <p class="small text-muted mb-3">Jika ada pertanyaan tentang tagihan ini, hubungi customer service kami.</p>
                <button class="btn btn-sm btn-outline-primary w-100" disabled>
                    <i class="ti ti-message me-2"></i>Chat dengan Customer Service
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End::row-1 -->

@endsection
