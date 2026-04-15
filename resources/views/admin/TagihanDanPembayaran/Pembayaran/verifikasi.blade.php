@extends('layouts.admin.template')
@section('content')
<script>
    //-------------------------------------------------------------------------------------------------
    //Ajax Delete Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.verifikasi_data', function (e) {
        e.preventDefault();
        var pembayaranId = $(this).val();

        $("#verifikasiModal").modal('show');
        $('#idPembayaran').val(pembayaranId);
        var keterangan = $('#keterangan').val();

       
    });
</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Verifikasi Pembayaran sewa</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Tagihan Dan Pembayaran</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pembayaran Sewa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Verifikasi Pembayaran Sewa</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Detail Pembayaran Sewa
                </div>
            </div>
            <div class="card-body detail-objek-retribusi p-0">
                <div class="p-4">
                    <div class="row gx-5">
                        <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                            <div class="card custom-card shadow-none mb-0 border-0">
                                <div class="card-body p-0">
                                    <div class="row gy-3">
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Nomor Invoice</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $headPembayaran->noInvoice }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Tanggal Cetak</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ date('d F Y', strtotime($headPembayaran->tanggalCetak)) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">NPWRD</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $headPembayaran->npwrd }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Nama Wajib Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $headPembayaran->namaWajibRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Alamat Wajib Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $headPembayaran->alamatWajibRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Kode Objek Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $headPembayaran->kodeObjekRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Nama Objek Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $headPembayaran->objekRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Alamat Objek Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $headPembayaran->alamatLengkap }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Total Pembayaran</h6>
                                                    <span class="d-block fs-13 text-muted fw-normal">Rp.
                                                        {{ $headPembayaran->totalBayar }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Status Pembayaran</h6>
                                                    <span
                                                        class="badge bg-success">{{ $headPembayaran->namaStatus }}</span>
                                                </div>
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
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Nama Bank</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $headPembayaran->namaStatus }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Nama Pemilik Rekening</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $headPembayaran->namaPemilikRek }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Jumlah Dana Yang Dibayarkan</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $headPembayaran->jumlahDana }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Keterangan</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $headPembayaran->keterangan }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">File Bukti Pembayaran</h6>
                                                    <span class="d-block fs-13 text-muted fw-normal">
                                                        @if($headPembayaran->fileBuktiBayar)
                                                            <a target="_blank"
                                                                href="{{Storage::disk('biznet')->url('/' . $headPembayaran->fileBuktiBayar)}}"
                                                                download="{{ $headPembayaran->noInvoice }}"
                                                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover text-decoration-underline">
                                                                <i class="ri-download-2-line me-2"></i>Download
                                                                File Bukti Bayar - {{ $headPembayaran->noInvoice }}
                                                            </a>
                                                        @else
                                                            <span class="d-block fs-13 text-muted fw-normal">File Gambar
                                                                File Bukti Bayar Tidak Tersedia.
                                                            </span>
                                                        @endif

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-center">
                            <button class="btn btn-primary m-1 verifikasi_data" type="button"
                                value="{{ $headPembayaran->idPembayaranSewa }}">Verifikasi <i
                                    class="bi bi-check-square ms-2 ms-1 align-middle d-inline-block"></i></button>
                            <!--<button class="btn btn-danger m-1" type="button"
                                value="{{ $headPembayaran->idBuktiBayar }}">Tolak<i
                                    class="bi bi-x-square ms-2 align-middle d-inline-block"></i></button>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Start:: Verifikasi Pembayaran-->
<div class="modal fade" id="verifikasiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Verifikasi Pembayaran Sewa</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row g-3 needs-validation" action="{{route('Pembayaran.storeVerifikasi')}}" method="post"
                enctype="multipart/form-data" novalidate>
                {{ csrf_field() }}
                <input type="hidden" id="idPembayaran" name="idPembayaran">
                <div class="modal-body px-4">
                    <div class="d-flex gap-3">
                        <div class="flex-fill">
                            <label for="keterangan" class="form-label">Catatn</label>
                            <textarea class="form-control" id="keterangan" name="keterangan"
                                placeholder="Masukkan Catatan" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary m-1" type="submit">Verifikasi <i
                            class="bi bi-floppy ms-2 ms-1 align-middle d-inline-block"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End:: Verifikasi Pembayaran -->
@endsection