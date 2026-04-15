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

        $(document).on('click', '.editFilePerjanjianBtn', function (e) {
            var sp_id = $(this).val();

            $('#ubahSuratPerjanjianModal').modal('show');
            $('#idFilePerjanjian').val(sp_id);
        });

        $(document).on('click', '.tambahSaksiBtn', function (e) {
            var fo_id = $(this).val();

            $('#tambahSaksiModal').modal('show');
            $('#idSaksiPerjanjianAdd').val(fo_id);
        });
        
            $(document).on('click', '.editSaksiBtn', function (e) {
                e.preventDefault();

                var sp_id = $(this).val();

                $('#ubahSaksiModal').modal('show');

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

    <!-- Page Header -->
    <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h1 class="page-title fw-medium fs-18 mb-2">Perjanjian Sewa</h1>
            <div class="">
                <nav>
                    <ol class="breadcrumb breadcrumb-example1 mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Sewa Aset</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Perjanjian Sewa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Perjanjian Sewa</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header Close -->

    <!-- Start:: row-1 -->
    <div class="row">
        <div class="col-xl-12">

            <form class="row g-3 needs-validation" action="{{route('Perjanjian.store')}}" method="post"
                enctype="multipart/form-data" novalidate>
                {{ csrf_field() }}
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Edit Perjanjian Sewa
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
                                                    <input type="hidden" id="permohonanSewa" name="permohonanSewa">
                                                    <input type="text" class="form-control" id="kodeObjek"
                                                        value="{{ $perjanjianSewa->nomorSuratPermohonan }} - {{ $perjanjianSewa->objekRetribusi}}"
                                                        disabled>
                                                    <div class="invalid-feedback">
                                                        Nomor Permohonan Tidak Boleh Kosong
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="kodeObjek" class="form-label">Kode Objek Retribusi</label>
                                                    <input type="text" class="form-control" id="permohonanSewa"
                                                        value="{{ $perjanjianSewa->kodeObjekRetribusi }}" disabled>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="nik" class="form-label">Nomor Bangunan</label>
                                                    <input type="text" class="form-control" id="noBangunan"
                                                        value="{{ $perjanjianSewa->noBangunan }}" disabled>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label for="alamat-wajib-retribusi" class="form-label">Alamat Objek
                                                        Retribusi</label>
                                                    <textarea class="form-control" id="alamatObjek" rows="2"
                                                        name="alamatObjekRetribusi"
                                                        disabled>{{ $perjanjianSewa->alamatObjekRetribusi }}</textarea>
                                                </div>
                                                <div class="col-xl-4">
                                                    <label for="npwrd" class="form-label">NPWRD</label>
                                                    <input type="text" class="form-control" id="npwrd" name="npwrd"
                                                        value="{{ $perjanjianSewa->npwrd }}" readonly>
                                                </div>
                                                <div class="col-xl-8">
                                                    <label for="nik" class="form-label">Nama Wajib Retribusi</label>
                                                    <input type="text" class="form-control" id="wajibRetribusi"
                                                        value="{{ $perjanjianSewa->namaWajibRetribusi }}" disabled>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label for="alamat-wajib-retribusi" class="form-label">Alamat Wajib
                                                        Retribusi</label>
                                                    <textarea class="form-control" id="alamatWajib" rows="2"
                                                        name="alamatWajibRetribusi"
                                                        disabled>{{ $perjanjianSewa->alamatObjekRetribusi }}</textarea>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label for="keterangan" class="form-label">Keterangan/Catatan</label>
                                                    <textarea class="form-control" id="keterangan" rows="2"
                                                        name="keterangan">{{ $perjanjianSewa->keterangan }}</textarea>
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
                                                    <input type="text" class="form-control" id="jenisPermohonan"
                                                        value="{{ $perjanjianSewa->jenisPermohonan }}" disabled>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="jangka-waktu-sewa" class="form-label">Peruntukan
                                                        Sewa</label>
                                                    <input type="text" class="form-control" id="peruntukanSewa"
                                                        value="{{ $perjanjianSewa->peruntukanSewa }}" disabled>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="jangka-waktu-sewa" class="form-label">Luas Tanah
                                                        (m<sup>2</sup>)</label>
                                                    <input type="text" class="form-control" id="luasTanah" name="luasTanah"
                                                        value="{{ $perjanjianSewa->luasTanah }}" readonly>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="jangka-waktu-sewa" class="form-label">Luas Bangunan
                                                        (m<sup>2</sup>)</label>
                                                    <input type="text" class="form-control" id="luasBangunan"
                                                        name="luasBangunan" value="{{ $perjanjianSewa->luasBangunan }}"
                                                        readonly>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="jangka-waktu-sewa" class="form-label">Perioditas
                                                        Sewa</label>
                                                    <input type="text" class="form-control" id="perioditasSewa"
                                                        value="{{ $perjanjianSewa->jenisJangkaWaktu }}" disabled>
                                                </div>
                                                <div class="col-xl-4">
                                                    <label for="jangka-waktu-sewa" class="form-label">Lama Sewa</label>
                                                    <input type="text" class="form-control" id="lamaSewa" name="lamaSewa"
                                                        value="{{ $perjanjianSewa->lamaSewa }}" readonly>
                                                </div>
                                                <div class="col-xl-2">
                                                    <label for="jangka-waktu-sewa" class="form-label">Satuan</label>
                                                    <input type="text" class="form-control" id="Satuan"
                                                        value="{{ $perjanjianSewa->namaSatuan }}" disabled>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="nama-penilai" class="form-label">Nomor Surat
                                                        Perjanjian</label>
                                                    <input type="text" class="form-control" id="noSuratPerjanjian"
                                                        name="noSuratPerjanjian"
                                                        value="{{ $perjanjianSewa->nomorSuratPerjanjian }}" disabled
                                                        placeholder="Masukkan Nomor Surat Perjanjian">
                                                    <div class="invalid-feedback">
                                                        Nomor Surat Perjanjian Tidak Boleh Kosong
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="nomor-whatsapp" class="form-label">Tanggal Disahkan</label>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-text text-muted"> <i
                                                                    class="ri-calendar-line"></i> </div>
                                                            <input type="text" class="form-control" id="tanggalDisahkan"
                                                                placeholder="Pilih Tanggal Disahkan" name="tanggalDisahkan"
                                                                value="{{ $perjanjianSewa->tanggalDisahkan }}">
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
                                                                placeholder="Pilih Tanggal Awal" name="tanggalAwal"
                                                                value="{{ $perjanjianSewa->tanggalAwalBerlaku }}">
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
                                                                placeholder="Pilih Tanggal Berakhir" name="tanggalAkhir"
                                                                value="{{ $perjanjianSewa->tanggalAkhirBerlaku }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label for="alamat-wajib-retribusi" class="form-label">Disahkan
                                                        Oleh:</label>
                                                    <select class="form-control disahkan-oleh" id="disahkanOleh"
                                                        name="disahkanOleh" required>
                                                        <option></option>
                                                        @foreach ($pegawai as $pG)
                                                            <option value="{{ $pG->idPegawai }}" {{ $pG->idPegawai === $perjanjianSewa->disahkanOleh ? 'selected' : '' }}>
                                                                {{ $pG->namaJabatanBidang }} - {{ $pG->namaPegawai }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Pejabat Yang Mensahkan Tidak Boleh Kosong
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table text-nowrap table-hover" id="tblFoto">
                                                        <thead>
                                                            <tr>
                                                                <th>Nama File Perjanjian Sewa Tanah</th>
                                                                <th width="30px">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-primary">
                                                                    @if($perjanjianSewa->fileName)
                                                                        {{ $perjanjianSewa->fileName }}
                                                                    @else
                                                                        File Surat Perjanjian tidak tersedia!
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button type="button"
                                                                        value="{{ $perjanjianSewa->idPerjanjianSewa }}"
                                                                        class="btn btn-icon btn-outline-teal btn-wave btn-sm editFilePerjanjianBtn">
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
                                <button class="btn btn-primary m-1 tambahSaksiBtn" id="tambahSaksi" type="button"
                                value="{{ $perjanjianSewa->idPerjanjianSewa }}"><span
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
                                        @if (isset($saksiPerjanjian) && count($saksiPerjanjian) > 0)
                                            @foreach ($saksiPerjanjian as $sP)
                                                <tr>
                                                    <td>{{ $sP->nip }}</td>
                                                    <td>{{ $sP->namaSaksi }}</td>
                                                    <td>{{ $sP->keterangan }}
                                                    </td>
                                                    <td>
                                                        <button type="button" value="{{ $sP->idSaksi }}"
                                                            class="btn btn-icon btn-outline-teal btn-wave btn-sm editSaksiBtn">
                                                            <i class="ri-edit-box-line"></i>
                                                        </button>
                                                        <a href="{{ route('ObjekRetribusi.deleteFotoObjek', $sP->idSaksi) }}">
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
    
    <!-- Start:: Edit File Surat Perjanjian-->
<div class="modal fade" id="ubahSuratPerjanjianModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah/Ubah File Surat Perjanjian Sewa</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row g-3 needs-validation" action="{{route('Perjanjian.updateFilePerjanjianSewa')}}" method="post"
                enctype="multipart/form-data" novalidate>
                {{ csrf_field() }}
                <input type="hidden" id="idFilePerjanjian" name="idFilePerjanjian">
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">Upload File Surat Perjanjian Sewa</h6>
                            <input type="file" class="denah-tanah form-control" name="filePerjanjianSewa">
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
<!-- End:: Edit File Surat Perjanjian -->


    <!-- Start:: Edit Saksi-saksi Perjanjian-->
<div class="modal fade" id="ubahSaksiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Ubah Saksi Perjanjian Sewa</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row g-3 needs-validation" action="{{route('ObjekRetribusi.updateFotoObjek')}}" method="post"
                enctype="multipart/form-data" novalidate>
                {{ csrf_field() }}
                <input type="hidden" id="idSaksiPerjanjian" name="idSaksiPerjanjian">
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">NIP</h6>
                            <input type="text" class="form-control" id="nip" name="nip"
                                placeholder="Masukkan NIP Saksi" required>
                            <div class="invalid-feedback">
                                NIP Saksi Perjanjian Tidak Boleh Kosong
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">Nama Saksi (Sesuai KTP)</h6>
                            <input type="text" class="form-control" id="namaSaksi" name="namaSaksi"
                                placeholder="Masukkan Nama Saksi" required>
                            <div class="invalid-feedback">
                                Nama Saksi Perjanjian Tidak Boleh Kosong
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">Keterangan</h6>
                            <textarea class="form-control" id="keteranganSaksi" rows="3" name="keteranganSaksi"
                                placeholder="Masukkan Keterangan Foto"></textarea>
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
<!-- End:: Edit Saksi-saksi Perjanjian -->

<!-- Start:: Add Foto Objek Retribusi-->
<div class="modal fade" id="tambahSaksiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Foto Objek Retribusi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row g-3 needs-validation" action="{{route('ObjekRetribusi.storeFotoObjek')}}" method="post"
                enctype="multipart/form-data" novalidate>
                {{ csrf_field() }}
                <input type="hidden" id="idSaksiPerjanjianAdd" name="idSaksiPerjanjianAdd">
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">NIP</h6>
                            <input type="text" class="form-control" id="nipAdd" name="nipAdd"
                                placeholder="Masukkan NIP Saksi" required>
                            <div class="invalid-feedback">
                                NIP Saksi Perjanjian Tidak Boleh Kosong
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">Nama Saksi (Sesuai KTP)</h6>
                            <input type="text" class="form-control" id="namaSaksiAdd" name="namaSaksiAdd"
                                placeholder="Masukkan Nama Saksi" required>
                            <div class="invalid-feedback">
                                Nama Saksi Perjanjian Tidak Boleh Kosong
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <h6 class="mb-1 fs-13">Keterangan</h6>
                            <textarea class="form-control" id="keteranganSaksiAdd" rows="3" name="keteranganSaksiAdd"
                                placeholder="Masukkan Keterangan Foto"></textarea>
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