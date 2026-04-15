@extends('layouts.admin.template')
@section('content')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        /* single select with placeholder */
        $(".jenis-objek-retribusi").select2({
            placeholder: "Pilih Jenis Objek Retribusi",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        $(".lokasi-objek-retribusi").select2({
            placeholder: "Pilih Lokasi Objek Retribusi",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        $(".provinsi").select2({
            placeholder: "Pilih Provinsi",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        $(".kabupaten-kota").select2({
            placeholder: "Pilih Kabupaten/Kota",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        $(".kecamatan").select2({
            placeholder: "Pilih Kecamatan",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        $(".kelurahan-desa").select2({
            placeholder: "Pilih Kelurahan/Desa",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        $(".jangka-waktu-sewa").select2({
            placeholder: "Pilih Jangka Waktu Sewa",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        // jQuery button click event to add Anggota Keluarga row
        $("#tambahFoto").on("click", function () {

            // Adding a row inside the tbody.
            $("#tblFoto tbody").append('<tr>' +
                '<td>' +
                '<input type="text" class="form-control" id="namaFoto[]"' +
                'placeholder="Masukkan Nama Foto" required>' +
                '</td>' +
                '<td>' +
                '<input type="file" class="foto-objek" name="fileFoto[]" multiple' +
                'data-allow-reorder="true" data-max-file-size="5MB"' +
                'data-max-files="1">' +
                '</td>' +
                '<td>' +
                '<textarea class="form-control" id="keterangan" rows="1" name="keteranganFoto"' +
                'placeholder="Masukkan Keterangan Foto"></textarea>' +
                '</td>' +
                '<td  style="text-align: center">' +
                '<button class="btn btn-sm btn-icon btn-danger-light" type="button" id="delFoto"><i class="ri-delete-bin-5-line"></i>' +
                '</button>' +
                '</td>' +
                '</tr>');
        });

        $(document).on('click', '#delFoto', function () {
            $(this).closest('tr').remove();
            return false;
        });
    });

</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Jenis Dokumen</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pengatusan & Konfigurasi</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Penyewaan Aset</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jenis Dokumen</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
<div class="row">
    <div class="col-xl-12">

        <form class="row g-3 needs-validation" action="{{route('JenisDokumen.store')}}" method="post" novalidate>
            {{ csrf_field() }}
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Tambah Jenis Dokumen
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label">Jenis Dokumen</label>
                        <input type="text" class="form-control" id="validationCustom01" name="jenisDokumen"
                            placeholder="Masukkan Jenis Jangka Waktu" required>
                        <div class="invalid-feedback">
                            Jenis Dokumen Tidak Boleh Kosong
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="validationTextarea" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="validationTextarea" name="keterangan"
                            placeholder="Masukkan Keterangan" rows="4"></textarea>
                    </div>

                    </div>
                    <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">
                        <button class="btn btn-danger m-1" type="reset">Batal<i
                                class="bi bi-x-square ms-2 align-middle d-inline-block"></i></button>
                        <button class="btn btn-primary m-1" type="submit">Simpan <i
                                class="bi bi-floppy ms-2 ms-1 align-middle d-inline-block"></i></button>
                    </div>
                </div>
        </form>
    </div>
</div>
</div>
@endsection