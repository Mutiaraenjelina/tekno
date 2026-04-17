@extends('layouts.admin.template')
@section('content')

<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Profil Admin</h1>
        <nav>
            <ol class="breadcrumb breadcrumb-example1 mb-0">
                <li class="breadcrumb-item"><a href="{{ route('Dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profil Admin</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-8">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <div class="card-title mb-0">Informasi Akun</div>
            </div>
            <div class="card-body">
                <form action="{{ route('Admin.profile.update') }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label class="form-label fw-medium">Username</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" placeholder="opsional">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium">Role</label>
                        <input type="text" class="form-control" value="{{ $user->roleName }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium">ID User</label>
                        <input type="text" class="form-control" value="{{ $user->id }}" disabled>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i>Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card custom-card border-0 shadow-sm mt-3">
            <div class="card-header bg-light border-0">
                <div class="card-title mb-0">Ubah Password</div>
            </div>
            <div class="card-body">
                <form action="{{ route('Admin.profile.password') }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-md-4">
                        <label class="form-label fw-medium">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-medium">Password Baru</label>
                        <input type="password" name="new_password" class="form-control" required minlength="8">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-medium">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required minlength="8">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-lock me-1"></i>Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card custom-card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Ringkasan Akun</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span>Status</span>
                        <span class="badge bg-success">Aktif</span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span>Username</span>
                        <span>{{ $user->username }}</span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span>Role</span>
                        <span>{{ $user->roleName }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
