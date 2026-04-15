@extends('layouts.admin.template')
@section('content')

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Dashboard</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Permohonan Baru</li>
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
                    Daftar Permohonan Sewa Baru
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
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($permohonanBaru) && count($permohonanBaru) > 0)
                            @foreach ($permohonanBaru as $pS)
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
                                    <td>{{ \Carbon\Carbon::parse($pS->createAt)->translatedFormat('d F Y') }}</td>
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