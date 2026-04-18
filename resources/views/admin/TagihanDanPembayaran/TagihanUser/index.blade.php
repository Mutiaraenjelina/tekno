@extends('layouts.admin.template')
@section('content')

<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Pusat Link & QR Pembayaran</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('Dashboard.index') }}">Admin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Link & QR Pembayaran</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="ti ti-check-circle me-2"></i>
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="ti ti-alert-circle me-2"></i>
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi Kesalahan!</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<style>
    .share-tools {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .share-tools .btn {
        min-width: 112px;
    }

    .quick-copy-link {
        border-style: dashed;
    }

    .share-guide-card {
        border: 1px solid #dce8f3;
        border-radius: 12px;
        background: linear-gradient(135deg, #f8fcff 0%, #eef7ff 100%);
    }
</style>

<div class="row mb-3">
    <div class="col-xl-12">
        <div class="card custom-card border-0 shadow-sm share-guide-card">
            <div class="card-body py-3">
                <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
                    <div>
                        <h6 class="mb-1"><i class="ti ti-bulb me-1"></i>Cara Kirim Link / QR ke Pelanggan</h6>
                        <p class="text-muted mb-0 small">1) Pelanggan baru muncul di panel "Pelanggan Belum Ditagihkan". 2) Buat assignment tagihan ke user. 3) Klik tombol Link / QR di tabel. 4) Salin link, kirim WhatsApp, atau unduh QR.</p>
                    </div>
                    <span class="badge bg-primary">Portal Pembayaran Aktif</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-xl-4 col-md-6">
        <div class="card custom-card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Pelanggan Belum Ditagihkan</p>
                <h3 class="mb-0">{{ $pelangganBelumDitagih->count() }}</h3>
                <small class="text-muted">Perlu assignment untuk kirim link/QR</small>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card custom-card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Assignment Belum Bayar</p>
                <h3 class="mb-0">{{ $assignmentBelumBayarCount }}</h3>
                <small class="text-muted">Bisa kirim ulang link/QR sebagai pengingat</small>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-12">
        <div class="card custom-card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Pembayaran Sukses Hari Ini</p>
                <h3 class="mb-0">{{ $pembayaranSuksesHariIniCount }}</h3>
                <small class="text-muted">Sinkron otomatis dari status Midtrans</small>
            </div>
        </div>
    </div>
</div>

@if($pelangganBelumDitagih->isNotEmpty())
    <div class="row mb-3">
        <div class="col-xl-12">
            <div class="card custom-card border-0 shadow-sm">
                <div class="card-header bg-light border-0">
                    <h6 class="mb-0"><i class="ti ti-bell me-1"></i>Pelanggan Belum Ditagihkan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Username Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>No. WA</th>
                                    <th>Aksi Cepat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pelangganBelumDitagih as $row)
                                    <tr>
                                        <td><span class="badge bg-info">#{{ $row->id }}</span></td>
                                        <td>{{ $row->username }}</td>
                                        <td>{{ $row->namaPelanggan ?? '-' }}</td>
                                        <td>{{ $row->no_wa ?? '-' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary quick-select-user" data-user-id="{{ $row->id }}">
                                                Pilih User Ini
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row mb-3">
    <div class="col-xl-12">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <div class="card-title mb-0">
                    <i class="ti ti-plus me-2"></i>Tambah Assignment Tagihan (Sumber Link/QR)
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('TagihanUser.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Metode Pilih Tagihan</label>
                        <select id="tagihan_input_mode" class="form-select">
                            <option value="list" {{ old('tagihan_id_manual') ? '' : 'selected' }}>Pilih dari daftar</option>
                            <option value="manual" {{ old('tagihan_id_manual') ? 'selected' : '' }}>Input ID manual</option>
                        </select>
                        <small class="text-muted d-block mt-1">Pilih metode input tagihan</small>
                    </div>
                    <div class="col-md-4" id="tagihan_select_wrapper">
                        <label class="form-label fw-medium">Tagihan (Dropdown)</label>
                        <select name="tagihan_id" id="tagihan_id_select" class="form-select" required>
                            <option value="">-- Pilih Tagihan --</option>
                            @if($tagihanOptions->isEmpty())
                                <option value="" disabled>Tidak ada tagihan tersedia</option>
                            @else
                                @foreach ($tagihanOptions as $tagihan)
                                    <option value="{{ $tagihan->id }}" {{ (string) old('tagihan_id') === (string) $tagihan->id ? 'selected' : '' }}>
                                        {{ $tagihan->nama_tagihan }} (Rp. {{ number_format($tagihan->nominal, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="text-muted d-block mt-1">Pilih tagihan yang akan diberikan ke user</small>
                    </div>
                    <div class="col-md-4 d-none" id="tagihan_manual_wrapper">
                        <label class="form-label fw-medium">Tagihan (Input Manual)</label>
                        <input
                            type="number"
                            name="tagihan_id_manual"
                            id="tagihan_id_manual"
                            class="form-control"
                            min="1"
                            placeholder="Contoh: 12"
                            value="{{ old('tagihan_id_manual') }}"
                            disabled
                        >
                        <small class="text-muted d-block mt-1">Masukkan ID tagihan secara manual</small>
                        @if($tagihanOptions->isNotEmpty())
                            <small class="text-muted d-block mt-1">
                                ID tersedia:
                                @foreach($tagihanOptions->take(10) as $tagihan)
                                    <span class="badge bg-light text-dark border me-1 mb-1">#{{ $tagihan->id }} {{ $tagihan->nama_tagihan }}</span>
                                @endforeach
                            </small>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-medium">User</label>
                        <select name="user_id" id="assignment_user_select" class="form-select" required>
                            <option value="">-- Pilih User --</option>
                            @if($userOptions->isEmpty())
                                <option value="" disabled>Tidak ada user tersedia</option>
                            @else
                                @foreach ($userOptions as $user)
                                    <option value="{{ $user->id }}" {{ (string) old('user_id') === (string) $user->id ? 'selected' : '' }}>
                                        {{ $user->username }} @if($user->namaPelanggan) ({{ $user->namaPelanggan }}) @endif
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="text-muted d-block mt-1">Akun login pelanggan (otomatis dibuat dari menu Penerima Tagihan)</small>
                        @if($userOptions->isNotEmpty())
                            <small class="text-muted d-block mt-1">
                                ID user tersedia:
                                @foreach($userOptions->take(10) as $user)
                                    <span class="badge bg-light text-dark border me-1 mb-1">#{{ $user->id }} {{ $user->username }}</span>
                                @endforeach
                            </small>
                        @else
                            <small class="text-danger d-block mt-1">Belum ada akun pelanggan. Tambahkan pelanggan di menu Penerima Tagihan terlebih dahulu.</small>
                        @endif
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium">Status</label>
                        <select name="status" id="assignment_status_select" class="form-select" required>
                            <option value="belum">Belum Bayar</option>
                            <option value="sudah">Sudah Bayar</option>
                        </select>
                        <small class="text-muted d-block mt-1">Status pembayaran</small>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium">Payment ID</label>
                        <input type="number" id="assignment_payment_id" name="payment_id" class="form-control" placeholder="Otomatis kosong untuk link/QR" value="{{ old('payment_id') }}" disabled>
                        <small class="text-muted d-block mt-1">Isi hanya jika transaksi sudah ada</small>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="ti ti-check me-2"></i>Simpan Assignment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-xl-12">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <div class="card-title mb-0">
                    <i class="ti ti-list me-2"></i>Daftar Assignment
                    <span class="badge bg-primary float-end">{{ count($assignments) }} assignment</span>
                </div>
            </div>
            <div class="card-body">
                @if($assignments->isEmpty())
                    <div class="text-center py-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="text-muted opacity-50 mb-3" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        </svg>
                        <h6 class="fw-bold text-muted">Belum Ada Assignment</h6>
                        <p class="text-muted mb-0">Gunakan form di atas untuk menambahkan assignment tagihan kepada user</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="25%">Tagihan</th>
                                    <th width="20%">User</th>
                                    <th width="15%">Status Pembayaran</th>
                                    <th width="15%">Payment ID</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignments as $assignment)
                                    <tr>
                                        <td class="fw-bold">
                                            <span class="badge bg-info">{{ $assignment->id }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $assignment->nama_tagihan }}</div>
                                            <small class="text-muted">Rp. {{ number_format($assignment->nominal, 0, ',', '.') }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $assignment->username }}</div>
                                            <small class="text-muted">{{ $assignment->email }}</small>
                                            @if($assignment->no_wa)
                                                <small class="text-muted d-block">WA: {{ $assignment->no_wa }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($assignment->status === 'sudah')
                                                <span class="badge bg-success mb-1">
                                                    <i class="ti ti-check me-1"></i>Sudah Bayar
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark mb-1">
                                                    <i class="ti ti-clock-hour-3 me-1"></i>Belum Bayar
                                                </span>
                                            @endif

                                            <div>
                                                @if($assignment->transaksi_status)
                                                    <span class="badge 
                                                        @if($assignment->transaksi_status === 'settlement' || $assignment->transaksi_status === 'capture' || $assignment->transaksi_status === 'success')
                                                            bg-success
                                                        @elseif($assignment->transaksi_status === 'pending')
                                                            bg-warning text-dark
                                                        @else
                                                            bg-secondary
                                                        @endif
                                                    ">
                                                        Gateway: {{ strtoupper($assignment->transaksi_status) }}
                                                    </span>
                                                    @if($assignment->order_id)
                                                        <small class="text-muted d-block mt-1">Order: {{ $assignment->order_id }}</small>
                                                    @endif
                                                @else
                                                    <small class="text-muted d-block mt-1">
                                                        <i class="ti ti-minus me-1"></i>
                                                        {{ $assignment->status === 'sudah' ? 'Dibayar manual (tanpa transaksi gateway)' : 'Belum ada transaksi' }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('TagihanUser.update', $assignment->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group input-group-sm mb-2">
                                                    <select name="status" class="form-select form-select-sm">
                                                        <option value="belum" {{ $assignment->status === 'belum' ? 'selected' : '' }}>Belum</option>
                                                        <option value="sudah" {{ $assignment->status === 'sudah' ? 'selected' : '' }}>Sudah</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-outline-warning">
                                                        <i class="ti ti-refresh"></i>Update
                                                    </button>
                                                </div>
                                                <input type="number" name="payment_id" class="form-control form-control-sm" value="{{ $assignment->payment_id }}" placeholder="Payment ID (opsional)">
                                            </form>
                                        </td>
                                        <td>
                                            @php
                                                $paymentLink = route('PaymentPage.show', [$assignment->tagihan_id, $assignment->user_id]);
                                            @endphp

                                            <div class="d-grid gap-2">
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-primary open-share-modal"
                                                    data-payment-link="{{ $paymentLink }}"
                                                    data-tagihan-nama="{{ e($assignment->nama_tagihan) }}"
                                                    data-username="{{ e($assignment->username) }}"
                                                    data-nominal="{{ number_format($assignment->nominal, 0, ',', '.') }}"
                                                    data-no-wa="{{ e($assignment->no_wa ?? '') }}"
                                                >
                                                    <i class="ti ti-qrcode me-1"></i>Link / QR
                                                </button>

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-secondary quick-copy-link"
                                                    data-payment-link="{{ $paymentLink }}"
                                                >
                                                    <i class="ti ti-copy me-1"></i>Salin Link
                                                </button>

                                                <form action="{{ route('TagihanUser.delete', $assignment->id) }}" method="POST" onsubmit="return confirm('Hapus assignment ini? Tindakan ini tidak dapat dibatalkan.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger w-100">
                                                        <i class="ti ti-trash me-1"></i>Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sharePaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti ti-share me-2"></i>Bagikan Link Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-1"><strong>Tagihan:</strong> <span id="shareTagihanNama">-</span></p>
                <p class="mb-3"><strong>User:</strong> <span id="shareUsername">-</span></p>
                <p class="mb-3"><strong>Nominal:</strong> Rp <span id="shareNominal">-</span></p>

                <label class="form-label fw-medium">Link Pembayaran</label>
                <div class="input-group mb-3">
                    <input type="text" id="sharePaymentLinkInput" class="form-control" readonly>
                    <button type="button" class="btn btn-outline-primary" id="copyPaymentLinkBtn">
                        <i class="ti ti-copy me-1"></i>Salin
                    </button>
                </div>

                <label class="form-label fw-medium">Nomor WhatsApp Tujuan</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">+62</span>
                    <input type="text" id="shareWhatsappNumber" class="form-control" placeholder="812xxxxxxx">
                </div>

                <div class="text-center border rounded p-3 bg-light">
                    <img id="shareQrImage" src="" alt="QR Pembayaran" class="img-fluid" style="max-width: 220px;">
                    <p class="text-muted small mt-2 mb-0">Pelanggan cukup scan QR ini untuk membuka halaman pembayaran.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" id="downloadQrBtn">
                    <i class="ti ti-download me-1"></i>Unduh QR
                </button>
                <a id="shareWhatsappBtn" href="#" target="_blank" class="btn btn-success">
                    <i class="ti ti-brand-whatsapp me-1"></i>Kirim ke WhatsApp
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mode = document.getElementById('tagihan_input_mode');
    const selectWrapper = document.getElementById('tagihan_select_wrapper');
    const manualWrapper = document.getElementById('tagihan_manual_wrapper');
    const selectInput = document.getElementById('tagihan_id_select');
    const manualInput = document.getElementById('tagihan_id_manual');
    const assignmentUserSelect = document.getElementById('assignment_user_select');
    const assignmentStatusSelect = document.getElementById('assignment_status_select');
    const assignmentPaymentId = document.getElementById('assignment_payment_id');

    function toggleTagihanInput() {
        const isManual = mode.value === 'manual';

        selectWrapper.classList.toggle('d-none', isManual);
        manualWrapper.classList.toggle('d-none', !isManual);

        selectInput.disabled = isManual;
        selectInput.required = !isManual;

        manualInput.disabled = !isManual;
        manualInput.required = isManual;
    }

    mode.addEventListener('change', toggleTagihanInput);
    toggleTagihanInput();

    function togglePaymentIdInput() {
        const shouldEnable = assignmentStatusSelect.value === 'sudah';
        assignmentPaymentId.disabled = !shouldEnable;

        if (!shouldEnable) {
            assignmentPaymentId.value = '';
        }
    }

    assignmentStatusSelect.addEventListener('change', togglePaymentIdInput);
    togglePaymentIdInput();

    document.querySelectorAll('.quick-select-user').forEach(function (button) {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-user-id');
            if (!userId) {
                return;
            }

            assignmentUserSelect.value = userId;
            assignmentUserSelect.dispatchEvent(new Event('change'));
            window.scrollTo({ top: 280, behavior: 'smooth' });
        });
    });

    const shareModalEl = document.getElementById('sharePaymentModal');
    const shareModal = new bootstrap.Modal(shareModalEl);
    const shareTagihanNama = document.getElementById('shareTagihanNama');
    const shareUsername = document.getElementById('shareUsername');
    const shareNominal = document.getElementById('shareNominal');
    const sharePaymentLinkInput = document.getElementById('sharePaymentLinkInput');
    const shareWhatsappNumber = document.getElementById('shareWhatsappNumber');
    const shareQrImage = document.getElementById('shareQrImage');
    const copyPaymentLinkBtn = document.getElementById('copyPaymentLinkBtn');
    const shareWhatsappBtn = document.getElementById('shareWhatsappBtn');
    const downloadQrBtn = document.getElementById('downloadQrBtn');

    let activePaymentLink = '';
    let activeQrUrl = '';

    function normalizePhone(phoneValue) {
        if (!phoneValue) {
            return '';
        }

        const digits = String(phoneValue).replace(/\D/g, '');
        if (!digits) {
            return '';
        }

        if (digits.startsWith('0')) {
            return '62' + digits.substring(1);
        }

        if (digits.startsWith('62')) {
            return digits;
        }

        return '62' + digits;
    }

    function refreshWhatsappShareLink() {
        const normalizedPhone = normalizePhone(shareWhatsappNumber.value);
        const waText = 'Halo, berikut link pembayaran tagihan Anda: ' + activePaymentLink;

        if (normalizedPhone) {
            shareWhatsappBtn.setAttribute('href', 'https://wa.me/' + normalizedPhone + '?text=' + encodeURIComponent(waText));
        } else {
            shareWhatsappBtn.setAttribute('href', 'https://wa.me/?text=' + encodeURIComponent(waText));
        }
    }

    function updateShareModal(link, tagihanNama, username, nominal, noWa) {
        activePaymentLink = link;
        shareTagihanNama.textContent = tagihanNama || '-';
        shareUsername.textContent = username || '-';
        shareNominal.textContent = nominal || '-';
        sharePaymentLinkInput.value = activePaymentLink;
        shareWhatsappNumber.value = noWa || '';

        activeQrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' + encodeURIComponent(activePaymentLink);
        shareQrImage.setAttribute('src', activeQrUrl);

        refreshWhatsappShareLink();
    }

    document.querySelectorAll('.open-share-modal').forEach(function (button) {
        button.addEventListener('click', function () {
            const link = this.getAttribute('data-payment-link') || '';
            const tagihanNama = this.getAttribute('data-tagihan-nama') || '';
            const username = this.getAttribute('data-username') || '';
            const nominal = this.getAttribute('data-nominal') || '';
            const noWa = this.getAttribute('data-no-wa') || '';

            if (!link) {
                alert('Link pembayaran tidak tersedia.');
                return;
            }

            updateShareModal(link, tagihanNama, username, nominal, noWa);
            shareModal.show();
        });
    });

    shareWhatsappNumber.addEventListener('input', function () {
        refreshWhatsappShareLink();
    });

    document.querySelectorAll('.quick-copy-link').forEach(function (button) {
        button.addEventListener('click', async function () {
            const link = this.getAttribute('data-payment-link') || '';
            if (!link) {
                return;
            }

            const originalHtml = this.innerHTML;
            try {
                await navigator.clipboard.writeText(link);
                this.innerHTML = '<i class="ti ti-check me-1"></i>Tersalin';
            } catch (error) {
                const tempInput = document.createElement('input');
                tempInput.value = link;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                this.innerHTML = '<i class="ti ti-check me-1"></i>Tersalin';
            }

            setTimeout(() => {
                this.innerHTML = originalHtml;
            }, 1200);
        });
    });

    downloadQrBtn.addEventListener('click', function () {
        if (!activeQrUrl) {
            return;
        }

        const anchor = document.createElement('a');
        anchor.href = activeQrUrl;
        anchor.download = 'qr-pembayaran.png';
        anchor.target = '_blank';
        document.body.appendChild(anchor);
        anchor.click();
        document.body.removeChild(anchor);
    });

    copyPaymentLinkBtn.addEventListener('click', async function () {
        if (!activePaymentLink) {
            return;
        }

        try {
            await navigator.clipboard.writeText(activePaymentLink);
            this.innerHTML = '<i class="ti ti-check me-1"></i>Tersalin';
            setTimeout(() => {
                this.innerHTML = '<i class="ti ti-copy me-1"></i>Salin';
            }, 1300);
        } catch (error) {
            sharePaymentLinkInput.select();
            document.execCommand('copy');
            this.innerHTML = '<i class="ti ti-check me-1"></i>Tersalin';
            setTimeout(() => {
                this.innerHTML = '<i class="ti ti-copy me-1"></i>Salin';
            }, 1300);
        }
    });
});
</script>

@endsection
