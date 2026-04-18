<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPAYDA - Status Pembayaran</title>
    <link rel="icon" href="{{ asset('admin_resources/assets/images/brand-logos/favicon2.ico') }}" type="image/x-icon">
    <link href="{{ asset('admin_resources/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body style="background:#f4f8fb;">
<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-2">Status Pembayaran</h4>
                    <p class="text-muted mb-3">Ringkasan transaksi terakhir untuk tagihan ini.</p>

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
                            <span class="text-muted">Nominal</span>
                            <strong>Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Order ID</span>
                            <strong>{{ $transaksi->order_id ?? '-' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Status Gateway</span>
                            <strong>{{ strtoupper($transaksi->status ?? 'pending') }}</strong>
                        </div>
                    </div>

                    <a href="{{ route('PaymentPage.show', [$tagihan->id, $user->id]) }}" class="btn btn-outline-primary w-100">Kembali ke Halaman Pembayaran</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
