@extends('layouts.admin.template')
@section('content')
<script>
    //-------------------------------------------------------------------------------------------------
    //Ajax Form Approve Permohonan
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.approveBtn', function (e) {
        e.preventDefault();

        var id = $(this).val();
        var namaStatus = {!! json_encode($permohonanSewa->namaStatus) !!};

        var data = {
            'idPermohonan': id,
            'namaStatus': namaStatus,
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('PermohonanSewa.storeApprovePermohonan') }}",
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
                } else {
                    $('.toast-delete-success').append(response.message);

                    const primarytoastDeleteSuccess = document.getElementById('primaryDeleteToast')
                    const toast = new bootstrap.Toast(primarytoastDeleteSuccess)
                    toast.show()

                    setTimeout("window.location='{{ route('PermohonanSewa.approvePermohonanList') }}'", 1000);
                }
            }
        });
    });
</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Permohonan Sewa</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Sewa Aset</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Permohonan Aset</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Permohonan Aset</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Detail Permohonan Sewa
                </div>
            </div>
            <div class="card-body detail-objek-retribusi p-0">
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
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->kodeObjekRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Jenis Objek Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->jenisObjekRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Lokasi Objek Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->lokasiObjekRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Nama Objek Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->objekRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-8">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Alamat Objek Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->alamatObjekRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Panjang Tanah (m)</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->panjangTanah }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Lebar Tanah (m)</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->lebarTanah }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Luas Tanah (m<sup>2</sup>)</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->luasTanah }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Panjang Bangunan (m)</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->panjangBangunan }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Lebar Bangunan (m)</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->lebarBangunan }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Luas Bangunan (m<sup>2</sup>)</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->luasBangunan }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Jumlah Lantai</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->jumlahLantai }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-8">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Kapasistas</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->kapasitas }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Jenis Wajib Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->namaJenisWajibRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-8">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">NIK Wajib Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->nik }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Nama Wajib Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->namaWajibRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-8">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Alamat Wajib Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->alamatWajibRetribusi }}</span>
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
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Nomor Surat Permohonan</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->nomorSuratPermohonan }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Jenis Permohonan</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->jenisPermohonan }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Tanggal Permohonan</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->luasBangunan }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Jangka Waktu</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->jenisJangkaWaktu }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Peruntukan Sewa</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->peruntukanSewa }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Lama Sewa</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->lamaSewa . ' ' . $permohonanSewa->namaSatuan}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-8">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Catatan</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $permohonanSewa->catatan }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Status Permohonan</h6>
                                                @if($permohonanSewa->namaStatus == "Baru")
                                                    <span class="badge bg-primary">{{ $permohonanSewa->namaStatus }}</span>
                                                @elseif($permohonanSewa->namaStatus == "Disetujui KaSubBid")
                                                    <span class="badge bg-secondary">{{ $permohonanSewa->namaStatus }}</span>
                                                @elseif($permohonanSewa->namaStatus == "Disetujui KaBid")
                                                    <span class="badge bg-info">{{ $permohonanSewa->namaStatus }}</span>
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-center">
                    <button class="btn btn-primary m-1 approveBtn" type="button" value="{{ $permohonanSewa->idPermohonanSewa }}">Setujui <i
                            class="bi bi-check-square ms-2 ms-1 align-middle d-inline-block"></i></button>
                    <button class="btn btn-danger m-1" type="button" value="{{ $permohonanSewa->idPermohonanSewa }}">Tolak<i
                            class="bi bi-x-square ms-2 align-middle d-inline-block"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection