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
            url: "{{ route('Pekerjaan.detail') }}",
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
                    $('#d_nama_pekerjaan').text(response.pekerjaan.namaPekerjaan);
                    $('#d_keterangan').text(response.pekerjaan.keterangan);
                }
            }
        });
    });

    //-------------------------------------------------------------------------------------------------
    //Ajax Form Delete Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.deleteBtn', function (e) {
        var or_id = $(this).val();

        $('#deleteModal').modal('show');
        $('#deleting_id').val(or_id);
    });

    //-------------------------------------------------------------------------------------------------
    //Ajax Delete Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.delete_data', function (e) {
        e.preventDefault();

        var id = $('#deleting_id').val();

        var data = {
            'idObjekRetribusi': id,
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "DELETE",
            url: "{{ route('ObjekRetribusi.delete') }}",
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

                    setTimeout("window.location='{{ route('ObjekRetribusi.index') }}'", 1200);
                }
            }
        });
    });
</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Objek Retribusi</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Objek Retribusi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Objek Restribusi</li>
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
                    Daftar Objek Retribusi
                </div>
            </div>
            <div class="card-body">
                <table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>Objek Retribusi</th>
                            <th>Nama Objek Retribusi</th>
                            <th>Jenis Objek Retribusi</th>
                            <th>No. Bangunan</th>
                            <th>Lokasi Objek Retribusi</th>
                            <th class="text-center" style="width: 10px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($objekRetribusi) && count($objekRetribusi) > 0)
                            @foreach ($objekRetribusi as $oR)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md avatar-square bg-light"><img
                                                    src="{{ asset('admin_resources/assets/images/user-general/no_image1.png') }}"
                                                    class="w-100 h-100" alt="..."></span>
                                            <div class="ms-2">
                                                <p class="fw-semibold mb-0 d-flex align-items-center"><a
                                                        href="javascript:void(0);">{{ $oR->kodeObjekRetribusi }}</a></p>
                                                <p class="fs-12 text-muted mb-0">NPWRD: {{ $oR->npwrd }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                    <div class="d-flex">
                                            <div class="ms-2">
                                                <p class="fw-semibold mb-0 d-flex align-items-center"><a
                                                        href="javascript:void(0);">{{ $oR->objekRetribusi }}</a></p>
                                                <p class="fs-12 text-muted mb-0">{{ $oR->alamatLengkap }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $oR->jenisObjekRetribusi }}</td>
                                    <td>{{ $oR->noBangunan }}</td>
                                    <td>{{ $oR->lokasiObjekRetribusi }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fe fe-align-justify"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('WajibRetribusi.objekRetribusiDetail', $oR->idObjekRetribusi) }}"><i
                                                            class="ri-eye-line me-1 align-middle d-inline-block"></i>Detail</a>
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


@endsection