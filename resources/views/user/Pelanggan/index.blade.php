@extends('layouts.user.template')
@section('content')

<div class="user-page-header">
    <h1><i class="ti ti-user-circle"></i> Profil Pelanggan</h1>
    <p class="subtitle">Informasi pelanggan yang terhubung dengan akun Anda.</p>
</div>

<div class="user-card">
    @if($pelanggan)
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">ID Pelanggan</label>
                <div class="fw-semibold">{{ $pelanggan->id }}</div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Nama Pelanggan</label>
                <div class="fw-semibold">{{ $pelanggan->nama }}</div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">No WhatsApp</label>
                <div class="fw-semibold">{{ $pelanggan->no_wa }}</div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Username Akun</label>
                <div class="fw-semibold">{{ $user->username }}</div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Email</label>
                <div class="fw-semibold">{{ $user->email ?? '-' }}</div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Terhubung Sejak</label>
                <div class="fw-semibold">{{ $pelanggan->created_at ? \Carbon\Carbon::parse($pelanggan->created_at)->format('d M Y H:i') : '-' }}</div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Terakhir Diubah Admin</label>
                <div class="fw-semibold">{{ $pelanggan->updated_at ? \Carbon\Carbon::parse($pelanggan->updated_at)->format('d M Y H:i') : '-' }}</div>
            </div>
        </div>
        <div class="alert alert-info mb-0 mt-3">
            Data pelanggan ini berasal dari modul admin dan terhubung ke akun Anda melalui relasi user-pelanggan.
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
