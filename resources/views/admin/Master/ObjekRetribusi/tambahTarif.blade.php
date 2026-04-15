@extends('layouts.admin.template')
@section('content')
<style>
    input[type=number] {
        text-align: right;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        /* single select with placeholder */
        $(".objek-retribusi").select2({
            placeholder: "Pilih Objek Retribusi",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        $(".jangka-waktu-sewa").select2({
            placeholder: "Pilih Jangka Waktu Sewa",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        // for product images upload
        /*const MultipleElement1 = document.querySelector('.file-penilaian');
        FilePond.create(MultipleElement1,);*/

        /* For Human Friendly dates */
        flatpickr("#tanggalDinilai", {
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "m/d/Y",
            disableMobile: false,
        });

        //saat pilihan objek retribusi di pilih, maka akan mengambil data objek retribusi menggunakan ajax
        $('#objekRetribusi').on('change', function () {
            var id = $(this).val();

            if (id) {
                var data = {
                    'idObjek': id,
                }

                $.ajax({
                    method: "GET",
                    url: "{{ route('ObjekRetribusi.detailObjekToTarif') }}",
                    data: data,
                    success: function (response) {
                        if (response.status == 404) {
                            new Noty({
                                text: response.message,
                                type: 'warning',
                                modal: true
                            }).show();
                        } else {
                            $("#noBangunan").val(response.objekRetribusi.noBangunan);
                            $("#jenisObjekRetribusi").val(response.objekRetribusi.jenisObjekRetribusi);
                            $("#lokasiObjekRetribusi").val(response.objekRetribusi.lokasiObjekRetribusi);
                            $("#alamatWajibRetribusi").text(response.objekRetribusi.alamatLengkap);
                            $("#panjangTanah").val(response.objekRetribusi.panjangTanah);
                            $("#lebarTanah").val(response.objekRetribusi.lebarTanah);
                            $("#luasTanah").val(response.objekRetribusi.luasTanah);
                            $("#panjangBangunan").val(response.objekRetribusi.panjangBangunan);
                            $("#lebarBangunan").val(response.objekRetribusi.lebarBangunan);
                            $("#luasBangunan").val(response.objekRetribusi.luasBangunan);
                            $("#jumlahLantai").val(response.objekRetribusi.jumlahLantai);
                            $("#kapasitas").val(response.objekRetribusi.kapasitas);
                        }
                    }
                });
            }
        });

        $("#checkebox-md").on("change", function () {
            if ($(this).prop("checked")) {
                $(".tanggal-dinilai").prop("disabled", false); // enable the input field
                $("#namaPenilai").prop("disabled", false); // enable the input field
            } else {
                $(".tanggal-dinilai").prop("disabled", true); // disable the input field
                $("#namaPenilai").prop("disabled", true); // disable the input field
            }
        });
    });

</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Tarif Objek Retribusi</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Objek Retribusi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Tarif Objek Restribusi</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
<div class="row">
    <div class="col-xl-12">

        <form class="row g-3 needs-validation" action="{{route('ObjekRetribusi.storeTarif')}}" method="post"
            enctype="multipart/form-data" novalidate>
            {{ csrf_field() }}
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Tambah Tarif Objek Restribusi
                    </div>
                </div>
                <div class="card-body tambah-wajib-retribusi p-0">
                    <div class="p-4">
                        <div class="row gx-5">
                            <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                                <div class="card custom-card shadow-none mb-0 border-0">
                                    <div class="card-body p-0">
                                        <div class="row gy-3">
                                            <div class="col-xl-12">
                                                <label for="objek-retribusi" class="form-label">Nama Objek
                                                    Retribusi</label>
                                                <select class="objek-retribusi form-control" name="objekRetribusi"
                                                    id="objekRetribusi" required>
                                                    <option></option>
                                                    @foreach ($objekRetribusi as $oR)
                                                        <option value="{{ $oR->idObjekRetribusi }}">
                                                            {{ $oR->kodeObjekRetribusi }} - {{ $oR->objekRetribusi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Objek Retribusi Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="nik" class="form-label">Nomor bangunan</label>
                                                <input type="text" class="form-control" id="noBangunan" disabled>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="nik" class="form-label">Jenis Objek Retribusi</label>
                                                <input type="text" class="form-control" id="jenisObjekRetribusi"
                                                    disabled>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="nik" class="form-label">Lokasi Objek Retribusi</label>
                                                <input type="text" class="form-control" id="lokasiObjekRetribusi"
                                                    disabled>
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="alamat-wajib-retribusi" class="form-label">Alamat Objek
                                                    Retribusi</label>
                                                <textarea class="form-control" id="alamatWajibRetribusi" rows="2"
                                                    name="alamatWajibRetribusi" disabled></textarea>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="panajng-tanah" class="form-label">Panjang Tanah
                                                    (meter)</label>
                                                <input type="text" class="form-control" id="panjangTanah"
                                                    name="panjangTanah" disabled>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="lebar-tanah" class="form-label">Lebar Tanah (meter)</label>
                                                <input type="text" class="form-control" id="lebarTanah"
                                                    name="lebarTanah" disabled>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="luas-tanah" class="form-label">Luas Tanah (meter)</label>
                                                <input type="text" class="form-control" id="luasTanah" name="luasTanah"
                                                    name="luasTanah" disabled>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="panjang-bangunan" class="form-label">Panjang Bangunan
                                                    (meter)</label>
                                                <input type="text" class="form-control" id="panjangBangunan"
                                                    name="panjangBangunan" disabled>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="lebar-bangunan" class="form-label">Lebar Bangunan
                                                    (meter)</label>
                                                <input type="text" class="form-control" id="lebarBangunan"
                                                    name="lebarBangunan" disabled>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="luas-bangunan" class="form-label">Luas Bangunan
                                                    (meter)</label>
                                                <input type="text" class="form-control" id="luasBangunan"
                                                    name="luasBangunan" disabled>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="jumlah-lantai" class="form-label">Jumlah Lantai</label>
                                                <input type="text" class="form-control" id="jumlahLantai"
                                                    name="jumlahLantai" disabled>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kapasistas" class="form-label">Kapasitas (orang)</label>
                                                <input type="text" class="form-control" id="kapasitas" name="kapasitasi"
                                                    disabled>
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
                                                <label for="jangka-waktu-sewa" class="form-label">Perioditas</label>
                                                <select class="jangka-waktu-sewa form-control" name="jangkaWaktu"
                                                    required>
                                                    <option></option>
                                                    @foreach ($jangkaWaktu as $jW)
                                                        <option value="{{ $jW->idjenisJangkaWaktu }}">
                                                            {{ $jW->jenisJangkaWaktu }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Jenis Jangka Waktu Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="nomor-whatsapp" class="form-label">Tanggal Dinilai</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-text text-muted"> <i
                                                                class="ri-calendar-line"></i> </div>
                                                        <input type="text" class="form-control tanggal-dinilai"
                                                            id="tanggalDinilai" name="tanggalDinilai"
                                                            placeholder="Pilih Tanggal Penilaian" required disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="nama-penilai" class="form-label">Status Penilaian</label>
                                                <div style="display: flex;  align-items: center;  height: 50%;">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        id="checkebox-md" name="statusPenilaian">
                                                    <label class="form-check-label" for="statusPenilaian"
                                                        style="margin-left: 5px; padding-top:2px;">
                                                        Sudah Dinilai
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <label for="nama-penilai" class="form-label">Nama Penilai</label>
                                                <input type="text" class="form-control" id="namaPenilai"
                                                    name="namaPenilai" placeholder="Masukkan Nama  Penilai" required
                                                    disabled>
                                                <div class="invalid-feedback">
                                                    Nama Penilai Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="nominal-tarif" class="form-label">Tarif Objek
                                                    Retribusi</label>
                                                <input type="text" class="form-control" id="tarif-objek"
                                                    name="tarifObjek"
                                                    placeholder="Masukkan Tarif Objek Retribusi" required>
                                                <div class="invalid-feedback">
                                                    Nominal Tarif Objek Retribusi Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="harga-tanah" class="form-label">Harga Tanah</label>
                                                <input type="number" class="form-control" id="harga-tanah" min="0"
                                                    value="0" name="hargaTanah" placeholder="Masukkan Harga Tanah">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="harga-Bangunan" class="form-label">Harga Bangunan</label>
                                                <input type="number" class="form-control" id="harga-bangunan"min="0"
                                                value="0" name="hargaBangunan" placeholder="Masukkan Harga Bangunan">
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <textarea class="form-control" id="keterangan" rows="3"
                                                    name="keterangan" placeholder="Masukkan Keterangan"></textarea>
                                            </div>
                                            <div class="col-xl-12 product-documents-container">
                                                <label for="keterangan" class="form-label">Upload File Hasil
                                                    Penilaian</label>
                                                <input class="form-control" type="file" id="filePenilaian"
                                                    name="filePenilaian">
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