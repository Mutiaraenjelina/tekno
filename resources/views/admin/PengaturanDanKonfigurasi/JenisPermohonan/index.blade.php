@extends('layouts.admin.template')
@section('content')

<script>
    //-------------------------------------------------------------------------------------------------
    //Ajax Form Detail Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.detailBtn', function (e) {
        e.preventDefault();

        var st_id = $(this).val();

        $("#detailModal").modal('show');

        $.ajax({
            method: "GET",
            url: "{{ route('JenisPermohonan.detail') }}",
            data: {
                id: st_id
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
                    //console.log(response.fieldEducation.nama_bidang_pendidikan)
                    $('#d_parentId').text(response.PermohonanType.parentId);
                    $('#d_jenis_permohonan').text(response.PermohonanType.jenisPermohonan);
                    $('#d_keterangan').text(response.PermohonanType.keterangan);
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
            'idJenisPermohonan': id,
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "DELETE",
            url: "{{ route('JenisPermohonan.delete') }}",
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

                    setTimeout("window.location='{{ route('JenisPermohonan.index') }}'", 2500);
                }
            }
        });
    });
</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Jenis Permohonan</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pengaturan & Konfigurasi</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Penyewaan Aset</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jenis Permohonan</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Daftar Jenis Permohonan
                </div>
                <div class="prism-toggle">
                    <a class="btn btn-primary btn-wave waves-effect waves-light" href="{{ route('JenisPermohonan.create') }}">
                        <i class="ri-add-line align-middle me-1 fw-medium"></i> Tambah Jenis Permohonan
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>ParentId</th>
                            <th>Jenis Permohonan</th>
                            <th>Keterangan</th>
                            <th class="text-center" style="width: 10px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($PermohonanType) && count($PermohonanType) > 0)
                            @foreach ($PermohonanType as $st)
                                <tr>
                                    <td>{{ $st->parentId }}</td>
                                    <td>{{ $st->jenisPermohonan }}</td>
                                    <td>{{ $st->keterangan }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fe fe-align-justify"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button type="button" value="{{ $st->idJenisPermohonan }}" class="dropdown-item detailBtn">
                                                        <i class="ri-eye-line me-1 align-middle d-inline-block"></i>Detail
                                                    </button>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ route('JenisPermohonan.edit', $st->idJenisPermohonan) }}">
                                                    <i class="ri-edit-line me-1 align-middle d-inline-block"></i>Ubah</a>
                                                </li>
                                                <li><button type="button" value="{{ $st->idJenisPermohonan }}" class="dropdown-item deleteBtn">
                                                    <i class="ri-delete-bin-line me-1 align-middle d-inline-block"></i>Hapus</button>
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

<!-- Start:: Detail Jenis Jangka Waktu -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Detail Jenis Permohonan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4">
                <div class="d-flex gap-3">
                    <div class="flex-fill">
                        <h6 class="mb-1 fs-13">ParentId</h6>
                        <span class="d-block fs-13 text-muted fw-normal" id="d_parentId"></span>
                    </div>
                </div>
            </div>
            <div class="modal-body px-4">
                <div class="d-flex gap-3">
                    <div class="flex-fill">
                        <h6 class="mb-1 fs-13">Jenis Permohonan</h6>
                        <span class="d-block fs-13 text-muted fw-normal" id="d_jenis_permohonan"></span>
                    </div>
                </div>
            </div>
            <div class="modal-body px-4">
                <div class="d-flex gap-3">
                    <div class="flex-fill">
                        <h6 class="mb-1 fs-13">Keterangan</h6>
                        <span class="d-block fs-13 text-muted fw-normal" id="d_keterangan"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- End:: Detail Jenis Jangka Waktu -->

<!-- Start:: Delete Jenis Jangka Waktu-->
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

<!-- End:: Delete Jenis Jangka Waktu-->
@endsection
