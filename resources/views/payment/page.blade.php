@extends('layouts.admin.template')
@section('content')

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Pembayaran Tagihan</h1>
        <nav>
            <ol class="breadcrumb breadcrumb-example1 mb-0">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.tagihan.index') }}">Tagihan Saya</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
            </ol>
        </nav>
    </div>
</div>

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ti ti-alert-circle me-2"></i>
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-lg-5">
        <!-- Invoice Card -->
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-primary bg-gradient text-white rounded-top">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-0">{{ $tagihan->nama_tagihan }}</h5>
                        <small>ID Tagihan: #{{ $tagihan->id }}</small>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16">
                        <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.207l-.646.647a.5.5 0 0 1-.708 0l-.646-.646-.646.646a.5.5 0 0 1-.708 0l-.646-.646-.646.646a.5.5 0 0 1-.708 0l-.646-.646-.646.646a.5.5 0 0 1-.708 0l-.646-.646-.646.646a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .22-.257zm1.4.854.323-1.323A.5.5 0 0 0 2.5 1H2a.5.5 0 0 0-.447.276l-.85 1.7a.5.5 0 0 0 .12.75H3a.5.5 0 0 0 .3-.075zM3.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 1 1-1 0v-9a1.5 1.5 0 0 1 1.5-1.5h8a1.5 1.5 0 0 1 1.5 1.5v9a.5.5 0 0 1-1 0v-9a.5.5 0 0 0-.5-.5z"/>
                    </svg>
                </div>
            </div>
            <div class="card-body">
                <!-- Amount Section -->
                <div class="text-center mb-4 p-3 bg-light rounded">
                    <p class="text-muted mb-1">Jumlah yang Harus Dibayar</p>
                    <h2 class="text-primary mb-0">Rp. {{ number_format($tagihan->nominal, 0, ',', '.') }}</h2>
                </div>

                <!-- Details Section -->
                <div class="row mb-3">
                    <div class="col-6">
                        <p class="mb-1 text-muted fw-medium">Pemilik Rekening</p>
                        <p class="mb-0">{{ $user->username }}</p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted fw-medium">Jatuh Tempo</p>
                        <p class="mb-0">{{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d M Y') }}</p>
                    </div>
                </div>

                <hr class="my-3">

                <div class="row">
                    <div class="col-12">
                        <p class="mb-1 text-muted fw-medium">Deskripsi</p>
                        <p class="mb-0">{{ $tagihan->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="card custom-card border-0 shadow-sm mt-4">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0">Pilih Metode Pembayaran</h5>
            </div>
            <div class="card-body">
                <form action="{{ url('/payment/' . $tagihan->id . '/' . $user->id . '/create') }}" method="POST">
                    @csrf
                    <div class="payment-method">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-credit-card me-2" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
                            </svg>
                            Lanjut ke Pembayaran
                        </button>
                    </div>
                    <p class="text-muted text-center mt-3 mb-0">
                        <small>Anda akan diarahkan ke halaman pembayaran secure</small>
                    </p>
                </form>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-3">
            <a href="{{ route('user.tagihan.index') }}" class="btn btn-outline-secondary w-100">
                <i class="ti ti-arrow-left me-2"></i>Kembali ke Tagihan
            </a>
        </div>
    </div>
</div>

@endsection
