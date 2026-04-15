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
            'idPekerjaan': id,
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "DELETE",
            url: "{{ route('Pekerjaan.delete') }}",
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

                    setTimeout("window.location='{{ route('Pekerjaan.index') }}'", 2500);
                }
            }
        });
    });
</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Setujui Permohonan Sewa</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Sewa Aset</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Setujui Permohonan Sewa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Permohonan Sewa</li>
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
                    Daftar Permohonan Sewa
                </div>
                <div class="prism-toggle">
                    <a class="btn btn-primary btn-wave waves-effect waves-light"
                        href="{{ route('PermohonanSewa.create') }}">
                        <i class="ri-add-line align-middle me-1 fw-medium"></i> Tambah Permohonan Sewa
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>Nomor Permohonan</th>
                            <th>Nama Wajib Retribusi/Pemohon</th>
                            <th>Tanggal Permohonan</th>
                            <th>Objek Retribusi</th>
                            <th>Jangka Waktu</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 10px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($permohonanSewa) && count($permohonanSewa) > 0)
                            @foreach ($permohonanSewa as $pS)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="ms-2">
                                                <p class="fw-semibold mb-0 d-flex align-items-center"><a
                                                        href="javascript:void(0);">{{ $pS->nomorSuratPermohonan }}</a></p>
                                                <p class="fs-12 text-muted mb-0">{{ $pS->jenisPermohonan }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            @if($pS->fotoWajibRetribusi)
                                                <span class="avatar avatar-md avatar-square bg-light"><img
                                                        src="{{url('storage/' . $pS->fotoWajibRetribusi)}}" class="w-100 h-100"
                                                        alt="..."></span>
                                            @else
                                                <span class="avatar avatar-md avatar-square bg-light"><img
                                                        src="{{ asset('admin_resources/assets/images/user-general/no_image1.png') }}"
                                                        class="w-100 h-100" alt="..."></span>
                                            @endif
                                            <div class="ms-2">
                                                <p class="fw-semibold mb-0 d-flex align-items-center"><a
                                                        href="javascript:void(0);">{{ $pS->namaWajibRetribusi }}</a></p>
                                                <p class="fs-12 text-muted mb-0">NIK: {{ $pS->nik }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ date('j F Y', strtotime($pS->createAt)) }}</td>
                                    <td>{{ $pS->objekRetribusi }}</td>
                                    <td>{{ $pS->LamaSewa }}</td>
                                    <td>
                                        @if($pS->namaStatus == "Baru")
                                            <span class="badge bg-primary">{{ $pS->namaStatus }}</span>
                                        @elseif($pS->namaStatus == "Disetujui KaSubBid")
                                            <span class="badge bg-secondary">{{ $pS->namaStatus }}</span>
                                        @elseif($pS->namaStatus == "Disetujui KaBid")
                                            <span class="badge bg-info">{{ $pS->namaStatus }}</span>
                                        @elseif($pS->namaStatus == "Disetujui KaBan")
                                            <span class="badge bg-success">{{ $pS->namaStatus }}</span>
                                        @elseif($pS->namaStatus == "Ditolak")
                                            <span class="badge bg-danger">{{ $pS->namaStatus }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fe fe-align-justify"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" style="">
                                                @if($pS->namaStatus == "Baru")
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('PermohonanSewa.approvePermohonanDetail', $pS->idPermohonanSewa) }}"><i
                                                                class="ri-task-line me-2 align-middle d-inline-block"></i>Setujui
                                                            Oleh KaSubBid
                                                        </a>
                                                    </li>
                                                @elseif($pS->namaStatus == "Disetujui KaSubBid")
                                                    <a class="dropdown-item"
                                                        href="{{ route('PermohonanSewa.approvePermohonanDetail', $pS->idPermohonanSewa) }}"><i
                                                            class="ri-task-line me-2 align-middle d-inline-block"></i>Setujui
                                                        Oleh KaBid
                                                    </a>
                                                @elseif($pS->namaStatus == "Disetujui KaBid")
                                                    <a class="dropdown-item"
                                                        href="{{ route('PermohonanSewa.approvePermohonanDetail', $pS->idPermohonanSewa) }}"><i
                                                            class="ri-task-line me-2 align-middle d-inline-block"></i>Setujui
                                                        Oleh Kaban
                                                    </a>
                                                @endif
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

<!-- Start:: Delete Pekerjaan-->
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
<!-- End:: Delete Pekerjaan -->

@endsection