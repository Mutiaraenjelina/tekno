@extends('layouts.admin.template')
@section('content')

<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Assignment Tagihan User</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Tagihan Dan Pembayaran</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Assignment Tagihan User</li>
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

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi Kesalahan!</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row mb-3">
    <div class="col-xl-12">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <div class="card-title mb-0">
                    <i class="ti ti-plus me-2"></i>Tambah Assignment Tagihan ke User
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('TagihanUser.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Metode Pilih Tagihan</label>
                        <select id="tagihan_input_mode" class="form-select">
                            <option value="list" {{ old('tagihan_id_manual') ? '' : 'selected' }}>Pilih dari daftar</option>
                            <option value="manual" {{ old('tagihan_id_manual') ? 'selected' : '' }}>Input ID manual</option>
                        </select>
                        <small class="text-muted d-block mt-1">Pilih metode input tagihan</small>
                    </div>
                    <div class="col-md-4" id="tagihan_select_wrapper">
                        <label class="form-label fw-medium">Tagihan (Dropdown)</label>
                        <select name="tagihan_id" id="tagihan_id_select" class="form-select" required>
                            <option value="">-- Pilih Tagihan --</option>
                            @if($tagihanOptions->isEmpty())
                                <option value="" disabled>Tidak ada tagihan tersedia</option>
                            @else
                                @foreach ($tagihanOptions as $tagihan)
                                    <option value="{{ $tagihan->id }}" {{ (string) old('tagihan_id') === (string) $tagihan->id ? 'selected' : '' }}>
                                        {{ $tagihan->nama_tagihan }} (Rp. {{ number_format($tagihan->nominal, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="text-muted d-block mt-1">Pilih tagihan yang akan diberikan ke user</small>
                    </div>
                    <div class="col-md-4 d-none" id="tagihan_manual_wrapper">
                        <label class="form-label fw-medium">Tagihan (Input Manual)</label>
                        <input
                            type="number"
                            name="tagihan_id_manual"
                            id="tagihan_id_manual"
                            class="form-control"
                            min="1"
                            placeholder="Contoh: 12"
                            value="{{ old('tagihan_id_manual') }}"
                            disabled
                        >
                        <small class="text-muted d-block mt-1">Masukkan ID tagihan secara manual</small>
                        @if($tagihanOptions->isNotEmpty())
                            <small class="text-muted d-block mt-1">
                                ID tersedia:
                                @foreach($tagihanOptions->take(10) as $tagihan)
                                    <span class="badge bg-light text-dark border me-1 mb-1">#{{ $tagihan->id }} {{ $tagihan->nama_tagihan }}</span>
                                @endforeach
                            </small>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-medium">User</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">-- Pilih User --</option>
                            @if($userOptions->isEmpty())
                                <option value="" disabled>Tidak ada user tersedia</option>
                            @else
                                @foreach ($userOptions as $user)
                                    <option value="{{ $user->id }}" {{ (string) old('user_id') === (string) $user->id ? 'selected' : '' }}>
                                        {{ $user->username }} @if($user->namaPelanggan) ({{ $user->namaPelanggan }}) @endif
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="text-muted d-block mt-1">User yang akan ditugaskan tagihan ini</small>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="belum">Belum Bayar</option>
                            <option value="sudah">Sudah Bayar</option>
                        </select>
                        <small class="text-muted d-block mt-1">Status pembayaran</small>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium">Payment ID</label>
                        <input type="number" name="payment_id" class="form-control" placeholder="Opsional">
                        <small class="text-muted d-block mt-1">ID transaksi (opsional)</small>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="ti ti-check me-2"></i>Simpan Assignment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-xl-12">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <div class="card-title mb-0">
                    <i class="ti ti-list me-2"></i>Daftar Assignment
                    <span class="badge bg-primary float-end">{{ count($assignments) }} assignment</span>
                </div>
            </div>
            <div class="card-body">
                @if($assignments->isEmpty())
                    <div class="text-center py-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="text-muted opacity-50 mb-3" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        </svg>
                        <h6 class="fw-bold text-muted">Belum Ada Assignment</h6>
                        <p class="text-muted mb-0">Gunakan form di atas untuk menambahkan assignment tagihan kepada user</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="25%">Tagihan</th>
                                    <th width="20%">User</th>
                                    <th width="15%">Status Pembayaran</th>
                                    <th width="15%">Payment ID</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignments as $assignment)
                                    <tr>
                                        <td class="fw-bold">
                                            <span class="badge bg-info">{{ $assignment->id }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $assignment->nama_tagihan }}</div>
                                            <small class="text-muted">Rp. {{ number_format($assignment->nominal, 0, ',', '.') }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $assignment->username }}</div>
                                            <small class="text-muted">{{ $assignment->email }}</small>
                                        </td>
                                        <td>
                                            @if($assignment->status === 'sudah')
                                                <span class="badge bg-success mb-1">
                                                    <i class="ti ti-check me-1"></i>Sudah Bayar
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark mb-1">
                                                    <i class="ti ti-clock-hour-3 me-1"></i>Belum Bayar
                                                </span>
                                            @endif

                                            <div>
                                                @if($assignment->transaksi_status)
                                                    <span class="badge 
                                                        @if($assignment->transaksi_status === 'settlement' || $assignment->transaksi_status === 'capture')
                                                            bg-success
                                                        @elseif($assignment->transaksi_status === 'pending')
                                                            bg-warning text-dark
                                                        @else
                                                            bg-secondary
                                                        @endif
                                                    ">
                                                        Gateway: {{ strtoupper($assignment->transaksi_status) }}
                                                    </span>
                                                    @if($assignment->order_id)
                                                        <small class="text-muted d-block mt-1">Order: {{ $assignment->order_id }}</small>
                                                    @endif
                                                @else
                                                    <small class="text-muted d-block mt-1">
                                                        <i class="ti ti-minus me-1"></i>
                                                        {{ $assignment->status === 'sudah' ? 'Dibayar manual (tanpa transaksi gateway)' : 'Belum ada transaksi' }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('TagihanUser.update', $assignment->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group input-group-sm mb-2">
                                                    <select name="status" class="form-select form-select-sm">
                                                        <option value="belum" {{ $assignment->status === 'belum' ? 'selected' : '' }}>Belum</option>
                                                        <option value="sudah" {{ $assignment->status === 'sudah' ? 'selected' : '' }}>Sudah</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-outline-warning">
                                                        <i class="ti ti-refresh"></i>Update
                                                    </button>
                                                </div>
                                                <input type="number" name="payment_id" class="form-control form-control-sm" value="{{ $assignment->payment_id }}" placeholder="Payment ID (opsional)">
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('TagihanUser.delete', $assignment->id) }}" method="POST" onsubmit="return confirm('Hapus assignment ini? Tindakan ini tidak dapat dibatalkan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="ti ti-trash me-1"></i>Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mode = document.getElementById('tagihan_input_mode');
    const selectWrapper = document.getElementById('tagihan_select_wrapper');
    const manualWrapper = document.getElementById('tagihan_manual_wrapper');
    const selectInput = document.getElementById('tagihan_id_select');
    const manualInput = document.getElementById('tagihan_id_manual');

    function toggleTagihanInput() {
        const isManual = mode.value === 'manual';

        selectWrapper.classList.toggle('d-none', isManual);
        manualWrapper.classList.toggle('d-none', !isManual);

        selectInput.disabled = isManual;
        selectInput.required = !isManual;

        manualInput.disabled = !isManual;
        manualInput.required = isManual;
    }

    mode.addEventListener('change', toggleTagihanInput);
    toggleTagihanInput();
});
</script>

@endsection
