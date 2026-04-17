@extends('layouts.admin.template')
@section('content')

<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Edit Pelanggan</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('Dashboard.index') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ModulePelanggan.index') }}">Pelanggan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit #{{ $pelanggan->id }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="ti ti-alert-circle me-2"></i>
        <strong>Terjadi Kesalahan!</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-xl-8">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0">
                    <i class="ti ti-pencil me-2"></i>Edit Data Pelanggan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('ModulePelanggan.update', $pelanggan->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')
                    
                    <div class="col-12">
                        <label class="form-label fw-medium">Nama Pelanggan <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                            placeholder="Masukkan nama pelanggan" value="{{ old('nama', $pelanggan->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium">Nomor WhatsApp <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="ti ti-brand-whatsapp"></i>
                            </span>
                            <input type="text" name="no_wa" class="form-control @error('no_wa') is-invalid @enderror" 
                                placeholder="Contoh: 62812345678 atau +62812345678" value="{{ old('no_wa', $pelanggan->no_wa) }}" required>
                        </div>
                        @error('no_wa')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-1">Nomor WhatsApp akan digunakan untuk notifikasi pembayaran</small>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium">Hubungkan ke Akun User</label>
                        <select name="user_ids[]" class="form-select @error('user_ids') is-invalid @enderror" multiple>
                            @foreach($userOptions as $user)
                                <option value="{{ $user->id }}"
                                    {{ in_array($user->id, old('user_ids', $linkedUserIds ?? [])) ? 'selected' : '' }}>
                                    {{ $user->username }} ({{ $user->email ?? '-' }})
                                    @if($user->idPersonal && $user->idPersonal != $pelanggan->id)
                                        - Terhubung ke pelanggan #{{ $user->idPersonal }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('user_ids')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('user_ids.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-1">User yang dipilih akan melihat data pelanggan ini di halaman user.</small>
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="ti ti-check me-2"></i>Update Pelanggan
                            </button>
                            <a href="{{ route('ModulePelanggan.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="ti ti-x me-2"></i>Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0">Info Pelanggan</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">ID Pelanggan</label>
                    <h6 class="fw-bold">{{ $pelanggan->id }}</h6>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Terdaftar Sejak</label>
                    <h6 class="fw-bold">{{ \Carbon\Carbon::parse($pelanggan->created_at)->format('d M Y H:i') }}</h6>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Diubah Terakhir</label>
                    <h6 class="fw-bold">{{ \Carbon\Carbon::parse($pelanggan->updated_at)->format('d M Y H:i') }}</h6>
                </div>
            </div>
        </div>

        <div class="card custom-card border-0 shadow-sm mt-3">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0">Link WhatsApp</h6>
            </div>
            <div class="card-body">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pelanggan->no_wa) }}" target="_blank" class="btn btn-success w-100">
                    <i class="ti ti-brand-whatsapp me-2"></i>Buka Chat WhatsApp
                </a>
            </div>
        </div>

        <div class="card custom-card border-0 shadow-sm mt-3">
            <div class="card-body">
                <a href="{{ route('ModulePelanggan.index') }}" class="btn btn-outline-primary w-100">
                    <i class="ti ti-arrow-left me-2"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
