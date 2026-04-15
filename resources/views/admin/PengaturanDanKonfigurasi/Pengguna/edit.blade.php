@extends('layouts.admin.template')
@section('content')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        /* single select with placeholder */
        $(".jenisUser").select2({
            placeholder: "Pilih Jenis User",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
        });
        $(".namaLengkap").select2({
            placeholder: "Pilih Nama Lengkap User",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
        });
        $(".userRole").select2({
            placeholder: "Pilih User Role",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
        });
    });
</script>


<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Pengguna/User</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pengatusan & Konfigurasi</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Manajemen Pengguna</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengguna/User</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
<div class="row">
    <div class="col-xl-12">
        <form class="row g-3 needs-validation" action="{{ route('User.update', $user->id) }}" method="post" novalidate>
            {{ csrf_field() }}
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Tambah Pengguna/User
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Jenis User</label>
                        <input type="hidden" name="idJenisUser" value="{{ $user->idJenisUser }}">
                        <input type="text" class="form-control" id="jenisUser" value="{{ $user->jenisUser }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Nama Lengkap User</label>
                        <input type="hidden" name="idPersonal" value="{{ $user->idPersonal }}">
                        <input type="text" class="form-control" id="idPersonal" value="{{ $user->namaLengkap }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">User Role</label>
                        <select class="userRole form-control" name="userRole" required>
                            <option></option>
                            @foreach ($userRole as $uR)
                                <option value="{{ $uR->id }}" {{ $uR->id === $user->roleId ? 'selected' : '' }}>{{ $uR->roleName }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            User
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Masukkan Username" value="{{ $user->username }}"
                            name="username" required>
                        <div class="invalid-feedback">
                            Username Tidak Boleh Kosong
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Masukkan Password"
                            name="password">
                    </div>
                    <div class="mb-3">
                        <label for="wmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" value="{{ $user->email }}">
                        <div class="invalid-feedback">
                            Format Email salah!
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-danger m-1" type="reset">Batal<i
                            class="bi bi-x-square ms-2 align-middle d-inline-block"></i></button>
                    <button class="btn btn-primary m-1" type="submit">Simpan <i
                            class="bi bi-floppy ms-2 ms-1 align-middle d-inline-block"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection