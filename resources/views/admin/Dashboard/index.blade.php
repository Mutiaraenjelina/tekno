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
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<div class="row">
    <div class="col-xl-4">
        <div class="card custom-card">
            <div class="card-body">
                <p class="mb-2 fs-15 fw-medium">Total Tagihan</p>
                <h4 class="mb-0 fw-semibold">{{ $stats->tagihanTotal }}</h4>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card custom-card">
            <div class="card-body">
                <p class="mb-2 fs-15 fw-medium">Total Bayar</p>
                <h4 class="mb-0 fw-semibold">{{ $stats->totalBayar }}</h4>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card custom-card">
            <div class="card-body">
                <p class="mb-2 fs-15 fw-medium">Total Belum Bayar</p>
                <h4 class="mb-0 fw-semibold">{{ $stats->totalBelumBayar }}</h4>
            </div>
        </div>
    </div>
</div>
<!-- End::row-1 -->

@endsection
