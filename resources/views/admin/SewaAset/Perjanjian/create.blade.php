@extends('layouts.admin.template')
@section('content')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        /* single select with placeholder */
        $(".permohonan-sewa").select2({
            placeholder: "Pilih Nomor Permohonan",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        $(".jangka-waktu-sewa").select2({
            placeholder: "Pilih Jangka Waktu Sewa",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        $(".disahkan-oleh").select2({
            placeholder: "Pilih Pejabat",
            allowClear: true,
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        });

        /* For Human Friendly dates */
        flatpickr("#tanggalDisahkan", {
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "m/d/Y",
            disableMobile: true
        });

        flatpickr("#tanggalAwal", {
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "m/d/Y",
            disableMobile: true
        });

        flatpickr("#tanggalAkhir", {
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "m/d/Y",
            disableMobile: true
        });

        $('#permohonanSewa').on('change', function () {
            var id = $(this).val();

            //console.log(id);

            if (id) {
                var data = {
                    'idPermohonan': id,
                }

                $.ajax({
                    method: "GET",
                    url: "{{ route('Perjanjian.detailPermohonanToPerjanjian') }}",
                    data: data,
                    success: function (response) {
                        if (response.status == 404) {
                            new Noty({
                                text: response.message,
                                type: 'warning',
                                modal: true
                            }).show();
                        } else {
                            $("#kodeObjek").val(response.permohonanSewa.kodeObjekRetribusi);
                            $("#noBangunan").val(response.permohonanSewa.noBangunan);
                            $("#alamatObjek").val(response.permohonanSewa.alamatObjekRetribusi);
                            $("#npwrd").val(response.permohonanSewa.npwrd);
                            $("#wajibRetribusi").val(response.permohonanSewa.namaWajibRetribusi);
                            $("#alamatWajib").val(response.permohonanSewa.alamatWajibRetribusi);
                            $("#jenisPermohonan").val(response.permohonanSewa.jenisPermohonan);
                            $("#idJenisPermohonan").val(response.permohonanSewa.idJenisPermohonan);
                            $("#peruntukanSewa").val(response.permohonanSewa.peruntukanSewa);
                            $("#perioditasSewa").val(response.permohonanSewa.jenisJangkaWaktu);
                            $("#lamaSewa").val(response.permohonanSewa.lamaSewa);
                            $("#Satuan").val(response.permohonanSewa.namaSatuan);
                            $("#luasTanah").val(response.permohonanSewa.luasTanah);
                            $("#luasBangunan").val(response.permohonanSewa.luasBangunan);
                        }
                    }
                });
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // jQuery button click event to add Saksi row
        $("#tambahSaksi").on("click", function () {

            // Adding a row inside the tbody.
            $("#tblSaksi tbody").append('<tr>' +
                '<td>' +
                '<input type="text" class="form-control" id="nik" name="nik[]" placeholder="Masukkan NIP" required>' +
                '<div class="invalid-feedback">' +
                'NIP Tidak Boleh Kosong' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<input type="text" class="form-control" id="namaSaksi" name="namaSaksi[]" placeholder="Masukkan Nama Saksi" required>' +
                '<div class="invalid-feedback">' +
                'Nama Saksi Tidak Boleh Kosong' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<textarea class="form-control" id="keterangan" rows="2" name="keteranganSaksi[]"' +
                'placeholder="Masukkan Keterangan"></textarea>' +
                '</td>' +
                '<td  style="text-align: center">' +
                '<button class="btn btn-sm btn-icon btn-danger-light" type="button" id="delSaksi"><i class="ri-delete-bin-5-line"></i></button>' +
                '</td>' +
                '</tr>');
        });

        $(document).on('click', '#delSaksi', function () {
            $(this).closest('tr').remove();
            return false;
        });
    });
</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Perjanjian Sewa</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Sewa Aset</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Perjanjian Sewa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Perjanjian Sewa</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
<div class="row">
    <div class="col-xl-12">

        <form class="row g-3 needs-validation" action="{{route('Perjanjian.store')}}" method="post" enctype="multipart/form-data" novalidate>
            {{ csrf_field() }}
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Tambah Perjanjian Sewa
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
                                                <label for="permohonan-sewa" class="form-label">Nomor Permohonan
                                                    Sewa</label>
                                                <select class="form-control permohonan-sewa" id="permohonanSewa"  name="permohonanSewa"
                                                    required>
                                                    <option></option>
                                                    @foreach ($permohonanSewa as $pS)
                                                        <option value="{{ $pS->idPermohonanSewa }}">
                                                            {{ $pS->nomorSuratPermohonan }} - {{ $pS->objekRetribusi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Objek Retribusi Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="kodeObjek" class="form-label">Kode Objek Retribusi</label>
                                                <input type="text" class="form-control" id="kodeObjek" disabled>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="nik" class="form-label">Nomor Bangunan</label>
                                                <input type="text" class="form-control" id="noBangunan" disabled>
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="alamat-wajib-retribusi" class="form-label">Alamat Objek
                                                    Retribusi</label>
                                                <textarea class="form-control" id="alamatObjek" rows="2"
                                                    name="alamatObjekRetribusi" disabled></textarea>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="npwrd" class="form-label">NPWRD</label>
                                                <input type="text" class="form-control" id="npwrd" name="npwrd" readonly>
                                            </div>
                                            <div class="col-xl-8">
                                                <label for="nik" class="form-label">Nama Wajib Retribusi</label>
                                                <input type="text" class="form-control" id="wajibRetribusi" disabled>
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="alamat-wajib-retribusi" class="form-label">Alamat Wajib
                                                    Retribusi</label>
                                                <textarea class="form-control" id="alamatWajib" rows="2"
                                                    name="alamatWajibRetribusi" disabled></textarea>
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="keterangan" class="form-label">Keterangan/Catatan</label>
                                                <textarea class="form-control" id="keterangan" rows="2"
                                                    name="keterangan"></textarea>
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
                                                <label for="jangka-waktu-sewa" class="form-label">Jenis
                                                    Permohonan</label>
                                                <input type="hidden" class="form-control" id="idJenisPermohonan" name="idJenisPermohonan">
                                                <input type="text" class="form-control" id="jenisPermohonan" disabled>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="jangka-waktu-sewa" class="form-label">Peruntukan
                                                    Sewa</label>
                                                <input type="text" class="form-control" id="peruntukanSewa" disabled>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="jangka-waktu-sewa" class="form-label">Luas Tanah (m<sup>2</sup>)</label>
                                                <input type="text" class="form-control" id="luasTanah" name="luasTanah" readonly>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="jangka-waktu-sewa" class="form-label">Luas Bangunan (m<sup>2</sup>)</label>
                                                <input type="text" class="form-control" id="luasBangunan" name="luasBangunan" readonly>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="jangka-waktu-sewa" class="form-label">Perioditas
                                                    Sewa</label>
                                                <input type="text" class="form-control" id="perioditasSewa" disabled>
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="jangka-waktu-sewa" class="form-label">Lama Sewa</label>
                                                <input type="text" class="form-control" id="lamaSewa" name="lamaSewa" readonly>
                                            </div>
                                            <div class="col-xl-2">
                                                <label for="jangka-waktu-sewa" class="form-label">Satuan</label>
                                                <input type="text" class="form-control" id="Satuan" disabled>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="nama-penilai" class="form-label">Nomor Surat
                                                    Perjanjian</label>
                                                <input type="text" class="form-control" id="noSuratPerjanjian"
                                                    name="noSuratPerjanjian"
                                                    placeholder="Masukkan Nomor Surat Perjanjian">
                                                <div class="invalid-feedback">
                                                    Nomor Surat Perjanjian Tidak Boleh Kosong
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="nomor-whatsapp" class="form-label">Tanggal Disahkan</label>
                                                <div class="form-group">
                                                    <div class="input-groupa">
                                                        <div class="input-group-text text-muted"> <i
                                                                class="ri-calendar-line"></i> </div>
                                                        <input type="text" class="form-control" id="tanggalDisahkan"
                                                            placeholder="Pilih Tanggal Disahkan" name="tanggalDisahkan">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="nomor-whatsapp" class="form-label">Tanggal Awal
                                                    Berlaku</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-text text-muted"> <i
                                                                class="ri-calendar-line"></i> </div>
                                                        <input type="text" class="form-control" id="tanggalAwal"
                                                            placeholder="Pilih Tanggal Awal" name="tanggalAwal">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="nomor-whatsapp" class="form-label">Tanggal Akhir
                                                    Berlaku</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-text text-muted"> <i
                                                                class="ri-calendar-line"></i> </div>
                                                        <input type="text" class="form-control" id="tanggalAkhir"
                                                            placeholder="Pilih Tanggal Berakhir" name="tanggalAkhir">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="col-xl-12 product-documents-container">
                                            <label for="nomor-whatsapp" class="form-label">Upload Surat Perjanjian</label>
                                                <input type="file" class="form-control" name="fileSuratPerjanjian"
                                                    data-max-file-size="5MB">
                                            </div>-->
                                            <div class="col-xl-12">
                                                <label for="alamat-wajib-retribusi" class="form-label">Disahkan Oleh:</label>
                                                <select class="form-control disahkan-oleh" id="disahkanOleh"  name="disahkanOleh"
                                                    required>
                                                    <option></option>
                                                    @foreach ($pegawai as $pG)
                                                        <option value="{{ $pG->idPegawai }}">
                                                            {{ $pG->namaJabatanBidang }} - {{ $pG->namaPegawai }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    Pejabat Yang Mensahkan Tidak Boleh Kosong
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 border-top">
                        <div class="d-sm-flex justify-content-end">
                            <button class="btn btn-primary m-1" id="tambahSaksi" type="button"><span
                                    class="bi bi-plus-circle align-middle me-1 fw-medium"></span>
                                Tambah Saksi
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-nowrap table-hover" id="tblSaksi">
                                <thead>
                                    <tr>
                                        <th>NIP</th>
                                        <th>Nama Saksi (Sesuai KTP)</th>
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