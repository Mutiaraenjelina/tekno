@extends('layouts.admin.template')
@section('content')

<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Manajemen Tagihan</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('Dashboard.index') }}">Admin</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tagihan</li>
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
                    <i class="ti ti-list me-2"></i>Daftar Tagihan
                </h5>
                <a href="{{ route('ModuleTagihan.create') }}" class="btn btn-sm btn-primary">
                    <i class="ti ti-plus me-1"></i>Tambah Tagihan
                </a>
            </div>
            <div class="card-body">
                @if($tagihanList->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="25%">Nama Tagihan</th>
                                    <th width="15%">Nominal</th>
                                    <th width="10%">Tipe</th>
                                    <th width="15%">Jatuh Tempo</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tagihanList as $item)
                                    <tr>
                                        <td class="fw-bold">
                                            <span class="badge bg-info">{{ $item->id }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $item->nama_tagihan }}</div>
                                            <small class="text-muted">{{ Str::limit($item->deskripsi, 50) ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <strong>Rp. {{ number_format($item->nominal, 0, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge 
                                                @if($item->tipe === 'rutin')
                                                    bg-success
                                                @else
                                                    bg-warning
                                                @endif
                                            ">
                                                {{ ucfirst($item->tipe) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d M Y') }}
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('ModuleTagihan.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('ModuleTagihan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tagihan ini dan semua relasinya? Tindakan ini tidak dapat dibatalkan.')">
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
                        <h6 class="fw-bold text-muted">Belum Ada Tagihan</h6>
                        <p class="text-muted mb-3">Gunakan tombol di atas untuk menambahkan tagihan baru</p>
                        <a href="{{ route('ModuleTagihan.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i>Buat Tagihan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
