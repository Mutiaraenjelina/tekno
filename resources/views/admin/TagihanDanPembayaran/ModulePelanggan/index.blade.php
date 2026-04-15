@extends('layouts.admin.template')
@section('content')

<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Manajemen Pelanggan</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('Dashboard.index') }}">Admin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pelanggan</li>
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

<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0 d-flex align-items-center justify-content-between">
                <h5 class="mb-0">
                    <i class="ti ti-users me-2"></i>Daftar Pelanggan
                </h5>
                <a href="{{ route('ModulePelanggan.create') }}" class="btn btn-sm btn-primary">
                    <i class="ti ti-plus me-1"></i>Tambah Pelanggan
                </a>
            </div>
            <div class="card-body">
                @if($pelangganList->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="8%">ID</th>
                                    <th width="35%">Nama Pelanggan</th>
                                    <th width="20%">Nomor WhatsApp</th>
                                    <th width="15%">Terdaftar Sejak</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelangganList as $item)
                                    <tr>
                                        <td class="fw-bold">
                                            <span class="badge bg-info">{{ $item->id }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $item->nama }}</div>
                                        </td>
                                        <td>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_wa) }}" target="_blank" class="text-success">
                                                <i class="ti ti-brand-whatsapp me-1"></i>{{ $item->no_wa }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('ModulePelanggan.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('ModulePelanggan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pelanggan ini? Tindakan ini tidak dapat dibatalkan.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
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
                        <p class="text-muted mb-3">Gunakan tombol di atas untuk menambahkan pelanggan baru</p>
                        <a href="{{ route('ModulePelanggan.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i>Buat Pelanggan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
