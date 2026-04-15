@extends('layouts.admin.template')
@section('content')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        /* map with markers */
        var latitude = {!! json_encode($objekRetribusi->latitute) !!};
        var longitude = {!! json_encode($objekRetribusi->longitude) !!};
        var namaObjek = {!! json_encode($objekRetribusi->objekRetribusi) !!};

        var map3 = new GMaps({
            el: '#map-markers',
            lat: latitude,
            lng: longitude
        });
        map3.addMarker({
            lat: latitude,
            lng: longitude,
            title: namaObjek,
            infoWindow: {
                content: '<p>HTML Content</p>'
            }
        });

        var lightboxVideo = GLightbox({
            selector: '.glightbox',
            width: '500px',
            height: 'auto'

        });
        lightboxVideo.on('slide_changed', ({ prev, current }) => {
            console.log('Prev slide', prev);
            console.log('Current slide', current);

            const { slideIndex, slideNode, slideConfig, player } = current;
        });
    });

</script>

<!-- Page Header -->
<div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Objek Retribusi</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb breadcrumb-example1 mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Objek Retribusi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Objek Retribusi</li>
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
                    Detail Objek Retribusi
                </div>
            </div>
            <div class="card-body detail-objek-retribusi p-0">
                <div class="p-4">
                    <div class="row gx-5">
                        <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                            <div class="card custom-card shadow-none mb-0 border-0">
                                <div class="card-body p-0">
                                    <div class="row gy-3">
                                        <div class="col-xl-3">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Kode Objek Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $objekRetribusi->kodeObjekRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-9">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">NPWRD</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $objekRetribusi->npwrd }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Nomor Bangunan</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $objekRetribusi->noBangunan }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Jenis Objek Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $objekRetribusi->jenisObjekRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Nama Objek Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $objekRetribusi->objekRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Lokasi Objek Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $objekRetribusi->lokasiObjekRetribusi }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-9">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Alamat Objek Retribusi</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $objekRetribusi->alamatLengkap }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Panjang Tanah (m)</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $objekRetribusi->panjangTanah }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Lebar Tanah (m)</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $objekRetribusi->lebarTanah }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Luas Tanah (m<sup>2</sup>)</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $objekRetribusi->luasTanah }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Panjang Bangunan (m)</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $objekRetribusi->panjangBangunan }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Lebar Bangunan (m)</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $objekRetribusi->lebarBangunan }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Luas Bangunan (m<sup>2</sup>)</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $objekRetribusi->luasBangunan }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Jumlah Lantai</h6>
                                                    <span
                                                        class="d-block fs-13 text-muted fw-normal">{{ $objekRetribusi->jumlahLantai }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 border-top">
                                            <br>
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Gambar Peta Tanah</h6>
                                                    <div id="map-markers"></div>
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
                                                    <h6 class="mb-1 fs-13">Batas Sebelah Utara</h6>
                                                    <span class="d-block fs-13 text-muted fw-normal">
                                                        @if(is_null($objekRetribusi->batasSelatan) || $objekRetribusi->batasSelatan == "null")
                                                            {!! "" !!}
                                                        @else
                                                            {{ $objekRetribusi->batasUtara }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Batas Sebelah Selatan</h6>
                                                    <span class="d-block fs-13 text-muted fw-normal">
                                                        @if(is_null($objekRetribusi->batasSelatan) || $objekRetribusi->batasSelatan == "null")
                                                            {{ "" }}
                                                        @else
                                                            {{ $objekRetribusi->batasSelatan }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Batas Sebelah Timur</h6>
                                                    <span class="d-block fs-13 text-muted fw-normal">
                                                        @if(is_null($objekRetribusi->batasTimur) || $objekRetribusi->batasTimur == "null")
                                                            {{ "" }}
                                                        @else
                                                            {{ $objekRetribusi->batasTimur }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Batas Sebelah Barat</h6>
                                                    <span class="d-block fs-13 text-muted fw-normal">
                                                        @if(is_null($objekRetribusi->batasBarat) || $objekRetribusi->batasBarat == "null")
                                                            {{ "" }}
                                                        @else
                                                            {{ $objekRetribusi->batasBarat }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill">
                                                    <h6 class="mb-1 fs-13">Keterangan</h6>
                                                    <span class="d-block fs-13 text-muted fw-normal">
                                                        @if(is_null($objekRetribusi->keterangan) || $objekRetribusi->keterangan == "null")
                                                            {{ "" }}
                                                        @else
                                                            {{ $objekRetribusi->keterangan }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 border-top">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill"><br>
                                                    <h6 class="mb-1 fs-13">Gambar Denah Tanah</h6>
                                                    @if($objekRetribusi->gambarDenahTanah)
                                                        <a target="_blank"
                                                            href="{{Storage::disk('biznet')->url('/' . $objekRetribusi->gambarDenahTanah)}}"
                                                            download="{{ $objekRetribusi->objekRetribusi }}"
                                                            class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover text-decoration-underline">
                                                            <i class="ri-download-2-line me-2"></i>Download Gambar/Dokumen
                                                            Denah Tanah
                                                        </a>
                                                    @else
                                                        <span class="d-block fs-13 text-muted fw-normal">File Gambar Denah
                                                            Tanah Tidak Tersedia.
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 border-top">
                                            <div class="d-flex gap-3">
                                                <div class="flex-fill"><br>
                                                    <h6 class="mb-1 fs-13">Foto-foto Objek Retribusi</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @if (isset($fotoObjek) && count($fotoObjek) > 0)
                                                    @foreach ($fotoObjek as $fO)
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                                            <a href="{{Storage::disk('biznet')->url('/' . $fO->photoObjekRetribusi)}}"
                                                                class="glightbox card" data-gallery="gallery1"
                                                                data-title="{{ $fO->namaPhotoObjekRetribusi }}"
                                                                data-width="300px" data-height="auto">
                                                                <img src="{{Storage::disk('biznet')->url('/' . $fO->photoObjekRetribusi)}}"
                                                                    alt="image" />
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <span class="d-block fs-13 text-muted fw-normal">Foto-foto Objek Retribusi
                                                        Tidak Tersedia.
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection