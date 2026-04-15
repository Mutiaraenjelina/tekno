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

        //saat pilihan jenis user di pilih, maka akan mengambil data nama lengkap user menggunakan ajax
        $('#jenisUser').on('change', function () {
            var id = $(this).val();

            if (id) {
                var data = {
                    'idJenisUser': id,
                }

                $.ajax({
                    url: "{{ route('DropdownLokasi.namaLengkapUser') }}",
                    type: "GET",
                    data: data,
                    dataType: "json",
                    delay: 250,
                    success: function (data) {
                        if (data) {
                            $('#namaLengkap').empty();
                            $('#namaLengkap').prop('disabled', false);
                            $('#namaLengkap').append('<option>Pilih Nama Lengkap User</option>');
                            $.each(data, function (key, jenisUser) {
                                $('#namaLengkap').append('<option value="' + jenisUser.idPersonal + '">' + jenisUser.namaLengkap + '</option>');
                            });
                        } else {
                            $('#namaLengkap').empty();
                        }
                    }
                });
            } else {
                $('#namaLengkap').empty();
            }
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
        <form class="row g-3 needs-validation" action="{{ route('User.store') }}" method="post" novalidate>
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
                        <select class="jenisUser form-control" name="idJenisUser" id="jenisUser" required>
                            <option></option>
                            @foreach ($userType as $uT)
                                <option value="{{ $uT->idJenisUser }}">{{ $uT->jenisUser }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Jenis User Tidak Boleh Kosong
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Nama Lengkap User</label>
                        <select class="namaLengkap form-control" name="idPersonal" id="namaLengkap" required>
                            <option></option>
                        </select>
                        <div class="invalid-feedback">
                            Nama Lengkap User Tidak Boleh Kosong
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">User Role</label>
                        <select class="userRole form-control" name="userRole" required>
                            <option></option>
                            @foreach ($userRole as $uR)
                                <option value="{{ $uR->id }}">{{ $uR->roleName }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            User Role Tidak Boleh Kosong
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Masukkan Username"
                            name="username" required>
                        <div class="invalid-feedback">
                            Username Tidak Boleh Kosong
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Masukkan Password"
                            name="password" required>
                        <div class="invalid-feedback">
                            Password Tidak Boleh Kosong
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="wmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email">
                        <div class="invalid-feedback">
                            Format email salah!
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