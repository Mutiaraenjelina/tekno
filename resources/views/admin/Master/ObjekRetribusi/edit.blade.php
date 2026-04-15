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

        $(".jangka-waktu-sewa").select2({
            placeholder: "Pilih Jangka Waktu Sewa",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#checkebox-lg').change(function () {
            if (this.checked) {
                $('#isGambarUtama').val('1');
            } else {
                $('#isGambarUtama').val('0');
            }
        });

        $('#checkebox-lg-Add').change(function () {
            if (this.checked) {
                $('#isGambarUtamaAdd').val('1');
            } else {
                $('#isGambarUtamaAdd').val('0');
            }
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //saat pilihan provinsi di pilih, maka akan mengambil data kota menggunakan ajax
        $('#provinsi').on('change', function () {
            var id = $(this).val();

            if (id) {
                var data = {
                    'idProvinsi': id,
                }

                $.ajax({
                    url: "{{ route('DropdownLokasi.kota') }}",
                    type: "GET",
                    data: data,
                    dataType: "json",
                    delay: 250,
                    success: function (data) {
                        if (data) {
                            $('#kota').empty();
                            //$("#kota>optgroup>option[value='1']").removeAttr('disabled');
                            $('#kota').prop('disabled', false);
                            $('#kota').append('<option>Pilih Kabupaten/Kota</option>');
                            $.each(data, function (key, kota) {
                                $('#kota').append('<option value="' + kota.city_id + '">' + kota.city_name + '</option>');
                            });
                        } else {
                            $('#kota').empty();
                        }
                    }
                });
            } else {
                $('#kota').empty();
            }
        });

        //saat pilihan kota di pilih, maka akan mengambil data kota menggunakan ajax
        $('#kota').on('change', function () {
            var idK = $(this).val();

            if (idK) {
                var data = {
                    'idKota': idK,
                }

                $.ajax({
                    url: "{{ route('DropdownLokasi.kecamatan') }}",
                    type: "GET",
                    data: data,
                    dataType: "json",
                    delay: 250,
                    success: function (data) {
                        if (data) {
                            $('#distrik').empty();
                            $('#distrik').prop('disabled', false);
                            $.each(data, function (key, kecamatan) {
                                $('#distrik').append('<option value="' + kecamatan.dis_id + '">' + kecamatan.dis_name + '</option>');
                            });
                        } else {
                            $('#distrik').empty();
                        }
                    }
                });
            } else {
                $('#distrik').empty();
            }
        });

        //saat pilihan kecamatan di pilih, maka akan mengambil data kota menggunakan ajax
        $('#distrik').on('change', function () {
            var idKel = $(this).val();

            if (idKel) {
                var data = {
                    'idKelurahan': idKel,
                }

                $.ajax({
                    url: "{{ route('DropdownLokasi.kelurahan') }}",
                    type: "GET",
                    data: data,
                    dataType: "json",
                    delay: 250,
                    success: function (data) {
                        if (data) {
                            $('#kelurahan').empty();
                            $('#kelurahan').prop('disabled', false);
                            $.each(data, function (key, kelurahan) {
                                $('#kelurahan').append('<option value="' + kelurahan.subdis_id + '">' + kelurahan.subdis_name + '</option>');
                            });
                        } else {
                            $('#kelurahan').empty();
                        }
                    }
                });
            } else {
                $('#kelurahan').empty();
            }
        });

        $(document).on('click', '.editDenahBtn', function (e) {
            var st_id = $(this).val();

            $('#ubahDenahModal').modal('show');
            $('#idFileDenah').val(st_id);
        });

        $(document).on('click', '.tambahFotoBtn', function (e) {
            var fo_id = $(this).val();

            $('#tambahFotoModal').modal('show');
            $('#idObjekRetribusiAdd').val(fo_id);
        });

        $(document).on('click', '.editFotoBtn', function (e) {
            e.preventDefault();

            var fo_id = $(this).val();

            $('#ubahFotoModal').modal('show');

            $('#idFotoObjek').val('');
            $('#namaFoto').val('');
            $('#keteranganFoto').val('');
            $('#checkebox-lg').prop('checked', false);

            //console.log(fo_id);

            $.ajax({
                method: "GET",
                url: "{{ route('ObjekRetribusi.editFotoObjek') }}",
                data: {
                    id: fo_id
                },
                success: function (response) {
                    if (response.status == 404) {
                        new Noty({
                            text: response.message,
                            type: 'warning',
                            modal: true
                        }).show();
                    } else {
                        //console.log(response);
                        $('#idFotoObjek').val(response.fotoObjekRetribusi.idPhotoObjekRetribusi);
                        $('#namaFoto').val(response.fotoObjekRetribusi.namaPhotoObjekRetribusi);
                        $('#keteranganFoto').val(response.fotoObjekRetribusi.keterangan);
                        if (response.fotoObjekRetribusi.isGambarUtama == '1') {
                            $('#checkebox-lg').prop('checked', true);
                            $('#isGambarUtama').val('1');
                        } else {
                            $('#checkebox-lg').prop('checked', false);
                            $('#isGambarUtama').val('0');
                        }
                        //$('#gambarUtama').text(response.fotoObjekRetribusi.isGambarUtama);
                    }
                }
            });
        });
    });
</script>

<style>
    input[type=number] {
        text-align: right;
    }
</style>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Objek Retribusi</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Objek Retribusi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ubah Objek Retribusi</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
<div class="row">
    <div class="col-xl-12">

        <form class="row g-3 needs-validation" action="{{route('ObjekRetribusi.update')}}" method="post"
            enctype="multipart/form-data" novalidate>
            {{ csrf_field() }}
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Ubah Objek Retribusi
                    </div>
                </div>
                <div class="card-body tambah-objek-retribusi p-0">
                    <div class="p-4">
                        <div class="row gx-5">
                            <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                                <div class="card custom-card shadow-none mb-0 border-0">
                                    <input type="hidden" id="idObjekRetribusi" name="idObjekRetribusi"
                                        value="{{ $objekRetribusi->idObjekRetribusi }}">
                                    <div class="card-body p-0">
                                        <div class="row gy-3">
                                            <div class="col-xl-6">
                                                <label for="validationCustom01" class="form-label">Jenis Objek
                                                    Retribusi</label>
                                                <select class="jenis-objek-retribusi form-control"
                                                    name="jenisObjekRetribusi" data-trigger required>
                                                    <option></option>
                                                    @foreach ($objectType as $oT)
                                                        <option value="{{ $oT->idJenisObjekRetribusi }}" {{ $oT->idJenisObjekRetribusi === $objekRetribusi->idJenisObjekRetribusi ? 'selected' : '' }}>
                                                            {{ $oT->jenisObjekRetribusi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Jenis Objek Retribusi Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kode-objek-retribusi" class="form-label">Kode Objek
                                                    Retribusi</label>
                                                <input type="text" class="form-control" id="kodeObjekRetribusi"
                                                    placeholder="Masukkan Kode Objek Retribusi"
                                                    value="{{ $objekRetribusi->kodeObjekRetribusi }}"
                                                    name="kodeObjekRetribusi" required>
                                                <div class="invalid-feedback">
                                                    Kode Objek Retribusi Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="nomor-bangunan" class="form-label">NPWRD</label>
                                                <input type="text" class="form-control" id="npwrd"
                                                    value="{{ $objekRetribusi->npwrd }}" name="npwrd"
                                                    placeholder="Masukkan NPWRD">
                                            </div>
                                            <div class="col-xl-8">
                                                <label for="nama-objek-retribusi" class="form-label">Nama Objek
                                                    Retribusi</label>
                                                <input type="text" class="form-control" id="namaObjekRetribusi"
                                                    placeholder="Masukkan Nama Objek Retribusi"
                                                    value="{{ $objekRetribusi->objekRetribusi }}"
                                                    name="namaObjekRetribusi" required>
                                                <div class="invalid-feedback">
                                                    Nama Objek Retribusi Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="nomor-bangunan" class="form-label">Nomor bangunan</label>
                                                <input type="text" class="form-control" id="nomorBangunan"
                                                    value="{{ $objekRetribusi->noBangunan }}" name="nomorBangunan"
                                                    placeholder="Masukkan Nomor Bangunan">
                                            </div>
                                            <div class="col-xl-8">
                                                <label for="lokasi-objek-retribusi" class="form-label">Lokasi Objek
                                                    Retribusi</label>
                                                <select class="lokasi-objek-retribusi form-control"
                                                    name="lokasiObjekRetribusi" required>
                                                    <option></option>
                                                    @foreach ($objectLocation as $oL)
                                                        <option value="{{ $oL->idLokasiObjekRetribusi }}" {{ $oL->idLokasiObjekRetribusi === $objekRetribusi->idLokasiObjekRetribusi ? 'selected' : '' }}>
                                                            {{ $oL->lokasiobjekretribusi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Lokasi Objek Retribusi Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="provinsi" class="form-label">Provinsi</label>
                                                <select class="provinsi form-control" name="provinsi" id="provinsi"
                                                    required>
                                                    <option></option>
                                                    @foreach ($province as $pV)
                                                        <option value="{{ $pV->prov_id }}" {{ $pV->prov_id === $objekRetribusi->prov_id ? 'selected' : '' }}>
                                                            {{ $pV->prov_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Provinsi Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kabupaten-kota" class="form-label">Kabupaten/Kota</label>
                                                <select class="kabupaten-kota form-control" name="kabupatenKota"
                                                    id="kota" required>
                                                    <option></option>
                                                    @foreach ($kota as $kT)
                                                        <option value="{{ $kT->city_id }}" {{ $kT->city_id === $objekRetribusi->city_id ? 'selected' : '' }}>
                                                            {{ $kT->city_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Kabupaten/Kota Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                                <select class="kecamatan form-control" name="kecamatan" id="distrik"
                                                    required>
                                                    <option></option>
                                                    @foreach ($kecamatan as $kC)
                                                        <option value="{{ $kC->dis_id }}" {{ $kC->dis_id === $objekRetribusi->dis_id ? 'selected' : '' }}>
                                                            {{ $kC->dis_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Kecamatan Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kelurahan-kota" class="form-label">Kelurahan/Desa</label>
                                                <select class="kelurahan-desa form-control" name="kelurahan"
                                                    id="kelurahan" required>
                                                    <option></option>
                                                    @foreach ($kelurahan as $kL)
                                                        <option value="{{ $kL->subdis_id }}" {{ $kL->subdis_id === $objekRetribusi->subdis_id ? 'selected' : '' }}>
                                                            {{ $kL->subdis_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Kelurahan/Desa Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="alamat-objek-retribusi" class="form-label">Alamat Objek
                                                    Retribusi</label>
                                                <textarea class="form-control" id="alamat-objek" rows="2"
                                                    name="alamatObjekRetribusi"
                                                    placeholder="Masukkan Alamat Objek Retribusi"
                                                    required>{{ $objekRetribusi->alamat }}</textarea>
                                            </div>
                                            <div class="invalid-feedback">
                                                Alamat Tidak Boleh Kosong
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="longitude" class="form-label">Longitude (Kordinat X)</label>
                                                <input type="number" class="form-control" id="longitudu-x" min="0"
                                                    step=".0000000001" title="Longitude" pattern="^\d+(?:\.\d{0,10})"
                                                    value="{{ $objekRetribusi->longitude }}" name="longitudu"
                                                    placeholder="Masukkan Kordinat X">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="latitude" class="form-label">Latitude (Kordinat Y)</label>
                                                <input type="number" class="form-control" id="latitude-y"
                                                    name="latitude" min="0" step=".0000000001" title="Latitude"
                                                    pattern="^\d+(?:\.\d{0,10})" value="{{ $objekRetribusi->latitute }}"
                                                    placeholder="Masukkan Kordinat Y">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                                <div class="card custom-card shadow-none mb-0 border-0">
                                    <div class="card-body p-0">
                                        <div class="row gy-3">
                                            <div class="col-xl-4">
                                                <label for="panajng-tanah" class="form-label">Panjang Tanah
                                                    (meter)</label>
                                                <input type="number" class="form-control" id="panjang-tanah"
                                                    value="{{ $objekRetribusi->panjangTanah }}" name="panjangTanah"min="0"
                                                    step=".01" title="Panjang Tanah" pattern="^\d+(?:\.\d{0,2})"
                                                    placeholder="Masukkan Panjang Tanah">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="lebar-tanah" class="form-label">Lebar Tanah (meter)</label>
                                                <input type="number" class="form-control" id="panjang-tanah"
                                                    value="{{ $objekRetribusi->lebarTanah }}" name="lebarTanah" min="0"
                                                    step=".01" title="Lebar Tanah" pattern="^\d+(?:\.\d{0,2})"
                                                    placeholder="Masukkan Lebar Tanah">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="luas-tanah" class="form-label">Luas Tanah (meter)</label>
                                                <input type="number" class="form-control" id="luas-tanah"
                                                    name="luasTanah" value="{{ $objekRetribusi->luasTanah }}" min="0"
                                                    step=".01" title="Luas Tanah" pattern="^\d+(?:\.\d{0,2})"
                                                    placeholder="Masukkan Luas Tanah" name="luasTanah">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="panjang-bangunan" class="form-label">Panjang Bangunan
                                                    (meter)</label>
                                                <input type="number" class="form-control" id="panjang-bangunan"
                                                    value="{{ $objekRetribusi->panjangBangunan }}" min="0"
                                                    step=".01" title="Panjang Bangunan" pattern="^\d+(?:\.\d{0,2})"
                                                    placeholder="Masukkan Panjang Bangunan" name="panjangBangunan">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="lebar-bangunan" class="form-label">Lebar Bangunan
                                                    (meter)</label>
                                                <input type="number" class="form-control" id="lebar-bangunan"
                                                    value="{{ $objekRetribusi->lebarBangunan }}" min="0"
                                                    step=".01" title="Lebar Bangunan" pattern="^\d+(?:\.\d{0,2})"
                                                    placeholder="Masukkan Lebar Bangunan" name="lebarBangunan">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="luas-bangunan" class="form-label">Luas Bangunan
                                                    (meter)</label>
                                                <input type="number" class="form-control" id="luas-bangunan"
                                                    value="{{ $objekRetribusi->luasBangunan }}" min="0"
                                                    step=".01" title="Luas Bangunan" pattern="^\d+(?:\.\d{0,2})"
                                                    placeholder="Masukkan Luas Bangunan" name="luasBangunan">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="jumlah-lantai" class="form-label">Jumlah Lantai</label>
                                                <input type="number" class="form-control" id="jumlah-lantai" min="0"
                                                    value="{{ $objekRetribusi->jumlahLantai }}"
                                                    placeholder="Masukkan Jumlah Lantai" name="jumlahLantai">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kapasitas" class="form-label">Kapasitas (Orang)</label>
                                                <input type="number" class="form-control" id="kapasitas" min="0"
                                                    value="{{ $objekRetribusi->kapasitas }}"
                                                    placeholder="Masukkan Kapasitas" name="kapasitas">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="jumlah-lantai" class="form-label">Batas Sebelah
                                                    Utara</label>
                                                <input type="text" class="form-control" id="batasUtara"
                                                    value="{{ $objekRetribusi->batasUtara }}"
                                                    placeholder="Masukkan Batas Sebelah Utara" name="batasUtara">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kapasitas" class="form-label">Batas Sebelah Selatan</label>
                                                <input type="text" class="form-control" id="batasSelatan"
                                                    value="{{ $objekRetribusi->batasSelatan }}"
                                                    placeholder="Masukkan Batas Sebelah Selatan" name="batasSelatan">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="jumlah-lantai" class="form-label">Batas Sebelah
                                                    Timur</label>
                                                <input type="text" class="form-control" id="batasTimur"
                                                    value="{{ $objekRetribusi->batasTimur }}"
                                                    placeholder="Masukkan Batas Sebelah Timur" name="batasTimur">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kapasitas" class="form-label">Batas Sebelah Barat</label>
                                                <input type="text" class="form-control" id="batasBarat"
                                                    value="{{ $objekRetribusi->batasBarat }}"
                                                    placeholder="Masukkan Batas Sebelah Barat" name="batasBarat">
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <textarea class="form-control" id="keterangan" rows="3"
                                                    name="keterangan"
                                                    placeholder="Masukkan Keterangan">{{ $objekRetribusi->keterangan }}</textarea>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table text-nowrap table-hover" id="tblFoto">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama File/Gambar Denah Tanah</th>
                                                            <th width="30px">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-primary">
                                                                @if($objekRetribusi->fileName)
                                                                    {{ $objekRetribusi->fileName }}
                                                                @else
                                                                    File/Gambar Denah Tanah tidak tersedia!
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    value="{{ $objekRetribusi->idObjekRetribusi }}"
                                                                    class="btn btn-icon btn-outline-teal btn-wave btn-sm editDenahBtn">
                                                                    <i class="ri-edit-box-line"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 border-top">
                        <div class="d-sm-flex justify-content-end">
                            <button class="btn btn-primary m-1 tambahFotoBtn" id="tambahFoto" type="button"
                                value="{{ $objekRetribusi->idObjekRetribusi }}"><span
                                    class="bi bi-plus-circle align-middle me-1 fw-medium"></span>
                                Tambah Foto
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-nowrap table-hover" id="tblFoto">
                                <thead>
                                    <tr>
                                        <th>Nama Foto</th>
                                        <th>Keterangan</th>
                                        <th width="30px">Gambar Utama</th>
                                        <th width="20px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($fotoObjekRetribusi) && count($fotoObjekRetribusi) > 0)
                                        @foreach ($fotoObjekRetribusi as $fO)
                                            <tr>
                                                <td>
                                                    <div class="d-flex">
                                                        <span class="avatar avatar-md avatar-square bg-light"><img
                                                                src="{{Storage::disk('biznet')->url('/' . $fO->photoObjekRetribusi)}}"
                                                                class="w-100 h-100" alt="..."></span>
                                                        <div class="ms-2">
                                                            <p class="fw-semibold mb-0 d-flex align-items-center"><a
                                                                    href="javascript:void(0);">{{ $fO->namaPhotoObjekRetribusi }}</a>
                                                            </p>
                                                            <p class="fs-12 text-muted mb-0">Nama File:
                                                                {{ $fO->fileName }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $fO->keterangan }}</td>
                                                <td class="text-center">
                                                    @if($fO->isGambarUtama == 1)
                                                        <span class="bi bi-check-lg align-middle me-1 fw-medium"></span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" value="{{ $fO->idPhotoObjekRetribusi }}"
                                                        class="btn btn-icon btn-outline-teal btn-wave btn-sm editFotoBtn">
                                                        <i class="ri-edit-box-line"></i>
                                                    </button>
                                                    <a
                                                        href="{{ route('ObjekRetribusi.deleteFotoObjek', $fO->idPhotoObjekRetribusi) }}">
                                                        <button type="button"
                                                            class="btn btn-icon btn-outline-danger btn-wave btn-sm hapusFotoBtn">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
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

<!-- Start:: Edit Denah Tanah-->
<div class="modal fade" id="ubahDenahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Ubah File/Gambar Denah Tanah</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row g-3 needs-validation" action="{{route('ObjekRetribusi.updateDenahTanah')}}" method="post"
                enctype="multipart/form-data" novalidate>
                {{ csrf_field() }}
                <input type="hidden" id="idFileDenah" name="idFileDenah">
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">Upload File/Gambar Denah Tanah</h6>
                            <input type="file" class="denah-tanah form-control" name="fileDenahTanah">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary m-1" type="submit">Simpan <i
                            class="bi bi-floppy ms-2 ms-1 align-middle d-inline-block"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End:: Edit Foto Denah Tanah -->

<!-- Start:: Edit Foto Objek Retribusi-->
<div class="modal fade" id="ubahFotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Ubah Foto Objek Retribusi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row g-3 needs-validation" action="{{route('ObjekRetribusi.updateFotoObjek')}}" method="post"
                enctype="multipart/form-data" novalidate>
                {{ csrf_field() }}
                <input type="hidden" id="idFotoObjek" name="idFotoObjek">
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">Nama Foto</h6>
                            <input type="text" class="form-control" id="namaFoto" name="namaFoto"
                                placeholder="Masukkan Nama Foto" required>
                            <div class="invalid-feedback">
                                Nama Foto Tidak Boleh Kosong
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">File Foto</h6>
                            <input type="file" class="denah-tanah form-control" name="fileFoto" id="fileFoto">
                        </div>
                    </div>
                </div>
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">Keterangan</h6>
                            <textarea class="form-control" id="keteranganFoto" rows="3" name="keteranganFoto"
                                placeholder="Masukkan Keterangan Foto"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">Atur Sebagai Gambar Utama</h6>
                            <div class="form-check form-check-lg d-flex align-items-center">
                                <input class="form-check-input gambarUtama" type="checkbox" value="1" id="checkebox-lg"
                                    name="gambarUtama">
                                <input type="hidden" id="isGambarUtama" name="isGambarUtama">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary m-1" type="submit">Simpan <i
                            class="bi bi-floppy ms-2 ms-1 align-middle d-inline-block"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End:: Edit Foto Objek Retribusi -->


<!-- Start:: Add Foto Objek Retribusi-->
<div class="modal fade" id="tambahFotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Foto Objek Retribusi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row g-3 needs-validation" action="{{route('ObjekRetribusi.storeFotoObjek')}}" method="post"
                enctype="multipart/form-data" novalidate>
                {{ csrf_field() }}
                <input type="hidden" id="idObjekRetribusiAdd" name="idObjekRetribusiAdd">
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">Nama Foto</h6>
                            <input type="text" class="form-control" id="namaFotoAdd" name="namaFotoAdd"
                                placeholder="Masukkan Nama Foto" required>
                            <div class="invalid-feedback">
                                Nama Foto Tidak Boleh Kosong
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">File Foto</h6>
                            <input type="file" class="denah-tanah form-control" name="fileFotoAdd" id="fileFotoAdd">
                        </div>
                    </div>
                </div>
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">Keterangan</h6>
                            <textarea class="form-control" id="keteranganFotoAdd" rows="3" name="keteranganFotoAdd"
                                placeholder="Masukkan Keterangan Foto"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">Atur Sebagai Gambar Utama</h6>
                            <div class="form-check form-check-lg d-flex align-items-center">
                                <input class="form-check-input gambarUtama" type="checkbox" value="1"
                                    id="checkebox-lg-Add" name="gambarUtama">
                                <input type="hidden" id="isGambarUtamaAdd" name="isGambarUtamaAdd">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary m-1" type="submit">Simpan <i
                            class="bi bi-floppy ms-2 ms-1 align-middle d-inline-block"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End:: Add Foto Objek Retribusi -->
@endsection