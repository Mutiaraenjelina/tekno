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

<script>
    (function () {
        "use strict"

        let checkAll = document.querySelector('.check-all');
        checkAll.addEventListener('click', checkAllFn)

        function checkAllFn() {
            if (checkAll.checked) {
                document.querySelectorAll('.task-checkbox input').forEach(function (e) {
                    e.closest('.task-list').classList.add('selected');
                    e.checked = true;
                });
            }
            else {
                document.querySelectorAll('.task-checkbox input').forEach(function (e) {
                    e.closest('.task-list').classList.remove('selected');
                    e.checked = false;
                });
            }
        }

    })();
</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Tagihan Sewa</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Tagihan Dan Pembayaran</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Tagihan Sewa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Tagihan Sewa</li>
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
                    Detail Tagihan Sewa
                </div>
            </div>
            <div class="card-body">

                <div class="row gy-3">
                        <div class="col-xl-6">
                            <div class="d-flex gap-3">
                                <div class="flex-fill">
                                    <h6 class="mb-1 fs-13">Nomor Perjanjian</h6>
                                    <span class="d-block fs-13 text-muted fw-normal">
                                        {{ $headTagihanDetail->nomorSuratPerjanjian }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="d-flex gap-3">
                                <div class="flex-fill">
                                    <h6 class="mb-1 fs-13">Tanggal Perjanjian</h6>
                                    <span class="d-block fs-13 text-muted fw-normal">
                                        {{ \Carbon\Carbon::parse($headTagihanDetail->tanggalDisahkan)->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="d-flex gap-3">
                                <div class="flex-fill">
                                    <h6 class="mb-1 fs-13">Jangka Waktu</h6>
                                    <span class="d-block fs-13 text-muted fw-normal">
                                        {{ $headTagihanDetail->durasiSewa }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="d-flex gap-3">
                                <div class="flex-fill">
                                    <h6 class="mb-1 fs-13">Pembayaran Per Tahun</h6>
                                    <span class="d-block fs-13 text-muted fw-normal">
                                        {{ $headTagihanDetail->jumlahPembayaran }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="d-flex gap-3">
                                <div class="flex-fill">
                                    <h6 class="mb-1 fs-13">Wajib Retribusi</h6>
                                    <span class="d-block fs-13 text-muted fw-normal">
                                        {{ $headTagihanDetail->npwrd }}
                                    </span>
                                    <span class="d-block fs-13 text-muted fw-normal">
                                        {{ $headTagihanDetail->namaWajibRetribusi }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="d-flex gap-3">
                                <div class="flex-fill">
                                    <h6 class="mb-1 fs-13">Objek Retribusi</h6>
                                    <span class="d-block fs-13 text-muted fw-normal">
                                        {{ $headTagihanDetail->kodeObjekRetribusi }} /
                                        {{ $headTagihanDetail->objekRetribusi }}
                                    </span>
                                    <span class="d-block fs-13 text-muted fw-normal">
                                        {{ $headTagihanDetail->alamatLengkap }}
                                    </span>
                                </div>
                            </div>
                        </div>
                </div>
                <br><br>
                <div class="table-responsive border-top">
                    <table class="table text-nowrap table-hover">
                        <thead>
                            <tr>
                                <!--<th>
                                    <input class="form-check-input check-all" type="checkbox" id="all-tasks" value=""
                                        aria-label="..."> Pilih
                                </th>-->
                                <th scope="col">#</th>
                                <th scope="col">Nomor Tagihan</th>
                                <th scope="col">Jatuh Tempo</th>
                                <th scope="col">Jumlah Tagihan</th>
                                <th scope="col">Jumlah Denda</th>
                                <th scope="col">Total Tagihan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($tagihanDetail) && count($tagihanDetail) > 0)
                                @foreach ($tagihanDetail as $indexKey => $tD)
                                    <tr class="task-list">
                                        <!--<td class="task-checkbox">
                                            @if($tD->idStatus == 10)
                                                    <input class="form-check-input" type="checkbox" value="{{ $tD->idTagihanSewa }}"
                                                        aria-label="Pilih" name="idTagihan[]" disabled>
                                                </td>
                                            @elseif($tD->idStatus == 9)
                                                <input class="form-check-input" type="checkbox" value="{{ $tD->idTagihanSewa }}"
                                                    aria-label="..." name="idTagihan[]"></td>
                                            @endif
                                        </td>-->

                                        <td>
                                            <span class="fw-medium">{{ ++$indexKey }}/{{ count($tagihanDetail) }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-medium">{{ $tD->nomorTagihan }}</span>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($tD->tanggalJatuhTempo)->translatedFormat('d F Y') }}
                                        </td>
                                        <td>
                                            {{ $tD->jumlahTagihan }}
                                        </td>
                                        <td>
                                            {{ $tD->jumlahDenda }}
                                        </td>
                                        <td>
                                            {{ $tD->totalTagihan }}
                                        </td>
                                        <td>
                                            @if($tD->idStatus == 10)
                                                <span class="fw-medium text-success">{{ $tD->namaStatus }}</span>
                                            @elseif($tD->idStatus == 9)
                                                <span class="fw-medium text-warning">{{ $tD->namaStatus }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($tD->idStatus == 10)
                                                <button class="btn btn-success btn-sm m-1">Detail<i class="ri-eye-line ms-1 ms-1 align-middle d-inline-block"></i></button>
                                            @elseif($tD->idStatus == 9)
                                            <form method="POST" action="{{ route('Tagihan.singleCheckout') }}">
                                            {{ csrf_field() }}
                                                    <input type="hidden" name="idPerjanjian" value="{{ $headTagihanDetail->idPerjanjianSewa }}">
                                                    <input type="hidden" name="idTagihan" value="{{ $tD->idTagihanSewa }}">
                                                    <button class="btn btn-primary btn-sm m-1" type="submit">Bayar<i
                                                    class="ri-file-check-line ms-2 ms-1 align-middle d-inline-block"></i></button>                         
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
               <!-- <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">
                    <button class="btn btn-danger m-1" type="reset">Batal<i
                            class="bi bi-x-square ms-2 align-middle d-inline-block"></i></button>
                    <button class="btn btn-primary m-1" type="submit">Bayar <i
                            class="bi bi-floppy ms-2 ms-1 align-middle d-inline-block"></i></button>
                </div>-->
            </div>
        </div>
    </div>
</div>
<!--End::row-1 -->

@endsection