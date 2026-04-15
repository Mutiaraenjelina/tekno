@extends('layouts.admin.template')
@section('content')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        /* single select with placeholder */
        $(".jenis-permohonan").select2({
            placeholder: "Pilih Jenis Permohonan",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        $(".jangka-waktu").select2({
            placeholder: "Pilih Perioditas Sewa",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        $(".peruntukan-sewa").select2({
            placeholder: "Pilih Peruntukan Sewa",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        $(".satuan").select2({
            placeholder: "Pilih Satuan",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // jQuery button click event to add Anggota Keluarga row
        $("#tambahDokumen").on("click", function () {
            // Adding a row inside the tbody.
            $("#tblDokumen tbody").append('<tr>' +
                '<td>' +
                '<select class="jenis-dokumen form-control" name="jenisDokumen[]" required>' +
                '<option></option>' +
                '@foreach ($dokumenKelengkapan as $dK)' +
                    '<option value="{{ $dK->idDokumenKelengkapan }}">' +
                    '{{ $dK->dokumenKelengkapan }}' +
                    '</option>' +
                '@endforeach' +
                '</select>' +
                '<div class="invalid-feedback">' +
                'Dokumen Kelengkapan Tidak Boleh Kosong' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<input class="file-dokumen form-control" type="file" id="fileDokumen" name="fileDokumen[]" accept="image/png, image/jpeg, image/gif, application/pdf" required>' +
                '<div class="invalid-feedback">' +
                'File Dokumen Kelengkapan Tidak Boleh Kosong' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<textarea class="form-control" id="keterangan" rows="1" name="keteranganDokumen[]"' +
                'placeholder="Masukkan Keterangan Dokumen"></textarea>' +
                '</td>' +
                '<td  style="text-align: center">' +
                '<button class="btn btn-sm btn-icon btn-danger-light" type="button" id="delFoto"><i class="ri-delete-bin-5-line"></i></button>' +
                '</td>' +
                '</tr>');

            $(".jenis-dokumen").select2({
                placeholder: "Pilih Dokumen Kelengkapan",
                allowClear: true,
                dropdownParent: $("#tblDokumen")
                //width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            });

        });


        $('#jenisPermohonan').on('change', function () {
            var idJenisPermohonan = $(this).val();

            $("#flex-retribusi").empty();

            if (idJenisPermohonan == 4) {
                //console.log(idJenisPermohonan);
                $("#flex-retribusi").append(
                    '<div class="col-xl-4">' +
                    '<label for="wajib-retribusi1" class="form-label">Nama Wajib Retribusi Pemohon</label>' +
                    '<select class="wajib-retribusi1 form-control" name="wajibRetribusi" required>' +
                    '<option></option>' +
                    '@foreach ($wajibRetribusi as $wR)' +
                        '<option value="{{ $wR->idWajibRetribusi }}">{{ $wR->namaWajibRetribusi }}' +
                        '</option>' +
                    '@endforeach' +
                    '</select>' +
                    '<div class="invalid-feedback">' +
                    'Nama Wajib Retribusi Pemohon Tidak Boleh Kosong' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-xl-4">' +
                    '<label for="wajib-retribusi2" class="form-label">Nama Wajib Retribusi Sebelumnya</label>' +
                    '<select class="wajib-retribusi2 form-control" name="wajibRetribusiSebelumnya" required>' +
                    '<option></option>' +
                    '@foreach ($wajibRetribusi as $wR)' +
                        '<option value="{{ $wR->idWajibRetribusi }}"> {{ $wR->namaWajibRetribusi }}' +
                        '</option>' +
                    '@endforeach' +
                    '</select>' +
                    '<div class="invalid-feedback">' +
                    'Nama Wajib Retribusi Sebelumnya Tidak Boleh Kosong' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-xl-4">' +
                    '<label for="objek-retribusi" class="form-label">Objek Retribusi</label>' +
                    '<select class="objek-retribusi form-control" name="objekRetribusi" required>' +
                    '<option></option>' +
                    '@foreach ($objekRetribusi as $oR)' +
                        '<option value="{{ $oR->idObjekRetribusi }}">{{ $oR->kodeObjekRetribusi }} - {{ $oR->objekRetribusi }}' +
                        '</option>' +
                    '@endforeach' +
                    '</select>' +
                    '<div class="invalid-feedback">' +
                    'Objek Retribusi Tidak Boleh Kosong' +
                    '</div>' +
                    '</div>'
                );
            }else{
                $("#flex-retribusi").append(
                    '<div class="col-xl-6">' +
                    '<label for="wajib-retribusi1" class="form-label">Nama Wajib Retribusi Pemohon</label>' +
                    '<select class="wajib-retribusi1 form-control" name="wajibRetribusi" required>' +
                    '<option></option>' +
                    '@foreach ($wajibRetribusi as $wR)' +
                        '<option value="{{ $wR->idWajibRetribusi }}">{{ $wR->namaWajibRetribusi }}' +
                        '</option>' +
                    '@endforeach' +
                    '</select>' +
                    '<div class="invalid-feedback">' +
                    'Nama Wajib Retribusi Pemohon Tidak Boleh Kosong' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-xl-6">' +
                    '<label for="objek-retribusi" class="form-label">Objek Retribusi</label>' +
                    '<select class="objek-retribusi form-control" name="objekRetribusi" required>' +
                    '<option></option>' +
                    '@foreach ($objekRetribusi as $oR)' +
                        '<option value="{{ $oR->idObjekRetribusi }}">{{ $oR->kodeObjekRetribusi }} - {{ $oR->objekRetribusi }}' +
                        '</option>' +
                    '@endforeach' +
                    '</select>' +
                    '<div class="invalid-feedback">' +
                    'Objek Retribusi Tidak Boleh Kosong' +
                    '</div>' +
                    '</div>'
                );
            }


            $(".wajib-retribusi1").select2({
                placeholder: "Pilih Nama Wajib Retribusi Pemohon",
                allowClear: true,
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            });

            $(".wajib-retribusi2").select2({
                placeholder: "Pilih Nama Wajib Retribusi Sebelumnya",
                allowClear: true,
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            });

            $(".objek-retribusi").select2({
                placeholder: "Pilih Nama Objek Retribusi",
                allowClear: true,
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            });

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
        <h1 class="page-title fw-medium fs-18 mb-2">Permohonan Sewa</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Sewa Aset</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Permohonan Sewa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Permohonan Sewa</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
<div class="row">
    <div class="col-xl-12">

        <form class="row g-3 needs-validation" action="{{route('PermohonanSewa.store')}}" method="post"
            enctype="multipart/form-data" novalidate>
            {{ csrf_field() }}
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Tambah Permohonan Sewa
                    </div>
                </div>
                <div class="card-body tambah-permohonan-sewa p-0">
                    <div class="p-4">
                        <div class="row gx-5">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-6">
                                <div class="card custom-card shadow-none mb-0 border-0">
                                    <div class="card-body p-0">
                                        <div class="row gy-3">
                                            <div class="col-xl-6">
                                                <label for="jenis-permohonan" class="form-label">Jenis
                                                    Permohonan</label>
                                                <select class="jenis-permohonan form-control" name="jenisPermohonan"
                                                    id="jenisPermohonan" required>
                                                    <option></option>
                                                    @foreach ($jenisPermohonan as $jP)
                                                        <option value="{{ $jP->idJenisPermohonan }}">
                                                            {{ $jP->jenisPermohonan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Jenis Permohonan Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="nomor-permohonan" class="form-label">Nomor
                                                    Permohonan</label>
                                                <input type="text" class="form-control" id="nomorPermohonan"
                                                    name="nomorPermohonan" placeholder="Masukkan Nomor Permohonan"
                                                    required>
                                                <div class="invalid-feedback">
                                                    Nomor Permohonan Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div id="flex-retribusi" class="row gy-2 col-xl-12">

                                            </div>
                                            <div class="col-xl-4">
                                                <label for="peruntukan-sewa" class="form-label">Peruntukan Sewa</label>
                                                <select class="peruntukan-sewa form-control" name="peruntukanSewa"
                                                    required>
                                                    <option></option>
                                                    @foreach ($peruntukanSewa as $pS)
                                                        <option value="{{ $pS->idperuntukanSewa }}">
                                                            {{ $pS->peruntukanSewa }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Peruntukan Sewa Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="jangka-waktu" class="form-label">Perioditas Sewa</label>
                                                <select class="jangka-waktu form-control" name="perioditas" required>
                                                    <option></option>
                                                    @foreach ($jangkaWaktu as $jW)
                                                        <option value="{{ $jW->idjenisJangkaWaktu }}">
                                                            {{ $jW->jenisJangkaWaktu }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Perioditas Sewa Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <label for="lama-sewa" class="form-label">Lama Sewa</label>
                                                <input type="text" class="form-control" id="lama-sewa" name="lamaSewa"
                                                    placeholder="Masukkan Lama Sewa" required>
                                                <div class="invalid-feedback">
                                                    Lama Sewa Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <label for="satuan" class="form-label">Satuan</label>
                                                <select class="satuan form-control" name="satuan" required>
                                                    <option></option>
                                                    @foreach ($satuan as $sT)
                                                        <option value="{{ $sT->idSatuan }}">
                                                            {{ $sT->namaSatuan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Satuan Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="catatan" class="form-label">Catatan</label>
                                                <textarea class="form-control" id="catatan" rows="4" name="catatan"
                                                    placeholder="Masukkan Catatan"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 border-top">
                        <div class="d-sm-flex justify-content-end">
                            <button class="btn btn-primary m-1" id="tambahDokumen" type="button"><span
                                    class="bi bi-plus-circle align-middle me-1 fw-medium"></span>
                                Tambah Dokumen Kelengkapan
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-nowrap table-hover" id="tblDokumen">
                                <thead>
                                    <tr>
                                        <th>Nama Dokumen Kelengkapan</th>
                                        <th>File Dokumen</th>
                                        <th>Keterangan</th>
                                        <th width="20px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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