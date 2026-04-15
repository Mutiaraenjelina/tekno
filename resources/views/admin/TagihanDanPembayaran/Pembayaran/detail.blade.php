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
                    <h1 class="page-title fw-medium fs-18 mb-2">Detail Pembayaran Sewa</h1>
                    <ol class="breadcrumb breadcrumb-example1 mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Tagihan Dan Pembayaran</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Pembayaran Sewa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Pembayaran Sewa</li>
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
                                                {{ $headPembayaran->noUrut }}
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">
                                <form class="row g-3 needs-validation" action="{{ route('Pembayaran.uploadBukti') }}"
                                    method="post" novalidate>
                                    {{ csrf_field() }}
                                    <div class="col-xl-12">
                                        <input type="hidden" value="{{ $headPembayaran->idPembayaranRetribusi }}"
                                            name="idPembayaranSewa">
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                                <p class="fw-bold mb-2">
                                                    Ditagihkan Kepada:
                                                </p>
                                                <p class="mb-1 text-muted">
                                                    NPWRD: {{ $headPembayaran->npwrd }}
                                                </p>
                                                <p class="mb-1 text-muted">
                                                    {{ $headPembayaran->namaWajibRetribusi }}
                                                </p>
                                                <p class="mb-1 text-muted">
                                                    {{ $headPembayaran->alamatWajibRetribusi }}
                                                </p>
                                                <p class="mb-1 text-muted">
                                                    {{ $headPembayaran->email }}
                                                </p>
                                                <p class="mb-1 text-muted">
                                                    {{ $headPembayaran->nomorWhatsapp }}
                                                </p>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 ms-auto mt-sm-0 mt-3">
                                                <p class="fw-bold mb-2">
                                                    Atas Objek Retribusi :
                                                </p>
                                                <p class="text-muted mb-1">
                                                    #{{ $headPembayaran->kodeObjekRetribusi }}
                                                </p>
                                                <p class="text-muted mb-1">
                                                    {{ $headPembayaran->objekRetribusi }}
                                                </p>
                                                <p class="text-muted mb-1">
                                                    {{ $headPembayaran->alamatLengkap }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <p class="fw-medium text-muted mb-1">Nomor Billing :</p>
                                        <p class="fs-15 mb-1">#1216.2.23.1.{{ $headPembayaran->kodeBilling }}</p>
                                    </div>
                                    <div class="col-xl-4">
                                        <p class="fw-medium text-muted mb-1">Nomor Invoice :</p>
                                        <p class="fs-15 mb-1">{{ $headPembayaran->noInvoice }}</p>
                                    </div>
                                    <div class="col-xl-4">
                                        <p class="fw-medium text-muted mb-1">Tanggal Cetak :</p>
                                        <p class="fs-15 mb-1">
                                            {{ \Carbon\Carbon::parse($headPembayaran->tanggalPembayaran)->translatedFormat('d F Y') }}
                                        </p>
                                    </div>
                                    <div class="col-xl-4">
                                        <p class="fw-medium text-muted mb-1">Kode Pembayaran</p>
                                        <p class="fs-15 mb-1">
                                            {{ $headPembayaran->noVirtualAccount }}
                                        </p>
                                    </div>
                                    <div class="col-xl-4">
                                        <p class="fw-medium text-muted mb-1">Status Pembayaran :</p>
                                        <p class="fs-15 mb-1">
                                            @if($headPembayaran->idStatus == 13)
                                                <span class="badge bg-primary">{{ $headPembayaran->namaStatus }}</span>
                                            @elseif($headPembayaran->idStatus == 14)
                                                <span class="badge bg-info">{{ $headPembayaran->namaStatus }}</span>
                                            @elseif($headPembayaran->idStatus == 15)
                                                <span class="badge bg-success">{{ $headPembayaran->namaStatus }}</span>
                                            @endif
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
                                                        <th>JUMLAH POKOK</th>
                                                        <th>JUMLAH DENDA</th>
                                                        <th>JUMLAH SISA</th>
                                                        <th>TOTAL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="text-muted">
                                                                {{ $headPembayaran->nomorTagihan }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-muted">
                                                                {{ $headPembayaran->durasiSewa }}
                                                            </div>
                                                        </td>
                                                        <td class="text-muted">
                                                            @currency($headPembayaran->pokok)
                                                        </td>
                                                        <td>
                                                            <div class="text-muted">
                                                                @currency($headPembayaran->denda)
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-muted">
                                                                @currency($headPembayaran->sisaBayar)
                                                            </div>
                                                        </td>
                                                        <td width="200px">
                                                            <div class="product-quantity-container">
                                                                @currency($headPembayaran->totalBayar)
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5"></td>
                                                        <td colspan="2">
                                                            <table
                                                                class="table table-sm text-nowrap mb-0 table-borderless">
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">
                                                                            <p class="mb-0 fs-14">Total Bayar:</p>
                                                                        </th>
                                                                        <td width="270px">
                                                                            <p
                                                                                class="mb-0 fw-medium fs-16 text-primary">
                                                                                @currency($headPembayaran->totalBayar)
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
                                                    class="text-muted text-capitalize">{{ Riskihajar\Terbilang\Facades\Terbilang::make($headPembayaran->totalBayar) }}
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
                                                            <li>Harap penyetoran dilakukan pada Bank / Bendahara
                                                                Penerima
                                                            </li>
                                                            <li>Dalam hal wajib retribusi tidak membayar tepat waktu
                                                                atau
                                                                kurang membayar setelah jatuh tempo pembayaran,
                                                                dikeanakan
                                                                sanksi administrasi sebesar 2% (dua persen) setiap bulan
                                                                dari besarnya retribusi yang berutang yang tidak atau
                                                                kuran
                                                                bayar dan ditagih dengan menggunakan ....</li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($headPembayaran->idStatus == 13)
                                        <div class="card-footer text-end">
                                            <button class="btn btn-primary" type="submit">Konfirmasi Pembayaran <i
                                                    class="ri-bank-card-line ms-1 align-middle"></i></button>
                                        </div>
                                    @endif
                                </form>
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