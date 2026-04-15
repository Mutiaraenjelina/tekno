@extends('layouts.admin.template')
@section('content')

    <!-- Page Header -->
    <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h1 class="page-title fw-medium fs-18 mb-2">Perjanjian Sewa</h1>
            <div class="">
                <nav>
                    <ol class="breadcrumb breadcrumb-example1 mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Sewa Aset</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Perjanjian Sewa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Perjanjian</li>
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
                        Detail Perjanjian Sewa
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
                                                        <h6 class="mb-1 fs-13">Nomor Surat Permohonan</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->nomorSuratPermohonan }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Jenis Permohonan</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->jenisPermohonan }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Tanggal Permohonan</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ \Carbon\Carbon::parse($perjanjianSewa->tanggalPermohonan)->translatedFormat('d F Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">NPWRD</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->npwrd }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Kode Objek Retribusi </h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->kodeObjekRetribusi }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Lokasi Objek Retribusi</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->lokasiObjekRetribusi }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Nama Objek Retribusi</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->objekRetribusi }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Alamat Objek Retribusi</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->alamatObjekRetribusi }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Panjang Tanah (m)</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->panjangTanah }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Lebar Tanah (m)</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->lebarTanah }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Luas Tanah (m<sup>2</sup>)</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->luasTanah }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Panjang Bangunan (m)</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->panjangBangunan }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Lebar Bangunan (m)</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->lebarBangunan }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Luas Bangunan (m<sup>2</sup>)</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->luasBangunan }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Jumlah Lantai</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->jumlahLantai }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Kapasistas</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->kapasitas }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">NIK Wajib Retribusi</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->nik }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Nama Wajib Retribusi</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->namaWajibRetribusi }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Pekerjaan Wajib Retribusi</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->namaPekerjaan }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Alamat Wajib Retribusi</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->alamatWajibRetribusi }}</span>
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
                                                        <h6 class="mb-1 fs-13">Nomor Surat Perjanjian</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->nomorSuratPerjanjian }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Tanggal Disahkan</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ \Carbon\Carbon::parse($perjanjianSewa->tanggalDisahkan)->translatedFormat('d F Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Peruntukan Sewa</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->peruntukanSewa }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Lama Sewa</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->lamaSewa . ' ' . $perjanjianSewa->namaSatuan}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Tanggal Awal Perjanjian</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ \Carbon\Carbon::parse($perjanjianSewa->tanggalAwalBerlaku)->translatedFormat('d F Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Tanggal Akhir Perjanjian</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ \Carbon\Carbon::parse($perjanjianSewa->tanggalAkhirBerlaku)->translatedFormat('d F Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Disahkan Oleh</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->namaPegawai }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Jabatan</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->namaJabatanBidang }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Status Perjanjian</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->namaStatus }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill">
                                                        <h6 class="mb-1 fs-13">Keterangan</h6>
                                                        <span
                                                            class="d-block fs-13 text-muted fw-normal">{{ $perjanjianSewa->keterangan }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 border-top">
                                                <div class="d-flex gap-3">
                                                    <div class="flex-fill"><br>
                                                        <h6 class="mb-1 fs-13">File Surat Perjanjian</h6>
                                                        @if($perjanjianSewa->fileSuratPerjanjian)
                                                            <a target="_blank"
                                                                href="{{Storage::disk('biznet')->url('/' . $perjanjianSewa->fileSuratPerjanjian)}}"
                                                                download="{{ $perjanjianSewa->fileSuratPerjanjian }}"
                                                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover text-decoration-underline">
                                                                <i class="ri-download-2-line me-2"></i>Download {{ $perjanjianSewa->fileSuratPerjanjian }}
                                                            </a>
                                                        @else
                                                            <span class="d-block fs-13 text-muted fw-normal">File Gambar Denah
                                                                Tanah Tidak Tersedia.
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-8" style="margin-top: 20px;">
                            <div class="px-4 py-3 border-top">
                            <div class="d-sm-flex">
                                <h6>Saksi-saksi Perjanjian</h6>s
                            </div>
                            <div class="table-responsive">
                                <table class="table text-nowrap table-hover" id="tblSaksi">
                                    <thead>
                                        <tr>
                                            <th class="mb-1 fs-13">NIP</th>
                                            <th class="mb-1 fs-13">Nama Saksi (Sesuai KTP)</th>
                                            <th class="mb-1 fs-13">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($saksiPerjanjian) && count($saksiPerjanjian) > 0)
                                            @foreach ($saksiPerjanjian as $sP)
                                                <tr>
                                                    <td class="mb-1 fs-13">{{ $sP->nip }}</td>
                                                    <td class="mb-1 fs-13">{{ $sP->namaSaksi }}</td>
                                                    <td class="mb-1 fs-13">{{ $sP->keterangan }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tbody>

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
@endsection