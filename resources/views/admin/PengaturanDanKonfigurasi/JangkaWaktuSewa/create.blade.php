@extends('layouts.admin.template')

@section('content')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        /* single select with placeholder */
        $(".js-example-placeholder-single").select2({
            placeholder: "Pilih Jenis Jangka Waktu",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });
    });
</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Jangka Waktu Sewa</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pengaturan & Konfigurasi</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Penyewaan Aset</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jangka Waktu Sewa</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
<div class="row">
    <div class="col-xl-12">
        <form class="row g-3 needs-validation" action="{{ route('JangkaWaktuSewa.store') }}" method="post" novalidate>
            {{ csrf_field() }}
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Tambah Jangka Waktu Sewa
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="jenisJangkaWaktu" class="form-label">Jenis Jangka Waktu</label>
                        <select class="js-example-placeholder-single form-control" id="jenisJangkaWaktu" name="jenisJangkaWaktu" required>
                            <option></option>
                            @foreach ($jangkaWaktuTypeCombo as $sT)
                                <option value="{{ $sT->idjenisJangkaWaktu }}">{{ $sT->jenisJangkaWaktu }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Jenis Jangka Waktu Tidak Boleh Kosong
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jangkaWaktu" class="form-label">Jangka Waktu Sewa</label>
                        <input type="text" class="form-control" id="jangkaWaktu" name="jangkaWaktu"
                            placeholder="Masukkan Jangka Waktu Sewa" required>
                        <div class="invalid-feedback">
                            Jangka Waktu Sewa Tidak Boleh Kosong
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan"
                            placeholder="Masukkan Keterangan" rows="4"></textarea>
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
