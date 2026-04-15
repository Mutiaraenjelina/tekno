@extends('layouts.admin.template')

@section('content')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $("#jabatanBidang").select2({
            placeholder: "Pilih Jabatan Bidang",
            allowClear: true,
            width: '100%',
        });

        $("#golonganPangkat").select2({
            placeholder: "Pilih Golongan Pangkat",
            allowClear: true,
            width: '100%',
        });

        $("#provinsi").select2({
            placeholder: "Pilih Provinsi",
            allowClear: true,
            width: '100%',
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
                            $('#kelurahan').append('<option>Kelurahan</option>');
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

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#previewFoto').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#photoPegawai").change(function () {
            readURL(this);
        });

    });
</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Tambah Pegawai</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pegawai</li>
                    <li class="breadcrumb-item"><a href="#">Tambah Pegawai</a></li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
<div class="row">
    <div class="col-xl-12">
        <form class="row g-3 needs-validation" action="{{ route('Pegawai.store') }}" method="post"
            enctype="multipart/form-data" novalidate>
            {{ csrf_field() }}
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Tambah Pegawai
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
                                                <label for="nip" class="form-label">NIP</label>
                                                <input type="text" class="form-control" id="nip" name="nip"
                                                    placeholder="Masukkan NIP" required>
                                                <div class="invalid-feedback">
                                                    NIP Tidak Boleh Kosong!
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <label for="namaPegawai" class="form-label">Nama Pegawai</label>
                                                <input type="text" class="form-control" id="namaPegawai"
                                                    name="namaPegawai" placeholder="Masukkan Nama Pegawai" required>
                                                <div class="invalid-feedback">
                                                    Nama Pegawai Tidak Boleh Kosong!
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="jabatanBidang" class="form-label">Jabatan Bidang</label>
                                                <select class="js-example-placeholder-single form-control"
                                                    id="jabatanBidang" name="jabatanBidang" required>
                                                    <option></option>
                                                    @foreach ($jabatanBidang as $sT)
                                                        <option value="{{ $sT->idJabatanBidang }}">
                                                            {{ $sT->namaJabatanBidang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Jabatan Bidang Tidak Boleh Kosong!
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="golongan" class="form-label">Golongan</label>
                                                <select class="js-example-placeholder-single form-control"
                                                    id="golonganPangkat" name="golongan" required>
                                                    <option></option>
                                                    @foreach ($golonganPangkat as $gP)
                                                        <option value="{{ $gP->idGolonganPangkat }}">
                                                            {{ $gP->golongan }} - {{ $gP->pangkat }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Golongan Tidak Boleh Kosong!
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
                                                <label for="alamat-pegawai" class="form-label">Alamat Pegawai</label>
                                                <textarea class="form-control" id="alamat-wajib" rows="5" name="alamat"
                                                    placeholder="Masukkan Alamat Detail (Cth: Jalan, Blok, Nomor Rumah, dll)" required></textarea>
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
                                                <label for="nomorPonsel" class="form-label">Nomor Ponsel</label>
                                                <input type="text" class="form-control" id="nomorPonsel"
                                                    name="nomorPonsel" placeholder="Masukkan Nomor Ponsel" required>
                                                <div class="invalid-feedback">
                                                    Nomor Ponsel Tidak Boleh Kosong!
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="nomorWhatsapp" class="form-label">Nomor Whatsapp</label>
                                                <input type="text" class="form-control" id="nomorWhatsapp"
                                                    name="nomorWhatsapp" placeholder="Masukkan Nomor Whatsapp" required>
                                                <div class="invalid-feedback">
                                                    Nomor Whatsapp Tidak Boleh Kosong!
                                                </div>
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
                                                                    <label for="file-foto" class="form-label">Upload Foto Pegawai</label>
                                                                        <img src="{{ asset('admin_resources/assets/images/user-general/no_picture.png') }}"
                                                                            class="img-thumbnail float-start"
                                                                            width="100%" height="220" alt=""
                                                                            id="previewFoto" alt="...">
                                                                            <button type="button"  class="btn btn-sm btn-primary btn-wave waves-effect waves-light" onclick="javascript:document.getElementById('photoPegawai').click();">
                                                                                <i class="ri-upload-2-line me-1"></i>Unggah Gambar
                                                                            </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                            <input id="photoPegawai" type="file" style='visibility: hidden;' name="photoPegawai" accept="image/png, image/jpeg, image/gif" />
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
            </div>
        </form>
    </div>
</div>
<!-- End:: row-1 -->
@endsection