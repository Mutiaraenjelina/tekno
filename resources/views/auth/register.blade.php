<!DOCTYPE html>
<html lang="id" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light"
    data-header-styles="light" data-menu-styles="light" data-toggled="close" style="--primary-rgb: 35, 144, 190;">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TAPATUPA - Register</title>

    <link rel="icon" href="{{ asset('admin_resources/assets/images/brand-logos/favicon2.ico') }}" type="image/x-icon">
    <script src="{{ asset('admin_resources/assets/js/authentication-main.js') }}"></script>
    <link id="style" href="{{ asset('admin_resources/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_resources/assets/css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_resources/assets/css/icons.css') }}" rel="stylesheet">
    <style>
        .jenis-card {
            border: 1px solid #dce3ea;
            border-radius: 10px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            height: 100%;
            background: #fff;
        }

        .jenis-card:hover {
            border-color: #2390be;
            box-shadow: 0 4px 14px rgba(35, 144, 190, 0.12);
        }

        .jenis-card.active {
            border-color: #2390be;
            background: #f3fafe;
            box-shadow: 0 4px 14px rgba(35, 144, 190, 0.18);
        }

        .jenis-card .title {
            font-weight: 700;
            margin-bottom: 4px;
            color: #1f2d3d;
        }

        .jenis-card .desc {
            color: #667085;
            font-size: 13px;
            margin: 0;
        }

        .section-box {
            border: 1px dashed #dce3ea;
            border-radius: 10px;
            padding: 14px;
            background: #fbfdff;
        }
    </style>
</head>

<body class="authentication-background">
    <div class="container">
        <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10 col-sm-11 col-12">
                <div class="rounded my-4 bg-white basic-page">
                    <div class="basicpage-border"></div>
                    <div class="basicpage-border1"></div>
                    <div class="card-body p-4 p-md-5">
                        <div class="mb-3 d-flex justify-content-center">
                            <img src="{{ asset('admin_resources/assets/images/user-general/patupa_logo_white_bg.png') }}"
                                alt="logo" class="desktop-logo">
                        </div>

                        <p class="h4 fw-semibold mb-2 text-center">Register Pengguna</p>
                        <p class="text-muted text-center mb-4">Pilih jenis usaha terlebih dahulu, lalu isi data sesuai jenis tagihan</p>

                        @if($errors->has('register_gagal'))
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first('register_gagal') }}
                            </div>
                        @endif

                        <form action="{{ route('proses_register') }}" method="POST" id="registerForm">
                            @csrf

                            <div class="row gy-3">
                                <div class="col-md-12">
                                    <label class="form-label">Jenis Tagihan Usaha</label>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="jenis-card" data-jenis="rutin" id="card-rutin">
                                                <div class="title">Tagihan Rutin</div>
                                                <p class="desc">Perlu data pelanggan karena tagihan berulang setiap periode.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="jenis-card" data-jenis="non_rutin" id="card-non-rutin">
                                                <div class="title">Tagihan Non Rutin</div>
                                                <p class="desc">Tidak wajib isi data pelanggan untuk registrasi awal.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="jenis_tagihan" name="jenis_tagihan" value="{{ old('jenis_tagihan') }}">
                                    @error('jenis_tagihan')
                                        <div class="text-danger mt-2 small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12" id="pelanggan-section">
                                    <div class="section-box">
                                        <p class="fw-semibold mb-2">Data Pelanggan</p>
                                        <div class="row g-3">
                                            <div class="col-md-6 pelanggan-field">
                                                <label for="nama" class="form-label">Nama Pelanggan</label>
                                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                                                    value="{{ old('nama') }}" placeholder="Masukkan nama pelanggan">
                                                @error('nama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 pelanggan-field">
                                                <label for="no_wa" class="form-label">No. WhatsApp</label>
                                                <input type="text" class="form-control @error('no_wa') is-invalid @enderror" id="no_wa" name="no_wa"
                                                    value="{{ old('no_wa') }}" placeholder="Contoh: 081234567890">
                                                @error('no_wa')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username"
                                        value="{{ old('username') }}" placeholder="Masukkan username" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                        value="{{ old('email') }}" placeholder="Masukkan email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                                        placeholder="Minimal 6 karakter" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                        placeholder="Ulangi password" required>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button class="btn btn-primary btn-block" type="submit">Daftar</button>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="text-primary">Sudah punya akun? Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin_resources/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jenisTagihan = document.getElementById('jenis_tagihan');
            const pelangganFields = document.querySelectorAll('.pelanggan-field input');
            const pelangganSection = document.getElementById('pelanggan-section');
            const cardRutin = document.getElementById('card-rutin');
            const cardNonRutin = document.getElementById('card-non-rutin');

            function setJenisTagihan(jenis) {
                jenisTagihan.value = jenis;
                togglePelangganFields();
            }

            function togglePelangganFields() {
                const isRutin = jenisTagihan.value === 'rutin';

                cardRutin.classList.toggle('active', isRutin);
                cardNonRutin.classList.toggle('active', jenisTagihan.value === 'non_rutin');
                pelangganSection.classList.toggle('d-none', !isRutin);

                pelangganFields.forEach(function (input) {
                    input.required = isRutin;

                    if (!isRutin) {
                        input.value = '';
                    }
                });
            }

            cardRutin.addEventListener('click', function () {
                setJenisTagihan('rutin');
            });

            cardNonRutin.addEventListener('click', function () {
                setJenisTagihan('non_rutin');
            });

            if (!jenisTagihan.value) {
                jenisTagihan.value = 'rutin';
            }

            togglePelangganFields();
        });
    </script>
</body>

</html>
