@extends('layouts.admin.template')
@section('content')

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
                                                            class="d-block fs-13 text-muted fw-normal">{{ \Carbon\Carbon::parse($permohonanSewa->tanggalPermohonan)->translatedFormat('d F Y') }}</span>
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
                                                            <span
                                                                class="badge bg-primary">{{ $permohonanSewa->namaStatus }}</span>
                                                        @elseif($permohonanSewa->namaStatus == "Disetujui KaSubBid")
                                                            <span
                                                                class="badge bg-secondary">{{ $permohonanSewa->namaStatus }}</span>
                                                        @elseif($permohonanSewa->namaStatus == "Disetujui KaBid")
                                                            <span class="badge bg-info">{{ $permohonanSewa->namaStatus }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-xl-12 mb-3">
                                                <h6  class="mb-3 fs-14">Dokumen-dokumen Permohonan</h6>
                                                <div class="table-responsive border-top">
                                                    <table class="table text-nowrap table-hover" id="tblDokumen">
                                                        <thead>
                                                            <tr>
                                                                <th class="fs-13">Nama Dokumen Kelengkapan</th>
                                                                <th class="fs-13" width="20px">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (
                                                                    isset($dokumenPermohonan) && count($dokumenPermohonan)
                                                                    > 0
                                                                )
                                                                @foreach ($dokumenPermohonan as $dp)
                                                                    <tr>
                                                                        <td class="text-muted fw-normal fs-13">{{ $dp->dokumenKelengkapan }}</td>
                                                                        <td>
                                                                            @if($dp->namaFileDokumen)
                                                                                <a target="_blank"
                                                                                    href="{{Storage::disk('biznet')->url('/' . $dp->namaFileDokumen)}}"
                                                                                    download="{{ $dp->namaFileDokumen }}"
                                                                                    class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover text-decoration-underline">
                                                                                    <button type="button" class="btn btn-icon btn-outline-primary btn-wave
                                                                                                        btn-sm previewBtn">
                                                                                        <i class="ri-eye-line"></i>
                                                                                    </button>
                                                                                </a>
                                                                            @else
                                                                                <button type="button" class="btn btn-icon btn-outline-danger btn-wave
                                                                                                        btn-sm previewBtn">
                                                                                    <i class="ri-close-large-line"></i>
                                                                                </button>
                                                                            @endif
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection