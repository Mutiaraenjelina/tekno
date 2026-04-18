@php
    if (file_exists(public_path('admin_resources/assets/images/user-general/sipayda_logo.png'))) {
        $brandLogo = 'admin_resources/assets/images/user-general/sipayda_logo.png';
    } elseif (file_exists(public_path('admin_resources/assets/images/user-general/sipayda_logo.jpg'))) {
        $brandLogo = 'admin_resources/assets/images/user-general/sipayda_logo.jpg';
    } elseif (file_exists(public_path('admin_resources/assets/images/user-general/sipayda_logo.jpeg'))) {
        $brandLogo = 'admin_resources/assets/images/user-general/sipayda_logo.jpeg';
    } else {
        $brandLogo = 'admin_resources/assets/images/user-general/patupa_logo_white_bg.png';
    }
@endphp

<!DOCTYPE html>
<html lang="id" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light"
    data-header-styles="light" data-menu-styles="light" data-toggled="close" style="--primary-rgb: 35, 144, 190;">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIPAYDA - Register</title>

    <link rel="icon" href="{{ asset('admin_resources/assets/images/brand-logos/favicon2.ico') }}" type="image/x-icon">
    <script src="{{ asset('admin_resources/assets/js/authentication-main.js') }}"></script>
    <link id="style" href="{{ asset('admin_resources/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_resources/assets/css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_resources/assets/css/icons.css') }}" rel="stylesheet">
    <style>
        .brand-logo-fit-auth {
            width: 330px;
            height: 118px;
            object-fit: contain;
            object-position: center;
            mix-blend-mode: multiply;
            filter: contrast(1.08) saturate(1.06);
        }

        .role-info {
            border: 1px solid #dce3ea;
            border-radius: 10px;
            padding: 12px 14px;
            background: #f7fcff;
            color: #1f2d3d;
            font-size: 14px;
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
                            <img src="{{ asset($brandLogo) }}"
                                alt="logo" class="desktop-logo brand-logo-fit-auth">
                        </div>

                        <p class="h4 fw-semibold mb-2 text-center">Register Admin UMKM</p>
                        <p class="text-muted text-center mb-4">Pendaftaran ini khusus Admin UMKM. Lengkapi profil usaha agar Super Admin dapat memantau UMKM Anda.</p>

                        @if($errors->has('register_gagal'))
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first('register_gagal') }}
                            </div>
                        @endif

                        <form action="{{ route('proses_register') }}" method="POST" id="registerForm">
                            @csrf

                            <div class="row gy-3">
                                <div class="col-md-12">
                                    <div class="role-info">
                                        Role akun yang dibuat: <strong>Admin UMKM</strong>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap"
                                        value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="no_telepon" class="form-label">Nomor Telepon / WhatsApp</label>
                                    <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon"
                                        value="{{ old('no_telepon') }}" placeholder="Contoh: 62812345678" required>
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="nama_usaha" class="form-label">Nama Usaha</label>
                                    <input type="text" class="form-control @error('nama_usaha') is-invalid @enderror" id="nama_usaha" name="nama_usaha"
                                        value="{{ old('nama_usaha') }}" placeholder="Masukkan nama usaha" required>
                                    @error('nama_usaha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="jenis_usaha" class="form-label">Jenis Usaha</label>
                                    <input type="text" class="form-control @error('jenis_usaha') is-invalid @enderror" id="jenis_usaha" name="jenis_usaha"
                                        value="{{ old('jenis_usaha') }}" placeholder="Contoh: Kuliner, Parkir, Retail" required>
                                    @error('jenis_usaha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="jenis_tagihan" class="form-label">Jenis Tagihan Usaha</label>
                                    <select class="form-select @error('jenis_tagihan') is-invalid @enderror" id="jenis_tagihan" name="jenis_tagihan" required>
                                        <option value="">Pilih Jenis Tagihan</option>
                                        <option value="rutin" {{ old('jenis_tagihan') === 'rutin' ? 'selected' : '' }}>Rutin</option>
                                        <option value="non-rutin" {{ old('jenis_tagihan') === 'non-rutin' ? 'selected' : '' }}>Non Rutin</option>
                                    </select>
                                    @error('jenis_tagihan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                <a href="{{ route('login') }}" class="text-primary">Sudah punya akun admin? Masuk di sini</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin_resources/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
