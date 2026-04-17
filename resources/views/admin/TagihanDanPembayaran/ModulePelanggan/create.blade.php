@extends('layouts.admin.template')
@section('content')

<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Tambah Pelanggan Baru</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('Dashboard.index') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ModulePelanggan.index') }}">Pelanggan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Baru</li>
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
                    <i class="ti ti-user-plus me-2"></i>Data Pelanggan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('ModulePelanggan.store') }}" method="POST" class="row g-3">
                    @csrf
                    
                    <div class="col-12">
                        <label class="form-label fw-medium">Nama Pelanggan <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                            placeholder="Masukkan nama pelanggan" value="{{ old('nama') }}" required>
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
                                placeholder="Contoh: 62812345678 atau +62812345678" value="{{ old('no_wa') }}" required>
                        </div>
                        @error('no_wa')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-1">Nomor WhatsApp akan digunakan untuk notifikasi pembayaran</small>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium">Hubungkan ke Akun User (Opsional)</label>
                        <select name="user_ids[]" class="form-select @error('user_ids') is-invalid @enderror" multiple>
                            @foreach($userOptions as $user)
                                <option value="{{ $user->id }}" {{ in_array($user->id, old('user_ids', [])) ? 'selected' : '' }}>
                                    {{ $user->username }} ({{ $user->email ?? '-' }})
                                    @if($user->idPersonal)
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
                        <small class="text-muted d-block mt-1">Tips: tekan Ctrl (Windows) untuk memilih lebih dari satu user.</small>
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="ti ti-check me-2"></i>Simpan Pelanggan
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
                <h6 class="mb-0">💡 Format Nomor</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="fw-bold mb-2">✅ Format Benar:</h6>
                    <ul class="small mb-0">
                        <li>62812345678 (tanpa +)</li>
                        <li>+62812345678 (dengan +)</li>
                        <li>08123456789 (dengan 0)</li>
                    </ul>
                </div>
                <div class="alert alert-info small mb-0">
                    <i class="ti ti-info-circle me-2"></i>
                    Nomor akan digunakan untuk mengirim notifikasi tagihan dan pengingat pembayaran
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
