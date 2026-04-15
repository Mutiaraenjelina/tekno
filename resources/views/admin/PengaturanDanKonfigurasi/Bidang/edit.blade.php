@extends('layouts.admin.template')
@section('content')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        /* single select with placeholder */
        $(".js-example-placeholder-single").select2({
            placeholder: "Pilih Badan/Dinas",
            allowClear: true,
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        });
    });

</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Bidang</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pengatusan & Konfigurasi</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Organisasi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bidang</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
<div class="row">
    <div class="col-xl-12">
        <form class="row g-3 needs-validation" action="{{ route('Bidang.update', $bidang->idBidang) }}" method="post" novalidate>
            {{ csrf_field() }}
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Ubah Bidang
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Badan/Dinas</label>
                        <select class="js-example-placeholder-single form-control" name="idDepartemen" required>
                            <option></option>
                            @foreach ($departemen as $dpt)
                                <option value="{{$dpt->idDepartemen}}" {{ $dpt->idDepartemen === $bidang->idDepartemen ? 'selected' : '' }}>{{ $dpt->namaDepartmen }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                        Badan/Dinas Tidak Boleh Kosong
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Parent Bidang</label>
                        <input type="number" class="form-control" id="validationCustom01" placeholder="Masukkan Parent Bidang" name="parentBidang"
                            value="{{ $bidang->parentBidang }}" min="1" required>
                        <div class="invalid-feedback">
                            Parent Bidang Tidak Boleh Kosong
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Nama Bidang</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Masukkan Nama Bidang" name="namaBidang"
                            value="{{ $bidang->namaBidang }}" required>
                        <div class="invalid-feedback">
                            Nama Bidang Tidak Boleh Kosong
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="validationTextarea" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="validationTextarea" placeholder="Masukkan Keterangan" name="keterangan" rows="4" required>{{ $bidang->keterangan }}</textarea>
                        <div class="invalid-feedback">
                            Keterangan Tidak Boleh Kosong
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-danger m-1" type="reset">Batal<i class="bi bi-x-square ms-2 align-middle d-inline-block"></i></button>
                    <button class="btn btn-primary m-1" type="submit">Simpan <i class="bi bi-floppy ms-2 ms-1 align-middle d-inline-block"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
@endsection
