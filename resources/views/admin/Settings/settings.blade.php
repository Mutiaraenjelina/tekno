@extends('layouts.admin.template')
@section('content')

<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Pengaturan Aplikasi</h1>
        <nav>
            <ol class="breadcrumb breadcrumb-example1 mb-0">
                <li class="breadcrumb-item"><a href="{{ route('Dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pengaturan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-8">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <div class="card-title mb-0">Pengaturan Umum</div>
            </div>
            <div class="card-body">
                <form action="{{ route('Admin.settings.update') }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-12">
                        <label class="form-label fw-medium">Nama Aplikasi</label>
                        <input type="text" name="app_name" class="form-control" value="{{ old('app_name', $settings['app_name']) }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium">Deskripsi Aplikasi</label>
                        <textarea name="app_description" class="form-control" rows="3" placeholder="Deskripsi singkat">{{ old('app_description', $settings['app_description']) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium">WhatsApp Bantuan</label>
                        <input type="text" name="support_whatsapp" class="form-control" value="{{ old('support_whatsapp', $settings['support_whatsapp']) }}" placeholder="contoh: 6281234567890">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i>Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Catatan</h6>
                <ul class="mb-0 ps-3 text-muted">
                    <li>Pengaturan disimpan ke file lokal sistem.</li>
                    <li>Perubahan nama aplikasi tidak mengubah file env.</li>
                    <li>Nomor WhatsApp hanya untuk info bantuan.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
