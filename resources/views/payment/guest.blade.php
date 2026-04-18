@php
    if (file_exists(public_path('admin_resources/assets/images/user-general/sipayda_logo.png'))) {
        $brandLogo = 'admin_resources/assets/images/user-general/sipayda_logo.png';
    } elseif (file_exists(public_path('admin_resources/assets/images/user-general/sipayda_logo.jpg'))) {
        $brandLogo = 'admin_resources/assets/images/user-general/sipayda_logo.jpg';
    } elseif (file_exists(public_path('admin_resources/assets/images/user-general/sipayda_logo.jpeg'))) {
        $brandLogo = 'admin_resources/assets/images/user-general/sipayda_logo.jpeg';
    } else {
        $brandLogo = 'admin_resources/assets/images/user-general/patupa_logo_white_bg.png';
    }
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPAYDA - Pembayaran</title>
    <link rel="icon" href="{{ asset('admin_resources/assets/images/brand-logos/favicon2.ico') }}" type="image/x-icon">
    <link href="{{ asset('admin_resources/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_resources/assets/css/icons.css') }}" rel="stylesheet">
</head>
<body style="background:#f4f8fb;">
<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <img src="{{ asset($brandLogo) }}" alt="logo" style="height:92px; width:auto; object-fit:contain; mix-blend-mode:multiply; filter:contrast(1.08) saturate(1.06);">
                    </div>

                    <h4 class="mb-1">Pembayaran Tagihan</h4>
                    <p class="text-muted mb-3">Silakan lanjutkan pembayaran melalui gateway resmi.</p>

                    <div class="border rounded p-3 bg-light mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Tagihan</span>
                            <strong>{{ $tagihan->nama_tagihan }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Akun Pembayar</span>
                            <strong>{{ $user->username }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Jatuh Tempo</span>
                            <strong>{{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d M Y') }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Total</span>
                            <strong class="text-primary">Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <form action="{{ route('PaymentPage.create', [$tagihan->id, $user->id]) }}" method="POST" class="d-grid">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="ti ti-credit-card me-2"></i>Lanjut ke Pembayaran
                        </button>
                    </form>
                </div>
            </div>

            <p class="text-center text-muted mb-0"><small>Halaman ini dapat diakses tanpa login untuk pelanggan.</small></p>
        </div>
    </div>
</div>
<script src="{{ asset('admin_resources/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
