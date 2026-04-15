@extends('layouts.admin.template')
@section('content')

    <script>
        //-------------------------------------------------------------------------------------------------
        //Ajax Form Detail Data
        //-------------------------------------------------------------------------------------------------
        $(document).on('click', '.detailBtn', function (e) {
            e.preventDefault();

            var tr_id = $(this).val();

            $("#detailModal").modal('show');

            $.ajax({
                method: "GET",
                url: "{{ route('ObjekRetribusi.detailTarif') }}",
                data: {
                    idTarif: tr_id
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

                        var fileExist = response.tarifObjek.fileHasilPenilaian;
                        var fileDokumen = {!! json_encode(Storage::disk('biznet')->url('/documents/tarifObjekRetribusi/')) !!};

                        $('#d_kodeObjek').text(response.tarifObjek.kodeObjekRetribusi);
                        $('#d_namaObjek').text(response.tarifObjek.objekRetribusi);
                        $('#d_noBangunan').text(response.tarifObjek.noBangunan);
                        $('#d_jenisObjek').text(response.tarifObjek.jenisObjekRetribusi);
                        $('#d_lokasiObjek').text(response.tarifObjek.lokasiObjekRetribusi);
                        $('#d_alamatObjek').text(response.tarifObjek.alamatLengkap);
                        $('#d_panjangTanah').text(response.tarifObjek.panjangTanah);
                        $('#d_lebarTanah').text(response.tarifObjek.lebarTanah);
                        $('#d_luasTanah').text(response.tarifObjek.luasTanah);
                        $('#d_panjangBangunan').text(response.tarifObjek.panjangBangunan);
                        $('#d_lebarBangunan').text(response.tarifObjek.lebarBangunan);
                        $('#d_luasBangunan').text(response.tarifObjek.luasBangunan);
                        $('#d_jumlahLantai').text(response.tarifObjek.jumlahLantai);
                        $('#d_kapasitas').text(response.tarifObjek.kapasitas);
                        $('#d_perioditas').text(response.tarifObjek.jenisJangkaWaktu);
                        $('#d_tanggalDinilai').text(response.tarifObjek.tanggalDinilai);
                        $('#d_namaPenilai').text(response.tarifObjek.namaPenilai);
                        $('#d_tarifObjek').text("Rp. " + response.tarifObjek.nominalTarif);
                        $('#d_hargaTanah').text("Rp. " + response.tarifObjek.hargaTanah);
                        $('#d_hargaBangunan').text("Rp. " + response.tarifObjek.hargaBangunan);
                        $('#d_keterangan').text(response.tarifObjek.keterangan);
                        if (fileExist) {
                            $(this).parent('.filePenilaian').remove();
                            $("#filePenilaian").append(
                                '<a href="' + (fileDokumen + response.tarifObjek.fileName) + '" download="' + response.tarifObjek.fileHasilPenilaian + '" class="btn btn-primary label-btn"' +
                                '<i class="ri-download-2-line label-btn-icon me-3"></i><span' +
                                'id="d_fileName">' + response.tarifObjek.fileName + '</span></a>'
                            );
                        } else {
                            $(this).parent('.filePenilaian').remove();
                            $("#filePenilaian").append(
                                '<span class="d-block fs-13 text-muted fw-normal"' +
                                'id="d_fileName">File Penilaian Tarif Tidak Tersedia</span>'
                            );
                        }
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
                'idTarif': id,
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "{{ route('ObjekRetribusi.deleteTarif') }}",
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.status == 400) {
                        $.each(response.errors, function (key, err_value) {
                            $('.toast-delete-error').append(err_value);

                            const primarytoastDeleteError = document.getElementById(
                                'dangerDeleteToast')
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

                        setTimeout("window.location='{{ route('ObjekRetribusi.tarif') }}'", 1500);
                    }
                }
            });
        });
    </script>

    <!-- Page Header -->
    <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h1 class="page-title fw-medium fs-18 mb-2">Tarif Objek Retribusi</h1>
            <div class="">
                <nav>
                    <ol class="breadcrumb breadcrumb-example1 mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Objek Retribusi</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Daftar Tarif Objek Restribusi</li>
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
                        Daftar Tarif Objek Retribusi
                    </div>
                    <div class="prism-toggle">
                        <a class="btn btn-primary btn-wave waves-effect waves-light"
                            href="{{ route('ObjekRetribusi.createTarif') }}">
                            <i class="ri-add-line align-middle me-1 fw-medium"></i> Tambah Tarif Objek Retribusi
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
                        <thead>
                            <tr>
                                <th>Objek Retribusi</th>
                                <th>Nama Objek Retribuusi</th>
                                <th>Perioditas</th>
                                <th>Tarif Objek</th>
                                <th>Harga Tanah</th>
                                <th>Keterangan</th>
                                <th class="text-center" style="width: 10px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($tarifRetribusi) && count($tarifRetribusi) > 0)
                                @foreach ($tarifRetribusi as $tR)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <span class="avatar avatar-md avatar-square bg-light"><img
                                                        src="{{ asset('admin_resources/assets/images/user-general/no_image1.png') }}"
                                                        class="w-100 h-100" alt="..."></span>
                                                <div class="ms-2">
                                                    <p class="fw-semibold mb-0 d-flex align-items-center"><a
                                                            href="javascript:void(0);">{{ $tR->kodeObjekRetribusi }}</a></p>
                                                    <p class="fs-12 text-muted mb-0">NPWRD: {{ $tR->npwrd }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="ms-2">
                                                <p class="fw-semibold mb-0 d-flex align-items-center"><a
                                                        href="javascript:void(0);">{{ $tR->noBangunan }} -
                                                        {{ $tR->objekRetribusi }}</a></p>
                                                <p class="fs-12 text-muted mb-0">{{ $tR->alamatLengkap }}</p>
                                            </div>
                                        </td>
                                        <td>{{ $tR->jenisJangkaWaktu }}</td>
                                        <td>{{ $tR->nominalTarif }}</td>
                                        <td>{{ $tR->hargaTanah }}</td>
                                        <td>{{ $tR->keterangan }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fe fe-align-justify"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end" style="">
                                                    <li>
                                                        <button type="button" value="{{ $tR->idTarifObjekRetribusi }}"
                                                            class="dropdown-item detailBtn">
                                                            <i class="ri-eye-line me-1 align-middle d-inline-block"></i>Detail
                                                        </button>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('ObjekRetribusi.editTarif', $tR->idTarifObjekRetribusi) }}"><i
                                                                class="ri-edit-line me-1 align-middle d-inline-block"></i>Ubah</a>
                                                    </li>
                                                    <li><button type="button" value="{{ $tR->idTarifObjekRetribusi }}"
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

    <!-- Start:: Detail Tarif Objek-->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalXlLabel" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalXlLabel">Detail Tarif Objek Retribusi</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="p-4">
                        <div class="row gx-5">
                            <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                                <div class="card custom-card shadow-none mb-0 border-0">
                                    <div class="card-body p-0">
                                        <div class="row gy-3">
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Kode Objek Retribusi</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_kodeObjek"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Nama Objek Retribusi</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_namaObjek"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Nomor Bangunan</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_noBangunan"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Jenis Objek Retribusi</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_jenisObjek"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Lokasi Objek Retribusi</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_lokasiObjek"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Alamat Objek Retribusi</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_alamatObjek"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Panjang Tanah (m)</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_panjangTanah"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Lebar Tanah (m)</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_lebarTanah"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Luas Tanah (m<sup>2</sup>)</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_luasTanah"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Panjang Bangunan (m)</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_panjangBangunan"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Lebar Bangunan (m)</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_lebarBangunan"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Luas Bangunan (m<sup>2</sup>)</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_luasBangunan"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Jumlah Lantai</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_jumlahLantai"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Kapasitas (orang)</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_kapasitas"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                                <div class="card custom-card shadow-none mb-0 border-0">
                                    <div class="card-body p-0">
                                        <div class="row gy-3">
                                            <div class="col-xl-6">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Perioditas</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_perioditas"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Tanggal Dinilai</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_tanggalDinilai"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Nama Penilai</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_namaPenilai"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Tarif Objek Retribusi (per meter<sup>2</sup>)
                                                        </h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_tarifObjek"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Harga Tanah
                                                        </h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_hargaTanah"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Harga Bangunan
                                                        </h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_hargaBangunan"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Keterangan</h6>
                                                        <span class="d-block fs-13 text-muted fw-normal"
                                                            id="d_keterangan"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Dokumen Penilaian Tarif Objek Retribusi</h6>
                                                        <div id="filePenilaian" class="filePenilaian">

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
    </div>
    <!-- End::  Detail Tarif Objek -->

    <!-- Start:: Delete Tarif Objek-->
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
    <!-- End:: Delete Tarif Objek -->

@endsection