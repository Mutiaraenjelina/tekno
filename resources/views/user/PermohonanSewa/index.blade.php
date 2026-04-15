@extends('layouts.admin.template')
@section('content')

<script>
    
</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Permohonan Sewa</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Sewa Aset</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Permohonan Sewa</a></li>
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
                        href="{{ route('WajibRetribusi.createPermohonanSewa') }}">
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
                                    <td>{{ \Carbon\Carbon::parse($pS->tanggalDiajukan)->translatedFormat('d F Y') }}</td>
                                    <td>{{ $pS->objekRetribusi }}</td>
                                    <td>{{ $pS->lamaSewa }}</td>
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
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('WajibRetribusi.detailPermohonanSewa', $pS->idPermohonanSewa) }}"><i
                                                            class="ri-eye-line me-1 align-middle d-inline-block"></i>Detail</a>
                                                </li>
                                                <li><a class="dropdown-item" href="{{ route('PermohonanSewa.edit', $pS->idPermohonanSewa) }}"><i
                                                            class="ri-edit-line me-1 align-middle d-inline-block"></i>Ubah</a>
                                                </li>
                                                <li><button type="button" value="" class="dropdown-item deleteBtn">
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

@endsection