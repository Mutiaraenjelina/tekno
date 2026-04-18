@extends('layouts.user.template')
@section('content')

<div class="user-page-header">
    <h1><i class="ti ti-user-circle"></i> Profil Pelanggan</h1>
    <p class="subtitle">Informasi pelanggan yang terhubung dengan akun Anda.</p>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="user-card">
    @if($pelanggan)
        <div class="row g-4">
            <div class="col-12">
                <div class="user-card border" style="box-shadow:none;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h5 class="mb-1"><i class="ti ti-settings"></i> Pengaturan Akun</h5>
                            <p class="text-muted mb-0 small">Ubah username, email, dan nomor WhatsApp Anda.</p>
                        </div>
                        <span class="badge bg-info text-dark">Tersinkron ke data admin</span>
                    </div>

                    <form action="{{ route('user.pelanggan.account.update') }}" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6">
                            <label class="form-label fw-medium">Username</label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="opsional">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-medium">No WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control @error('no_wa') is-invalid @enderror" value="{{ old('no_wa', $pelanggan->no_wa) }}" required>
                            @error('no_wa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-user-primary">
                                <i class="ti ti-device-floppy me-1"></i>Simpan Perubahan Akun
                            </button>
                            <a href="{{ route('user.dashboard.index') }}" class="btn btn-user-secondary">
                                <i class="ti ti-home me-1"></i>Kembali ke Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12">
                <div class="user-card border" style="box-shadow:none;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h5 class="mb-1"><i class="ti ti-lock"></i> Ganti Password</h5>
                            <p class="text-muted mb-0 small">Gunakan password yang kuat untuk keamanan akun Anda.</p>
                        </div>
                        <span class="badge bg-warning text-dark">Opsional</span>
                    </div>

                    <form action="{{ route('user.pelanggan.password.update') }}" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-md-4">
                            <label class="form-label fw-medium">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-medium">Password Baru</label>
                            <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" required>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-medium">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>

                        <div class="col-12 d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-user-primary">
                                <i class="ti ti-device-floppy me-1"></i>Simpan Password Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="empty-state">
            <i class="ti ti-user-off"></i>
            <h4>Data Pelanggan Belum Tersedia</h4>
            <p>Akun ini belum terhubung ke data pelanggan (contoh: usaha non-rutin).</p>
        </div>
    @endif
</div>

@endsection
