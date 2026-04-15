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

        // jQuery button click event to add Anggota Keluarga row
        $("#tambahFoto").on("click", function () {

            // Adding a row inside the tbody.
            $("#tblFoto tbody").append('<tr>' +
                '<td>' +
                '<input type="text" class="form-control" id="namaFoto" name="namaFoto[]"' +
                'placeholder="Masukkan Nama Foto" required>' +
                '</td>' +
                '<td>' +
                '<input class="foto-objek form-control" type="file" id="foto-objek" name="fileFoto[]">' +
                '</td>' +
                '<td>' +
                '<textarea class="form-control" id="keterangan" rows="1" name="keteranganFoto[]"' +
                'placeholder="Masukkan Keterangan Foto"></textarea>' +
                '</td>' +
                '<td style="text-align: center">' +
                '<div class="form-check form-switch mb-2">' +
                '<input class="form-check-input gambarUtama" type="checkbox" value="" name="gambarUtama[]" id="gambarUtama" onclick="checkedOnClick(this);">' +
                '</div>' +
                '</td>' +
                '<td style="text-align: center">' +
                '<button class="btn btn-sm btn-icon btn-danger-light" type="button" id="delFoto"><i class="ri-delete-bin-5-line"></i></button>' +
                '</td>' +
                '</tr>');
        });

        $(document).on('click', '#delFoto', function () {
            $(this).closest('tr').remove();
            return false;
        });
    });

    function checkedOnClick(el) {
        // Select all checkboxes by class
        var checkboxesList = document.getElementsByClassName("gambarUtama");
        for (var i = 0; i < checkboxesList.length; i++) {
            checkboxesList.item(i).checked = false; // Uncheck all checkboxes
        }

        el.checked = true; // Checked clicked checkbox
    }

</script>

<script>
    $(document).ready(function () {
        $('#gambarUtama').change(function () {
            if ($('#gambarUtama').is(":checked") == true) {
                $('#gambarUtama').val('1');
            } else {
                $('#gambarUtama').val('0');
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
                            $('#distrik').append('<option>Pilih Kecamatan</option>');
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
                            $('#kelurahan').append('<option>Pilih Kelurahan/Desa</option>');
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
                    <li class="breadcrumb-item active" aria-current="page">Tambah Objek Retribusi</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
<div class="row">
    <div class="col-xl-12">

        <form class="row g-3 needs-validation" action="{{route('ObjekRetribusi.store')}}" method="post"
            enctype="multipart/form-data" novalidate>
            {{ csrf_field() }}
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Tambah Objek Retribusi
                    </div>
                </div>
                <div class="card-body tambah-objek-retribusi p-0">
                    <div class="p-4">
                        <div class="row gx-5">
                            <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                                <div class="card custom-card shadow-none mb-0 border-0">
                                    <div class="card-body p-0">
                                        <div class="row gy-3">
                                            <div class="col-xl-6">
                                                <label for="validationCustom01" class="form-label">Jenis Objek
                                                    Retribusi</label>
                                                <select class="jenis-objek-retribusi form-control"
                                                    name="jenisObjekRetribusi" data-trigger required>
                                                    <option></option>
                                                    @foreach ($objectType as $oT)
                                                        <option value="{{ $oT->idJenisObjekRetribusi }}">
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
                                                    name="kodeObjekRetribusi" required>
                                                <div class="invalid-feedback">
                                                    Kode Objek Retribusi Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="nomor-bangunan" class="form-label">NPWRD</label>
                                                <input type="text" class="form-control" id="npwrd"
                                                    name="npwrd" placeholder="Masukkan NPWRD">
                                            </div>
                                            <div class="col-xl-8">
                                                <label for="nama-objek-retribusi" class="form-label">Nama Objek
                                                    Retribusi</label>
                                                <input type="text" class="form-control" id="namaObjekRetribusi"
                                                    placeholder="Masukkan Nama Objek Retribusi"
                                                    name="namaObjekRetribusi" required>
                                                <div class="invalid-feedback">
                                                    Nama Objek Retribusi Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="nomor-bangunan" class="form-label">Nomor bangunan</label>
                                                <input type="text" class="form-control" id="nomorBangunan"
                                                    name="nomorBangunan" placeholder="Masukkan Nomor Bangunan">
                                            </div>
                                            <div class="col-xl-8">
                                                <label for="lokasi-objek-retribusi" class="form-label">Lokasi Objek
                                                    Retribusi</label>
                                                <select class="lokasi-objek-retribusi form-control"
                                                    name="lokasiObjekRetribusi" required>
                                                    <option></option>
                                                    @foreach ($objectLocation as $oL)
                                                        <option value="{{ $oL->idLokasiObjekRetribusi }}">
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
                                                        <option value="{{ $pV->prov_id }}">
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
                                                    id="kota" disabled required>
                                                    <option></option>

                                                </select>
                                                <div class="invalid-feedback">
                                                    Kabupaten/Kota Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                                <select class="kecamatan form-control" name="kecamatan" id="distrik"
                                                    required disabled>
                                                    <option></option>

                                                </select>
                                                <div class="invalid-feedback">
                                                    Kecamatan Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kelurahan-kota" class="form-label">Kelurahan/Desa</label>
                                                <select class="kelurahan-desa form-control" name="kelurahan"
                                                    id="kelurahan" required disabled>
                                                    <option></option>


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
                                                    placeholder="Masukkan Alamat Objek Retribusi" required></textarea>
                                            </div>
                                            <div class="invalid-feedback">
                                                Alamat Tidak Boleh Kosong
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="longitude" class="form-label">Longitude (Kordinat X)</label>
                                                <input type="number" class="form-control" id="longitudu-x" min="0"
                                                    step=".0000000001" title="Longitude" pattern="^\d+(?:\.\d{0,10})" 
                                                    value="0" name="longitudu" placeholder="Masukkan Kordinat X">
                                                <div class="invalid-feedback">
                                                    Format angka longitudenya salah!
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="latitude" class="form-label">Latitude (Kordinat Y)</label>
                                                <input type="number" class="form-control" id="latitude-y"  min="0"
                                                    step=".0000000001" title="Latitude" pattern="^\d+(?:\.\d{0,10})"
                                                    name="latitude" value="0" placeholder="Masukkan Kordinat Y">
                                                <div class="invalid-feedback">
                                                    Format angka latitudenya salah!
                                                </div>
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
                                                <input type="number" class="form-control" id="panjang-tanah" min="0"
                                                    step=".01" title="Panjang Tanah" pattern="^\d+(?:\.\d{0,2})" 
                                                    value="0.00" name="panjangTanah" placeholder="Masukkan Panjang Tanah">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="lebar-tanah" class="form-label">Lebar Tanah (meter)</label>
                                                <input type="number" class="form-control" id="panjang-tanah" min="0"
                                                    step=".01" title="Lebar Tanah" pattern="^\d+(?:\.\d{0,2})" 
                                                    value="0.00" name="lebarTanah" placeholder="Masukkan Lebar Tanah">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="luas-tanah" class="form-label">Luas Tanah (meter)</label>
                                                <input type="number" class="form-control" id="luas-tanah"
                                                    step=".01" title="Luas Tanah" pattern="^\d+(?:\.\d{0,2})" 
                                                    name="luasTanah" min="0" value="0.00" placeholder="Masukkan Luas Tanah">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="panjang-bangunan" class="form-label">Panjang Bangunan
                                                    (meter)</label>
                                                <input type="number" class="form-control" id="panjang-bangunan" min="0"
                                                    step=".01" title="Panjang Bangunan" pattern="^\d+(?:\.\d{0,2})" 
                                                    value="0.00" placeholder="Masukkan Panjang Bangunan"
                                                    name="panjangBangunan">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="lebar-bangunan" class="form-label">Lebar Bangunan
                                                    (meter)</label>
                                                <input type="number" class="form-control" id="lebar-bangunan" min="0"
                                                    step=".01" title="Lebar Bangunan" pattern="^\d+(?:\.\d{0,2})" 
                                                    value="0.00" placeholder="Masukkan Lebar Bangunan"
                                                    name="lebarBangunan">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="luas-bangunan" class="form-label">Luas Bangunan
                                                    (meter)</label>
                                                <input type="number" class="form-control" id="luas-bangunan" min="0"
                                                    step=".01" title="Luas Bangunan" pattern="^\d+(?:\.\d{0,2})" 
                                                    value="0.00" placeholder="Masukkan Luas Bangunan" name="luasBangunan">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="jumlah-lantai" class="form-label">Jumlah Lantai</label>
                                                <input type="number" class="form-control" id="jumlah-lantai" min="0"
                                                    value="0" placeholder="Masukkan Jumlah Lantai" name="jumlahLantai">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kapasitas" class="form-label">Kapasitas (Orang)</label>
                                                <input type="number" class="form-control" id="kapasitas" min="0"
                                                    value="0" placeholder="Masukkan Kapasitas" name="kapasitas">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="jumlah-lantai" class="form-label">Batas Sebelah
                                                    Utara</label>
                                                <input type="text" class="form-control" id="batasUtara"
                                                    placeholder="Masukkan Batas Sebelah Utara" name="batasUtara">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kapasitas" class="form-label">Batas Sebelah Selatan</label>
                                                <input type="text" class="form-control" id="batasSelatan"
                                                    placeholder="Masukkan Batas Sebelah Selatan" name="batasSelatan">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="jumlah-lantai" class="form-label">Batas Sebelah
                                                    Timur</label>
                                                <input type="text" class="form-control" id="batasTimur"
                                                    placeholder="Masukkan Batas Sebelah Timur" name="batasTimur">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kapasitas" class="form-label">Batas Sebelah Barat</label>
                                                <input type="text" class="form-control" id="batasBarat"
                                                    placeholder="Masukkan Batas Sebelah Barat" name="batasBarat">
                                            </div>
                                            <div class="col-xl-12 product-documents-container">
                                                <label for="kapasitas" class="form-label">Gambar Denah Tanah</label>
                                                <!--<input type="file" class="gambar-denah-tanah" name="fileGambarDenahTanah"
                                                    data-allow-reorder="true" data-max-file-size="5MB"
                                                    data-max-files="1">-->
                                                <input class="foto-objek form-control" type="file" id="foto-objek "
                                                    name="fileGambarDenahTanah">
                                            </div>
                                            </label>
                                            <div class="col-xl-12">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <textarea class="form-control" id="keterangan" rows="3"
                                                    name="keterangan" placeholder="Masukkan Keterangan"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 border-top">
                        <div class="d-sm-flex justify-content-end">
                            <button class="btn btn-primary m-1" id="tambahFoto" type="button"><span
                                    class="bi bi-plus-circle align-middle me-1 fw-medium"></span>
                                Tambah Foto
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-nowrap table-hover" id="tblFoto">
                                <thead>
                                    <tr>
                                        <th>Nama Foto</th>
                                        <th>File Foto</th>
                                        <th>Keterangan</th>
                                        <th width="40px">Gambar Utama</th>
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