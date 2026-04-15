@extends('layouts.admin.template')
@section('content')

<div class="page">
    <!-- include header.html"-->
    <!-- include sidebar.html"-->

    <!-- Start::app-content -->
    <div class="main-content">
        <div class="container-fluid">

            <!-- Start::page-header -->
            <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h1 class="page-title fw-medium fs-18 mb-2">Invoice Details</h1>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);">
                                Pages
                            </a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Invoice</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Invoice Details</li>
                    </ol>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row-1 -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <div class="h5 mb-0 d-sm-flex d-bllock align-items-center">
                                            <div class="">
                                                <img src="{{ asset('admin_resources/assets/images/user-general/logo_kab_taput.jpg') }}"
                                                    alt="" height="106px" width="100px">
                                            </div>
                                            <div class="ms-sm-2 ms-0 mt-sm-0 mt-6">
                                                <p class="fs-15 mb-1">PERERINTAH KABUPATEN TAPANULI UTARA</p>
                                                <div class="h5 fw-bold mb-1">BADAN KEUANGAN DAN ASET DAERAH</div>
                                                <p class="fs-12 mb-1">Jl. Let. Jend. Soeprapto No.1</p>
                                                <p class="fs-14 mb-1">TARUTUNG</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div style="text-align: center;">
                                            <p class="mb-5"></p>
                                            <p class="h5 fw-bold mb-1">
                                                KETETAPAN RETRIBUSI DAERAH SEWA TANAH
                                            </p>

                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div style="text-align: center;">
                                            <p class="mb-4"></p>
                                            <p class="h6 fw-medium mb-1">
                                                No. Urut
                                            </p>
                                            <p class="h6 fw-bold mb-1">
                                                {{ $headTagihanDetail->noUrut }}
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                            <p class="fw-bold mb-2">
                                                Ditagihkan Kepada:
                                            </p>
                                            <p class="mb-1 text-muted">
                                                #{{ $headTagihanDetail->npwrd }}
                                            </p>
                                            <p class="mb-1 text-muted">
                                                {{ $headTagihanDetail->namaWajibRetribusi }}
                                            </p>
                                            <p class="mb-1 text-muted">
                                                {{ $headTagihanDetail->alamatWajibRetribusi }}
                                            </p>
                                            <p class="mb-1 text-muted">
                                                {{ $headTagihanDetail->email }}
                                            </p>
                                            <p class="mb-1 text-muted">
                                                {{ $headTagihanDetail->nomorWhatsapp }}
                                            </p>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 ms-auto mt-sm-0 mt-3">
                                            <p class="fw-bold mb-2">
                                                Atas Objek Retribusi :
                                            </p>
                                            <p class="text-muted mb-1">
                                                #{{ $headTagihanDetail->kodeObjekRetribusi }}
                                            </p>
                                            <p class="text-muted mb-1">
                                                {{ $headTagihanDetail->objekRetribusi }}
                                            </p>
                                            <p class="text-muted mb-1">
                                                {{ $headTagihanDetail->alamatLengkap }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <p class="fw-medium text-muted mb-1">Nomor Billing :</p>
                                    <!--<p class="fs-15 mb-1">#1216.2.23.1.{{ $headTagihanDetail->kodeBilling }}</p>-->
                                </div>
                                <div class="col-xl-3">
                                    <p class="fw-medium text-muted mb-1">ID Transaksi :</p>
                                    <p class="fs-15 mb-1">{{ $detailTagihan[0]->trxId }}</p>
                                </div>
                                <div class="col-xl-3">
                                    <p class="fw-medium text-muted mb-1">Kode Bayar/Nomor Virtual Account :</p>
                                    <p class="fs-15 mb-1">{{ $detailTagihan[0]->noVirtualAccount }}
                                        </p>
                                </div>
                                <div class="col-xl-3">
                                    <p class="fw-medium text-muted mb-1">Lakukan Pembayaran Dalam :</p>
                                    <p class="fs-15 mb-1">{{ \Carbon\Carbon::parse($detailTagihan[0]->expiredDatePembayaran)->translatedFormat('d F Y - H:i:s ') }}
                                        </p>
                                </div>
                                @php($total = 0)
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table nowrap text-nowrap border mt-4">
                                            <thead>
                                                <tr>
                                                    <th>NOMOR TAGIHAN</th>
                                                    <th>TAHUN</th>
                                                    <th>JATUH TEMPO</th>
                                                    <th>BIAYA ADMINISTRASI</th>
                                                    <th>JUMLAH TAGIHAN</th>
                                                    <th>JUMLAH DENDA</th>
                                                    <th>TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($detailTagihan) && count($detailTagihan) > 0)
                                                @foreach ($detailTagihan as $indexKey => $tD)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" value="{{ $tD->idTagihanSewa }}"
                                                            name="idTagihan" />
                                                        <div class="text-muted">
                                                            {{ $tD->nomorTagihan }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-muted">
                                                            {{ $tD->masaBayar }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-muted">
                                                            {{ \Carbon\Carbon::parse($tD->tanggalJatuhTempo)->translatedFormat('d F Y') }}
                                                        </div>
                                                    </td>
                                                    <td class="text-muted">
                                                        0
                                                    </td>
                                                    <td>
                                                        <div class="text-muted">
                                                            @currency($tD->jumlahTagihan)
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-muted">
                                                            @currency($tD->jumlahDenda)
                                                        </div>
                                                    </td>
                                                    <td width="200px">
                                                        <div class="product-quantity-container">
                                                            @currency($tD->totalTagihan)
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php($total = $total + $tD->totalTagihan)
                                                @endforeach
                                                @endif
                                                <tr>
                                                    <td colspan="5"></td>
                                                    <td colspan="2">
                                                        <table class="table table-sm text-nowrap mb-0 table-borderless">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">
                                                                        <p class="mb-0 fs-14">Total Bayar:</p>
                                                                    </th>
                                                                    <td width="170px">
                                                                        <p class="mb-0 fw-medium fs-16 text-primary">
                                                                            @currency($total)
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div>
                                        <p>
                                            <span class="mb-1 fw-medium">Dengan Huruf: </span><span
                                                class="text-muted text-capitalize">{{ Riskihajar\Terbilang\Facades\Terbilang::make($total) }}
                                                Rupiah</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="card custom-card card-bg-light">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center w-100">
                                                <div class="">
                                                    <p class="fs-12 mb-1 fw-bold">Perhatian:</p>
                                                    <ol class="fs-12 mb-1">
                                                        <li>Wajib Retribusi harap melakukan penyetoran melalui <b>Bank
                                                                Sumut</b> dengan rincian sebagai berikut:
                                                            <ul>
                                                                <li class="fw-bold">Id Transaksi (trxId) :
                                                                    {{ $detailTagihan[0]->trxId }} </li>
                                                                <li class="fw-bold">Virtual Account (Kode Pembayaran) :
                                                                    {{ $detailTagihan[0]->noVirtualAccount }} </li>
                                                            </ul>
                                                        </li>
                                                        <li>Dalam hal wajib retribusi tidak membayar tepat waktu
                                                            atau
                                                            kurang membayar setelah jatuh tempo pembayaran,
                                                            dikeanakan
                                                            sanksi administrasi sebesar 2% (dua persen) setiap bulan
                                                            dari besarnya retribusi yang berutang yang tidak atau
                                                            kurang
                                                            bayar dan ditagih dengan menggunakan ....</li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End::row-1 -->

                </div>
            </div>
        </div>
    </div>
</div>


@endsection