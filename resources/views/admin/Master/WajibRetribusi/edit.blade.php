@extends('layouts.admin.template')
@section('content')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        /* single select with placeholder */
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

        // for product images upload
        //const MultipleElement1 = document.querySelector('.foto-wajib-retribusi');
        //FilePond.create(MultipleElement1,);

        $('#provinsi').trigger('change.select2');
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
                            //$('#kota').append('<option hidden>Choose Course</option>');
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

        <form class="row g-3 needs-validation" action="{{route('WajibRetribusi.update')}}" method="post"
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
                                <input type="hidden" id="idWajibRetribusi" name="idWajibRetribusi"
                                value="{{ $wajibRetribusi->idWajibRetribusi }}">
                                    <div class="card-body p-0">
                                        <div class="row gy-3">
                                            <div class="col-xl-4">
                                                <label for="jenis-wajib" class="form-label">Jenis Wajib
                                                    Retribusi</label>
                                                <select class="jenis-wajib form-control" id="jenis-wajib"
                                                    name="jenisWajib" required>
                                                    <option></option>
                                                    @foreach ($jenisWajibRetribusi as $jW)
                                                        <option value="{{ $jW->idJenisWajibRetribusi }}" {{ $jW->idJenisWajibRetribusi === $wajibRetribusi->idJenisWajibRetribusi ? 'selected' : '' }}>
                                                            {{ $jW->namaJenisWajibRetribusi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Jenis Wajib Retribusi Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <label for="nik" class="form-label">Nomor Induk Kependudukan
                                                    (NIK)</label>
                                                <input type="text" class="form-control" id="nik" name="nik" value="{{ $wajibRetribusi->nik }}"
                                                    placeholder="Masukkan Nomor Induk Kependudukan (NIK)" required>
                                                <div class="invalid-feedback">
                                                    Nomor Induk Kependudukan (NIK) Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="nik" class="form-label">NPWRD</label>
                                                <input type="text" class="form-control" id="npwrd" name="npwrd" value="{{ $wajibRetribusi->npwrd }}"
                                                    placeholder="Masukkan NPWRD" required>
                                                <div class="invalid-feedback">
                                                    NPWRD
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <label for="nama-wajib-retribusi" class="form-label">Nama Wajib
                                                    Retribusi</label>
                                                <input type="text" class="form-control" id="namaWajib" name="namaWajib" value="{{ $wajibRetribusi->namaWajibRetribusi }}"
                                                    placeholder="Masukkan Nama Wajib Retribusi Sesuai KTP" required>
                                                <div class="invalid-feedback">
                                                    Nama Wajib Retribusi Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                                <select class="pekerjaan form-control" name="pekerjaan" required>
                                                    <option></option>
                                                    @foreach ($pekerjaan as $pk)
                                                        <option value="{{ $pk->idPekerjaan }}" {{ $pk->idPekerjaan === $wajibRetribusi->idPekerjaan ? 'selected' : '' }}>
                                                            {{ $pk->namaPekerjaan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Pekerjaan Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="provinsi" class="form-label">Provinsi</label>
                                                <select class="provinsi form-control" name="provinsi" required>
                                                    <option></option>
                                                    @foreach ($province as $pV)
                                                        <option value="{{ $pV->prov_id }}" {{ $pV->prov_id === $wajibRetribusi->prov_id ? 'selected' : '' }}>
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
                                                    required>
                                                    <option></option>
                                                    @foreach ($kota as $kT)
                                                        <option value="{{ $kT->city_id }}" {{ $kT->city_id === $wajibRetribusi->city_id ? 'selected' : '' }}>
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
                                                <select class="kecamatan form-control" name="kecamatan" required>
                                                    <option></option>
                                                    @foreach ($kecamatan as $kC)
                                                        <option value="{{ $kC->dis_id }}" {{ $kC->dis_id === $wajibRetribusi->dis_id ? 'selected' : '' }}>
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
                                                <select class="kelurahan-desa form-control" name="kelurahan" required>
                                                    <option></option>
                                                    @foreach ($kelurahan as $kL)
                                                        <option value="{{ $kL->subdis_id }}" {{ $kL->subdis_id === $wajibRetribusi->subdis_id ? 'selected' : '' }}>
                                                            {{ $kL->subdis_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Kelurahan/Desa Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="alamat-wajib-retribusi" class="form-label">Alamat Wajib
                                                    Retribusi</label>
                                                <textarea class="form-control" id="alamat-wajib" rows="2"
                                                    name="alamatWajibRetribusi"
                                                    placeholder="Masukkan Alamat Wajib Retribusi">{{ $wajibRetribusi->alamat }}</textarea>
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
                                                <input type="text" class="form-control" id="nomor-ponsel" value="{{ $wajibRetribusi->nomorPonsel }}"
                                                    name="nomorPonsel" placeholder="Masukkan Nomor Ponsel">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="nomor-whatsapp" class="form-label">Nomor WhatsApp</label>
                                                <input type="text" class="form-control" id="nomor-whatsapp" value="{{ $wajibRetribusi->nomorWhatsapp }}"
                                                    name="nomorWhatsapp" placeholder="Masukkan Nomor Whatsapp">
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="wmail" class="form-label">Email</label>
                                                <input type="text" class="form-control" id="email" name="email" value="{{ $wajibRetribusi->email }}"
                                                    placeholder="Masukkan email">
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
                                                                        @if (isset($file))
                                                                        <img src="{{Storage::disk('biznet')->url('/' . $wajibRetribusi->fotoWajibRetribusi)}}"
                                                                            class="img-thumbnail float-start"
                                                                            width="100%" height="220" alt=""
                                                                            id="previewFoto" alt="...">
                                                                        @else
                                                                        <img src="{{ asset('admin_resources/assets/images/user-general/no_picture.png') }}"
                                                                            class="img-thumbnail float-start"
                                                                            width="100%" height="220" alt=""
                                                                            id="previewFoto" alt="...">                                                                  
                                                                        @endif
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-primary btn-wave waves-effect waves-light"
                                                                            onclick="javascript:document.getElementById('photoWajibRetribusi').click();">
                                                                            <i class="ri-edit-2-fill me-1"></i>Ubah
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