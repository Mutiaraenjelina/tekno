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
                        <li class="breadcrumb-item active" aria-current="page">Tagihan Jatuh Tempo</li>
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
                        Daftar Tagihan Jatuh Tempo
                    </div>
                </div>
                <div class="card-body">
                    <table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
                        <thead>
                            <tr>
                                <th>Nama Wajib Retribusi/Pemohon</th>
                                <th>Objek Retribusi</th>
                                <th scope="col">Nomor Tagihan</th>
                                <th scope="col">Jatuh Tempo</th>
                                <th scope="col">Jumlah Tagihan</th>
                                <th scope="col">Jumlah Denda</th>
                                <th scope="col">Total Tagihan</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($tagihanJatuhTempo) && count($tagihanJatuhTempo) > 0)
                                @foreach ($tagihanJatuhTempo as $tS)
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                @if($tS->fotoWajibRetribusi)
                                                    <span class="avatar avatar-md avatar-square bg-light"><img
                                                            src="{{Storage::disk('biznet')->url('/' . $tS->fotoWajibRetribusi)}}"
                                                            class="w-100 h-100" alt="..."></span>
                                                @else
                                                    <span class="avatar avatar-md avatar-square bg-light"><img
                                                            src="{{ asset('admin_resources/assets/images/user-general/no_picture.png') }}"
                                                            class="w-100 h-100" alt="..."></span>
                                                @endif
                                                <div class="ms-2">
                                                    <p class="fw-semibold mb-0 d-flex align-items-center">
                                                        {{ $tS->namaWajibRetribusi }}
                                                    </p>
                                                    <p class="fs-12 text-muted mb-0">NPWRD: {{ $tS->npwrd }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="ms-2">
                                                    <p class="fw-semibold mb-0 d-flex align-items-center">
                                                        {{ $tS->kodeObjekRetribusi }}
                                                    </p>
                                                    <p class="fs-12 text-muted mb-0">{{ $tS->objekRetribusi }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $tS->nomorTagihan }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($tS->tanggalJatuhTempo)->translatedFormat('d F Y') }}
                                        </td>
                                        <td>Rp. {{ $tS->jumlahTagihan }}</td>
                                        <td>Rp. {{ $tS->jumlahDenda }}</td>
                                        <td>Rp. {{ $tS->totalTagihan }}</td>
                                        <td>
                                            @if($tS->idStatus == 9)
                                                <span class="badge bg-primary">{{ $tS->namaStatus }}</span>
                                            @elseif($tS->idStatus == 10)
                                                <span class="badge bg-success">{{ $tS->namaStatus }}</span>
                                            @elseif($tS->idStatus == 11)
                                                <span class="badge bg-danger">{{ $tS->namaStatus }}</span>
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