@extends('layouts.admin.template')
@section('content')

<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Edit Tagihan</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('Dashboard.index') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ModuleTagihan.index') }}">Tagihan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit #{{ $tagihan->id }}</li>
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
                    <i class="ti ti-pencil me-2"></i>Edit Informasi Tagihan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('ModuleTagihan.update', $tagihan->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')
                    
                    <div class="col-12">
                        <label class="form-label fw-medium">Nama Tagihan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_tagihan" class="form-control @error('nama_tagihan') is-invalid @enderror" 
                            placeholder="Contoh: Biaya Retribusi Parkir" value="{{ old('nama_tagihan', $tagihan->nama_tagihan) }}" required>
                        @error('nama_tagihan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-1">Nama tagihan yang akan dilihat oleh pelanggan</small>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium">Deskripsi <span class="text-muted">(Opsional)</span></label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                            rows="3" placeholder="Deskripsi atau keterangan tambahan tagihan...">{{ old('deskripsi', $tagihan->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium">Nominal <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp.</span>
                            <input type="number" name="nominal" class="form-control @error('nominal') is-invalid @enderror" 
                                placeholder="0" value="{{ old('nominal', $tagihan->nominal) }}" step="1000" min="0" required>
                        </div>
                        @error('nominal')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium">Tipe Tagihan <span class="text-danger">*</span></label>
                        <select name="tipe" class="form-select @error('tipe') is-invalid @enderror" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="rutin" {{ old('tipe', $tagihan->tipe) === 'rutin' ? 'selected' : '' }}>Rutin (Berulang)</option>
                            <option value="sekali" {{ old('tipe', $tagihan->tipe) === 'sekali' ? 'selected' : '' }}>Sekali (Satu Kali)</option>
                        </select>
                        @error('tipe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium">Jatuh Tempo <span class="text-danger">*</span></label>
                        <input type="date" name="jatuh_tempo" class="form-control @error('jatuh_tempo') is-invalid @enderror" 
                            value="{{ old('jatuh_tempo', $tagihan->jatuh_tempo) }}" required>
                        @error('jatuh_tempo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-1">Tanggal kapan tagihan harus dibayar</small>
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="ti ti-check me-2"></i>Update Tagihan
                            </button>
                            <a href="{{ route('ModuleTagihan.index') }}" class="btn btn-outline-secondary btn-lg">
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
                <h6 class="mb-0">Info Tagihan</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">ID Tagihan</label>
                    <h6 class="fw-bold">{{ $tagihan->id }}</h6>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Dibuat Oleh</label>
                    <h6 class="fw-bold">#{{ $tagihan->created_by }}</h6>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Dibuat Pada</label>
                    <h6 class="fw-bold">{{ \Carbon\Carbon::parse($tagihan->created_at)->format('d M Y H:i') }}</h6>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Diubah Terakhir</label>
                    <h6 class="fw-bold">{{ \Carbon\Carbon::parse($tagihan->updated_at)->format('d M Y H:i') }}</h6>
                </div>
            </div>
        </div>

        <div class="card custom-card border-0 shadow-sm mt-3">
            <div class="card-body">
                <a href="{{ route('ModuleTagihan.index') }}" class="btn btn-outline-primary w-100">
                    <i class="ti ti-arrow-left me-2"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
