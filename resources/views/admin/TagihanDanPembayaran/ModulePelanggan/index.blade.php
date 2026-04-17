@extends('layouts.admin.template')
@section('content')

<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Manajemen Pelanggan</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('Dashboard.index') }}">Admin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Pelanggan</li>
                </ol>
            </nav>
        </div>
    </div>
    <a href="{{ route('ModulePelanggan.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i>Tambah Pelanggan
    </a>
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

<div class="row">
    <div class="col-xl-8">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0 d-flex align-items-center justify-content-between">
                <h5 class="mb-0">
                    <i class="ti ti-users me-2"></i>Daftar Pelanggan
                </h5>
                <select class="form-select form-select-sm" style="width: 150px;">
                    <option selected>Semua</option>
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                </select>
            </div>
            <div class="card-body">
                @if($pelangganList->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="8%">No</th>
                                    <th width="25%">Nama Pelanggan</th>
                                    <th width="20%">Nomor WA</th>
                                    <th width="20%">User Terkait</th>
                                    <th width="12%">Terdaftar</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelangganList as $key => $item)
                                    <tr>
                                        <td class="fw-bold">{{ $key + 1 }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $item->nama }}</div>
                                            <small class="text-muted">ID #{{ $item->id }}</small>
                                        </td>
                                        <td>
                                            @if($item->no_wa)
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_wa) }}" target="_blank" class="text-success">
                                                    <i class="ti ti-brand-whatsapp me-1"></i>{{ $item->no_wa }}
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if((int) $item->linked_user_count > 0)
                                                <span class="badge bg-success">{{ $item->linked_user_count }} user</span>
                                            @else
                                                <span class="badge bg-light text-dark">Belum terhubung</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('ModulePelanggan.edit', $item->id) }}" class="btn btn-outline-warning">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('ModulePelanggan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="text-muted opacity-50 mb-3" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        </svg>
                        <h6 class="fw-bold text-muted">Belum Ada Pelanggan</h6>
                        <p class="text-muted mb-3">Mulai dengan membuat pelanggan baru</p>
                        <a href="{{ route('ModulePelanggan.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i>Buat Pelanggan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card custom-card border-0 shadow-sm bg-light-info">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="me-3">
                        <i class="ti ti-users fs-24" style="color: #2390be;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-2">Informasi Pelanggan</h6>
                        <p class="text-muted fs-13 mb-0">
                            Kelola data pelanggan dan hubungkan dengan akun user yang telah terdaftar di sistem.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card custom-card border-0 shadow-sm mt-3">
            <div class="card-header bg-light border-0">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-bulb me-2"></i>Tips
                </h6>
            </div>
            <div class="card-body p-3 fs-13">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="ti ti-check text-success me-2"></i>
                        <strong>Tambah Pelanggan</strong> untuk data customer baru
                    </li>
                    <li class="mb-2">
                        <i class="ti ti-check text-success me-2"></i>
                        Hubungkan ke user untuk akses portal
                    </li>
                    <li>
                        <i class="ti ti-check text-success me-2"></i>
                        Simpan nomor WhatsApp untuk notifikasi
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
