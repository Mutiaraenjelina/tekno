@extends('layouts.user.template')
@section('content')

<div class="user-page-header">
    <h1><i class="ti ti-credit-card-pay"></i> Pembayaran Tagihan</h1>
    <p class="subtitle">Lanjutkan pembayaran tagihan Anda dengan aman.</p>
</div>

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="ti ti-alert-circle me-2"></i>
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
        <div class="user-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <div class="user-card-title mb-1">
                        <i class="ti ti-receipt"></i>{{ $tagihan->nama_tagihan }}
                    </div>
                    <small class="text-muted">ID Tagihan: #{{ $tagihan->id }}</small>
                </div>
                <span class="badge bg-primary">Tagihan Aktif</span>
            </div>

            <div class="text-center mb-4 p-3 rounded" style="background: linear-gradient(135deg, rgba(35,144,190,0.1) 0%, rgba(35,144,190,0.04) 100%);">
                <p class="text-muted mb-1">Jumlah yang Harus Dibayar</p>
                <h2 class="mb-0" style="color:#2390be;">Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</h2>
            </div>

            <div class="row mb-2">
                <div class="col-md-6 mb-3">
                    <p class="mb-1 text-muted fw-medium">Akun Pembayar</p>
                    <p class="mb-0 fw-semibold">{{ $user->username }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="mb-1 text-muted fw-medium">Jatuh Tempo</p>
                    <p class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d M Y') }}</p>
                </div>
            </div>

            <hr class="my-3">

            <div>
                <p class="mb-1 text-muted fw-medium">Deskripsi</p>
                <p class="mb-0">{{ $tagihan->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            </div>
        </div>

        <div class="user-card mt-3">
            <div class="user-card-title mb-2">
                <i class="ti ti-credit-card"></i> Pilih Metode Pembayaran
            </div>
            <form action="{{ url('/payment/' . $tagihan->id . '/' . $user->id . '/create') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-user-primary btn-lg w-100">
                    <i class="ti ti-lock-access me-2"></i>Lanjut ke Pembayaran
                </button>
                <p class="text-muted text-center mt-3 mb-0">
                    <small>Anda akan diarahkan ke halaman pembayaran secure.</small>
                </p>
            </form>
        </div>

        <div class="mt-2">
            <a href="{{ route('user.tagihan.index') }}" class="btn btn-user-secondary w-100">
                <i class="ti ti-arrow-left me-2"></i>Kembali ke Tagihan
            </a>
        </div>
    </div>
</div>

@endsection
