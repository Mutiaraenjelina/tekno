@extends('layouts.admin.template')

@section('content')

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Pembayaran Sewa</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Tagihan dan Pembayaran</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pembayaran Sewa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Upload Bukti Pembayaran</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
<div class="row">
    <div class="col-xl-12">
        <form class="row g-3 needs-validation" action="{{ route('Pembayaran.storeBukti') }}" method="post"
            enctype="multipart/form-data" novalidate>
            {{ csrf_field() }}
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Upload Bukti Pembayaran
                    </div>
                </div>
                <input type="hidden" value="{{ $dataTagihan->idPembayaran }}" name="idPembayaranSewa">
                @if (isset($dataTagihan->detailPembayaran) && count($dataTagihan->detailPembayaran) > 0)
                    @foreach ($dataTagihan->detailPembayaran as $indexKey => $dP)
                        <input type="hidden" value="{{ $dP->idTagihan }}" name="idTagihan[]" />
                    @endforeach
                @endif
                <div class="card-body">
                    <div class="mb-3">
                        <label for="jangkaWaktu" class="form-label">Nama Bank Asal</label>
                        <input type="text" class="form-control" id="namaBank" name="namaBank"
                            placeholder="Masukkan Nama Bank Asal" required>
                        <div class="invalid-feedback">
                            Nama Bank Asal Tidak Boleh Kosong
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jangkaWaktu" class="form-label">Nama Pemilik Rekening/Yang Mengirimkan</label>
                        <input type="text" class="form-control" id="namaPemilikRek" name="namaPemilikRek"
                            placeholder="Masukkan Nama Pemilik Rekening/Yang Mengirimkan" required>
                        <div class="invalid-feedback">
                            Nama Pemilik Rekening/Yang Mengirimkan
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jangkaWaktu" class="form-label">Jumlah Dana</label>
                        <input type="number" class="form-control" id="jumlahDana" min="0" value="0" name="jumlahDana"
                            placeholder="Masukkan Jumlah Dana">
                        <div class="invalid-feedback">
                            Nama Pemilik Rekening/Yang Mengirimkan
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan"
                            placeholder="Masukkan Keterangan" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Upload Bukti Transfer</label>
                        <input class="form-control" type="file" id="fileBukti" name="fileBukti">
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-danger m-1" type="reset">Batal<i
                            class="bi bi-x-square ms-2 align-middle d-inline-block"></i></button>
                    <button class="btn btn-primary m-1" type="submit">Simpan <i
                            class="bi bi-floppy ms-2 ms-1 align-middle d-inline-block"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection