@extends('layouts.user.template')
@section('content')

<!-- Page Header -->
<div class="user-page-header">
    <h1><i class="ti ti-layout-dashboard"></i> Dashboard Saya</h1>
    <p class="subtitle">Selamat datang kembali, {{ Auth::user()->username }}! 👋</p>
</div>
<!-- Page Header Close -->

<!-- Alert Section -->
<div class="user-alert">
    <div class="user-alert-title">
        <i class="ti ti-alert-circle"></i> Informasi Penting
    </div>
    <div class="user-alert-message">
        Pastikan Anda menyelesaikan semua pembayaran tagihan tepat waktu untuk menghindari denda keterlambatan. Hubungi kami jika memiliki pertanyaan.
    </div>
</div>

<!-- Start::row-1 - Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="ti ti-receipt"></i>
            </div>
            <div class="stat-label">Total Tagihan</div>
            <div class="stat-number" id="totalTagihan">-</div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-icon" style="color: #28a745;">
                <i class="ti ti-circle-check"></i>
            </div>
            <div class="stat-label">Sudah Dibayar</div>
            <div class="stat-number" id="sudahBayar" style="color: #28a745;">-</div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-icon" style="color: #ffc107;">
                <i class="ti ti-alert-circle"></i>
            </div>
            <div class="stat-label">Belum Dibayar</div>
            <div class="stat-number" id="belumBayar" style="color: #ffc107;">-</div>
        </div>
    </div>
</div>
<!-- End::row-1 -->

<!-- Module Link Section -->
<div class="user-card">
    <div class="user-card-title">
        <i class="ti ti-link"></i> Modul Terhubung dari Admin
    </div>
    <div class="row g-3">
        <div class="col-md-4">
            <a href="{{ route('user.tagihan.index') }}" class="text-decoration-none">
                <div class="p-3 border rounded h-100">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="fw-semibold">Tagihan</div>
                        <span class="badge {{ $syncStatus['tagihan']['exists'] ? 'bg-success' : 'bg-secondary' }}">
                            {{ $syncStatus['tagihan']['exists'] ? 'ADA' : 'TIDAK' }}
                        </span>
                    </div>
                    <small class="text-muted d-block">{{ $syncStatus['tagihan']['label'] }}</small>
                    <small class="text-muted">Jumlah: {{ $syncStatus['tagihan']['count'] }}</small>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('user.pelanggan.index') }}" class="text-decoration-none">
                <div class="p-3 border rounded h-100">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="fw-semibold">Pelanggan</div>
                        <span class="badge {{ $syncStatus['pelanggan']['exists'] ? 'bg-success' : 'bg-secondary' }}">
                            {{ $syncStatus['pelanggan']['exists'] ? 'ADA' : 'TIDAK' }}
                        </span>
                    </div>
                    <small class="text-muted d-block">{{ $syncStatus['pelanggan']['label'] }}</small>
                    <small class="text-muted">Jumlah: {{ $syncStatus['pelanggan']['count'] }}</small>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('user.assignment.tagihan.index') }}" class="text-decoration-none">
                <div class="p-3 border rounded h-100">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="fw-semibold">Assignment Tagihan User</div>
                        <span class="badge {{ $syncStatus['assignment']['exists'] ? 'bg-success' : 'bg-secondary' }}">
                            {{ $syncStatus['assignment']['exists'] ? 'ADA' : 'TIDAK' }}
                        </span>
                    </div>
                    <small class="text-muted d-block">{{ $syncStatus['assignment']['label'] }}</small>
                    <small class="text-muted">Jumlah: {{ $syncStatus['assignment']['count'] }}</small>
                </div>
            </a>
        </div>
    </div>

    <div class="mt-3 p-3 rounded" style="background-color:#f8f9fa;">
        <div class="d-flex justify-content-between align-items-center">
            <div class="fw-semibold">Bukti Transaksi Pembayaran</div>
            <span class="badge {{ $syncStatus['transaksi']['exists'] ? 'bg-success' : 'bg-secondary' }}">
                {{ $syncStatus['transaksi']['exists'] ? 'ADA' : 'TIDAK' }}
            </span>
        </div>
        <small class="text-muted d-block">{{ $syncStatus['transaksi']['label'] }}</small>
        <small class="text-muted">Jumlah: {{ $syncStatus['transaksi']['count'] }}</small>
    </div>
</div>

<!-- Tagihan Terbaru Section -->
<div class="user-card">
    <div class="user-card-title">
        <i class="ti ti-list"></i> Tagihan Terbaru
    </div>
    
    <div id="tagihanLoading" class="text-center py-4">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div id="tagihanContent" style="display: none;">
        <div class="user-table">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Tagihan</th>
                        <th>Nominal</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tagihanTableBody">
                    <!-- Filled by JavaScript -->
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <a href="{{ route('user.tagihan.index') }}" class="btn btn-user-primary">
                <i class="ti ti-eye me-2"></i>Lihat Semua Tagihan
            </a>
        </div>
    </div>

    <div id="tagihanEmpty" style="display: none;" class="empty-state">
        <i class="ti ti-inbox"></i>
        <h4>Tidak Ada Tagihan</h4>
        <p>Saat ini Anda tidak memiliki tagihan yang tertampilkan.</p>
    </div>
</div>

<!-- Info Card -->
<div class="user-card">
    <div class="user-card-title">
        <i class="ti ti-info-circle"></i> Informasi Profil
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-6" style="color: #666;">Username</label>
            <p><strong>{{ Auth::user()->username }}</strong></p>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label fw-6" style="color: #666;">Email</label>
            <p><strong>{{ Auth::user()->email ?? '-' }}</strong></p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch tagihan data
    fetch('{{ route("api.user.tagihan.index") }}')
        .then(response => response.json())
        .then(data => {
            const tagihanBody = document.getElementById('tagihanTableBody');
            const tagihanLoading = document.getElementById('tagihanLoading');
            const tagihanContent = document.getElementById('tagihanContent');
            const tagihanEmpty = document.getElementById('tagihanEmpty');

            tagihanLoading.style.display = 'none';

            if (data.data && data.data.length > 0) {
                // Show recent 5 tagihan
                const recent = data.data.slice(0, 5);
                
                recent.forEach(item => {
                    const statusBadge = item.status === 'sudah' 
                        ? '<span class="badge-status-bayar">✓ Sudah Bayar</span>'
                        : '<span class="badge-status-belum">⟳ Belum Bayar</span>';
                    
                    const row = `
                        <tr>
                            <td>
                                <strong>${item.nama_tagihan}</strong><br>
                                <small class="text-muted">${item.deskripsi || '-'}</small>
                            </td>
                            <td>
                                <strong>Rp ${parseInt(item.nominal).toLocaleString('id-ID')}</strong>
                            </td>
                            <td>
                                ${new Date(item.jatuh_tempo).toLocaleDateString('id-ID')}
                            </td>
                            <td>
                                ${statusBadge}
                            </td>
                            <td>
                                <a href="{{ route('user.tagihan.show', '') }}/${item.id}" class="btn btn-sm btn-user-secondary">
                                    <i class="ti ti-eye"></i>
                                </a>
                            </td>
                        </tr>
                    `;
                    tagihanBody.innerHTML += row;
                });

                tagihanContent.style.display = 'block';

                // Update stats
                const sudah = data.data.filter(t => t.status === 'sudah').length;
                const belum = data.data.filter(t => t.status === 'belum').length;
                
                document.getElementById('totalTagihan').innerText = data.data.length;
                document.getElementById('sudahBayar').innerText = sudah;
                document.getElementById('belumBayar').innerText = belum;
            } else {
                tagihanEmpty.style.display = 'block';
                document.getElementById('totalTagihan').innerText = '0';
                document.getElementById('sudahBayar').innerText = '0';
                document.getElementById('belumBayar').innerText = '0';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('tagihanLoading').style.display = 'none';
            document.getElementById('tagihanEmpty').style.display = 'block';
        });
});
</script>

@endsection
