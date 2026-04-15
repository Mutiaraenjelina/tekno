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
            url: "{{ route('PeruntukanSewa.detail') }}",
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
                    $('#d_jenis_kegiatan').text(response.peruntukanSewa.jenisKegiatan);
                    $('#d_peruntukan_sewa').text(response.peruntukanSewa.peruntukanSewa);
                    $('#d_keterangan').text(response.peruntukanSewa.keterangan);
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
            'idperuntukanSewa': id,
        }

        //console.log(data);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "DELETE",
            url: "{{ route('PeruntukanSewa.delete') }}",
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

                    setTimeout("window.location='{{ route('PeruntukanSewa.index') }}'", 1200);
                }
            }
        });
    });

</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Peruntukan Sewa</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pengatusan & Konfigurasi</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Penyewaan Aset</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Peruntukan Sewa</li>
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
                    Daftar Peruntukan Sewa
                </div>
                <div class="prism-toggle">
                    <a class="btn btn-primary btn-wave waves-effect waves-light" href="{{ route('PeruntukanSewa.create') }}">
                        <i class="ri-add-line align-middle me-1 fw-medium"></i> Tambah Peruntukan Sewa
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>Jenis Kegiatan</th>
                            <th>Peruntukan Sewa</th>
                            <th>Keterangan</th>
                            <th class="text-center" style="width: 10px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($peruntukanSewa) && count($peruntukanSewa) > 0)
                            @foreach ($peruntukanSewa as $sts)
                                <tr>
                                    <td>{{ $sts->jenisKegiatan }}</td>
                                    <td>{{ $sts->peruntukanSewa }}</td>
                                    <td>{{ $sts->keterangan }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fe fe-align-justify"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                                <li>
                                                    <button type="button" value="{{ $sts->idperuntukanSewa }}"
                                                        class="dropdown-item detailBtn">
                                                        <i class="ri-eye-line me-1 align-middle d-inline-block"></i>Detail
                                                    </button>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('PeruntukanSewa.edit', $sts->idperuntukanSewa) }}"><i
                                                            class="ri-edit-line me-1 align-middle d-inline-block"></i>Ubah</a>
                                                </li>
                                                <li><button type="button" value="{{ $sts->idperuntukanSewa }}"
                                                        class="dropdown-item deleteBtn">
                                                        <i class="ri-delete-bin-line me-1 align-middle d-inline-block"></i>Hapus</a>
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

<!-- Start:: Detail Status-->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Detail Peruntukan Sewa</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4">
                <div class="d-flex gap-3">
                    <div class="flex-fill">
                        <h6 class="mb-1 fs-13">Jenis Kegiatan</h6>
                        <span class="d-block fs-13 text-muted fw-normal" id="d_jenis_kegiatan"></span>
                    </div>
                </div>
            </div>
            <div class="modal-body px-4">
                <div class="d-flex gap-3">
                    <div class="flex-fill">
                        <h6 class="mb-1 fs-13">Peruntukan Sewa</h6>
                        <span class="d-block fs-13 text-muted fw-normal" id="d_peruntukan_sewa"></span>
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
<!-- End:: Detail Status -->

<!-- Start:: Delete Status-->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Hapus Data</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteStatusForm">
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
<!-- End:: Delete Status -->

@endsection
