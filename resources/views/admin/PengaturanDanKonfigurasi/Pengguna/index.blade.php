@extends('layouts.admin.template')
@section('content')

<script>
    //-------------------------------------------------------------------------------------------------
    //Ajax Form Detail Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.detailBtn', function (e) {
        e.preventDefault();

        var usr_id = $(this).val();

        $("#detailModal").modal('show');

        $.ajax({
            method: "GET",
            url: "{{ route('User.detail') }}",
            data: {
                id: usr_id
            },
            success: function (response) {
                //console.log(response);
                if (response.status == 404) {
                    new Noty({
                        text: response.message,
                        type: 'warning',
                        modal: true
                    }).show();
                } else {
                    var fotoPath = response.user.fotoUser;
                    var fileFoto = {!! json_encode(Storage::disk('biznet')->url('/images' )) !!};

                    var no_photo = {!! json_encode(url('admin_resources/assets/images/user-general/no_photo_profile_color.png')) !!};
                    
                    if (response.user.fotoUser) {
                        $('#d_fotoUser').attr("src", fileFoto + '/' + response.user.fotoUser);
                    } else {
                        $('#d_fotoUser').attr("src", no_photo);
                    }
                    
                    $('#d_namaLengkap').text(response.user.namaLengkap);
                    $('#d_jenisUser').text(response.user.jenisUser);
                    $('#d_username').text(response.user.username);
                    $('#d_password').text(response.user.password);
                    $('#d_role').text(response.user.roleName);
                    $('#d_email').text(response.user.email);
                }
            }
        });
    });

    //-------------------------------------------------------------------------------------------------
    //Ajax Form Delete Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.deleteBtn', function (e) {
        var st_id = $(this).val();

        $('#deleteModal').modal('show');
        $('#deleting_id').val(st_id);
    });

    //-------------------------------------------------------------------------------------------------
    //Ajax Delete Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.delete_data', function (e) {
        e.preventDefault();

        var id = $('#deleting_id').val();

        var data = {
            'idUser': id,
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "DELETE",
            url: "{{ route('User.delete') }}",
            data: data,
            dataType: "json",
            success: function (response) {
                if (response.status == 400) {
                    $.each(response.errors, function (key, err_value) {
                        $('.toast-delete-error').append(err_value);

                        const primarytoastDeleteError = document.getElementById('dangerDeleteToast')
                        const toast = new bootstrap.Toast(primarytoastDeleteError)
                        toast.show()
                    });
                    $('.delete_data').text('Ya');
                } else {
                    $('#deleteModal').modal('hide');
                    $('.toast-delete-success').append(response.message);

                    const primarytoastDeleteSuccess = document.getElementById('primaryDeleteToast')
                    const toast = new bootstrap.Toast(primarytoastDeleteSuccess)
                    toast.show()

                    setTimeout("window.location='{{ route('User.index') }}'", 1200);
                }
            }
        });
    });
</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Pengguna/User Aplikasi</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pengaturan dan Konfigurasi</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Manajemen Pengguna</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Pengguna/User</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start::row-1 -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Daftar Pengguns/User
                </div>
                <div class="prism-toggle">
                    <a class="btn btn-primary btn-wave waves-effect waves-light"
                        href="{{ route('User.create') }}">
                        <i class="ri-add-line align-middle me-1 fw-medium"></i> Tambah Pengguna/Sser
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="responsivemodal-DataTable" class="table table-bordered text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>Nama Lengkap User</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Email</th>
                            <th class="text-center" style="width: 10px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($users) && count($users) > 0)
                            @foreach ($users as $uS)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            @if($uS->fotoUser)
                                                <span class="avatar avatar-md avatar-square bg-light"><img
                                                        src="{{Storage::disk('biznet')->url('images/' . $uS->fotoUser)}}"
                                                        class="w-100 h-100" alt="..."></span>
                                            @else
                                                <span class="avatar avatar-md avatar-square bg-light"><img
                                                        src="{{ asset('admin_resources/assets/images/user-general/no_picture.png') }}"
                                                        class="w-100 h-100" alt="..."></span>
                                            @endif
                                            <div class="ms-2">
                                                <p class="fw-semibold mb-0 d-flex align-items-center">
                                                    {{ $uS->namaLengkap }}
                                                </p>
                                                <p class="fs-12 text-muted mb-0">Role: {{ $uS->roleName }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $uS->username }}</td>
                                    <td>{{ $uS->password }}</td>
                                    <td>{{ $uS->email }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fe fe-align-justify"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                                <li>
                                                    <button type="button" value="{{ $uS->id }}"
                                                        class="dropdown-item detailBtn">
                                                        <i class="ri-eye-line me-1 align-middle d-inline-block"></i>Detail
                                                    </button>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('User.edit', $uS->id) }}"><i
                                                            class="ri-edit-line me-1 align-middle d-inline-block"></i>Ubah</a>
                                                </li>
                                                <li><button type="button" value="{{ $uS->id }}"
                                                        class="dropdown-item deleteBtn">
                                                        <i
                                                            class="ri-delete-bin-line me-1 align-middle d-inline-block"></i>Hapus</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--End::row-1 -->

<!-- Start:: Detail User -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalXlLabel" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalXlLabel">Detail Pengguna/User</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="p-4">
                    <div class="row gx-5">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-6">
                            <div class="card custom-card shadow-none mb-0 border-0">
                                <div class="card-body p-0">
                                    <div class="row gy-3">
                                        <div class="col-xl-12">
                                            <div class="d-flex align-items-center flex-wrap gap-3">
                                                <div>
                                                    <span class="avatar avatar-xxl avatar-rounded p-1 bg-light">
                                                        <img src="" alt="" id="d_fotoUser">
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="fw-medium d-block mb-2" id="d_namaLengkap"></span>
                                                    <span class="d-block fs-12 text-muted" id="d_jenisUser"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Username</h6>
                                                    <span class="d-block fs-13 text-muted fw-normal"
                                                        id="d_username"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-12">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Password</h6>
                                                    <span class="d-block fs-13 text-muted fw-normal"
                                                        id="d_password"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Nama Role</h6>
                                                    <span class="d-block fs-13 text-muted fw-normal"
                                                        id="d_role"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Email</h6>
                                                    <span class="d-block fs-13 text-muted fw-normal"
                                                        id="d_email"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End::  Detail User -->

<!-- Start:: Delete User -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Hapus Data</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteJenisStatusForm">
                @csrf
                <div class="modal-body">
                    <div class="text-center px-5 pb-0 svg-danger">
                        <svg class="custom-alert-icon" xmlns="http://www.w3.org/2000/svg" height="3.5rem"
                            viewBox="0 0 24 24" width="3.5rem" fill="#000000">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM12 17.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zm1-4.3h-2V7h2v6z" />
                        </svg>

                        <h5>Anda yakin untuk menghapus data?</h5>
                    </div>
                    <input type="hidden" id="deleting_id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-danger delete_data">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End:: Delete User -->

@endsection