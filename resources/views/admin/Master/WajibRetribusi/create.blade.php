@extends('layouts.admin.template')
@section('content')

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // jQuery button click event to add Anggota Keluarga row
        $("#tambahDokumen").on("click", function () {

            // Adding a row inside the tbody.
            $("#tblDokumen tbody").append('<tr>' +
                '<td>' +
                '<select class="jenis-dokumen form-control" name="jenis-dokumen" required>' +
                '<option></option>' +
                '@foreach ($dokumenKelengkapan as $dK)' +
                    '<option value="{{ $dK->idDokumenKelengkapan }}">' +
                    '{{ $dK->dokumenKelengkapan }}' +
                    '</option>' +
                '@endforeach' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<input class="form-control" type="file" id="fileDokumen" name="fileDokumen[]">' +
                '</td>' +
                '<td>' +
                '<textarea class="form-control" id="keterangan" rows="1" name="keteranganFoto[]"' +
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

        $(document).on('click', '#delFoto', function () {
            $(this).closest('tr').remove();
            return false;
        });


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#previewFoto').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#photoWajibRetribusi").change(function () {
            readURL(this);
        });
    });

</script>

<script>
    $(document).ready(function () {
        /* single select with placeholder */
        $(".jenis-wajib").select2({
            placeholder: "Pilih Jenis Wajib Retribusi",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        $(".pekerjaan").select2({
            placeholder: "Pilih Pekerjaan",
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

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Wajib Retribusi</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Wajib Retribusi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Wajib Retribusi</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
<div class="row">
    <div class="col-xl-12">

        <form class="row g-3 needs-validation" action="{{route('WajibRetribusi.store')}}" method="post"
            enctype="multipart/form-data" novalidate>
            {{ csrf_field() }}
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Tambah Wajib Retribusi
                    </div>
                </div>
                <div class="card-body tambah-wajib-retribusi p-0">
                    <div class="p-4">
                        <div class="row gx-5">
                            <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                                <div class="card custom-card shadow-none mb-0 border-0">
                                    <div class="card-body p-0">
                                        <div class="row gy-3">
                                            <div class="col-xl-4">
                                                <label for="jenis-wajib" class="form-label">Jenis Wajib
                                                    Retribusi</label>
                                                <select class="jenis-wajib form-control" id="jenis-wajib"
                                                    name="jenisWajib" required>
                                                    <option></option>
                                                    @foreach ($jenisWajibRetribusi as $jW)
                                                        <option value="{{ $jW->idJenisWajibRetribusi }}">
                                                            {{ $jW->namaJenisWajibRetribusi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Jenis Wajib Retribusi Tidak Boleh Kosong!
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <label for="nik" class="form-label">Nomor Induk Kependudukan
                                                    (NIK)</label>
                                                <input type="text" class="form-control" id="nik" name="nik"
                                                    placeholder="Masukkan Nomor Induk Kependudukan (NIK)" required>
                                                <div class="invalid-feedback">
                                                    Nomor Induk Kependudukan (NIK) Tidak Boleh Kosong!
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="nik" class="form-label">NPWRD</label>
                                                <input type="text" class="form-control" id="npwrd" name="npwrd"
                                                    placeholder="Masukkan NPWRD" required>
                                                <div class="invalid-feedback">
                                                    NPWRD Tidak Boleh Kosong!
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <label for="nama-wajib-retribusi" class="form-label">Nama Wajib
                                                    Retribusi</label>
                                                <input type="text" class="form-control" id="nama-wajib-retribusi"
                                                    name="namaWajibRetribusi"
                                                    placeholder="Masukkan Nama Wajib Retribusi Sesuai KTP" required>
                                                <div class="invalid-feedback">
                                                    Nama Wajib Retribusi Tidak Boleh Kosong!
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                                <select class="pekerjaan form-control" name="pekerjaan" required>
                                                    <option></option>
                                                    @foreach ($perkerjaan as $pk)
                                                        <option value="{{ $pk->idPekerjaan }}">
                                                            {{ $pk->namaPekerjaan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Pekerjaan Tidak Boleh Kosong!
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
                                                    Provinsi Tidak Boleh Kosong!
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kabupaten-kota" class="form-label">Kabupaten/Kota</label>
                                                <select class="kabupaten-kota form-control" name="kabupatenKota"
                                                    id="kota" required disabled>
                                                    <option></option>

                                                </select>
                                                <div class="invalid-feedback">
                                                    Kabupaten/Kota Tidak Boleh Kosong!
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                                <select class="kecamatan form-control" name="kecamatan" id="distrik"
                                                    required disabled>
                                                    <option></option>

                                                </select>
                                                <div class="invalid-feedback">
                                                    Kecamatan Tidak Boleh Kosong!
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kelurahan-kota" class="form-label">Kelurahan/Desa</label>
                                                <select class="kelurahan-desa form-control" name="kelurahan"
                                                    id="kelurahan" required disabled>
                                                    <option></option>


                                                </select>
                                                <div class="invalid-feedback">
                                                    Kelurahan/Desa Tidak Boleh Kosong!
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="alamat-wajib-retribusi" class="form-label">Alamat Wajib
                                                    Retribusi</label>
                                                <textarea class="form-control" id="alamat-wajib" rows="2"
                                                    name="alamatWajibRetribusi"
                                                    placeholder="Masukkan Alamat Wajib Retribusi" required></textarea>
                                                    <div class="invalid-feedback">
                                                    Alamat Tidak Boleh Kosong!
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
                                            <div class="col-xl-6">
                                                <label for="no-ponsel" class="form-label">Nomor Ponsel</label>
                                                <input type="text" class="form-control" id="nomor-ponsel"
                                                    name="nomorPonsel" placeholder="Masukkan Nomor Ponsel">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="nomor-whatsapp" class="form-label">Nomor WhatsApp</label>
                                                <input type="text" class="form-control" id="nomor-whatsapp"
                                                    name="nomorWhatsapp" placeholder="Masukkan Nomor Whatsapp">
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="wmail" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Masukkan email">
                                                <div class="invalid-feedback">
                                                    Format email salah!
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                                                    <div class="card custom-card shadow-none mb-0 border-0">
                                                        <div class="card-body p-0">
                                                            <div class="row gy-3">
                                                                <div class="col-xl-8">
                                                                    <div class="text-center d-grid gap-2 mb-4">
                                                                        <label for="file-foto" class="form-label">Upload
                                                                            Foto Wajib Retribusi</label>
                                                                        <img src="{{ asset('admin_resources/assets/images/user-general/no_picture.png') }}"
                                                                            class="img-thumbnail float-start"
                                                                            width="100%" height="220" alt=""
                                                                            id="previewFoto" alt="...">
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-primary btn-wave waves-effect waves-light"
                                                                            onclick="javascript:document.getElementById('photoWajibRetribusi').click();">
                                                                            <i class="ri-upload-2-line me-1"></i>Unggah
                                                                            Gambar
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <input id="photoWajibRetribusi" type="file"
                                                        style='visibility: hidden;' name="photoWajibRetribusi"
                                                        accept="image/png, image/jpeg, image/gif" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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