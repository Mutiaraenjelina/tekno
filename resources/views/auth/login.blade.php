<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light"
    data-header-styles="light" data-menu-styles="light" data-toggled="close" style="--primary-rgb: 35, 144, 190;">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> TAPATUPA </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="dashboard template,dashboard html,bootstrap admin,dashboard admin,admin template,sales dashboard,crypto dashboard,projects dashboard,html template,html,html css,admin dashboard template,html css bootstrap,dashboard html css,pos system,bootstrap dashboard">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('admin_resources/assets/images/brand-logos/favicon2.ico') }}" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="{{ asset('admin_resources/assets/js/authentication-main.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('admin_resources/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ asset('admin_resources/assets/css/styles.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ asset('admin_resources/assets/css/icons.css') }}" rel="stylesheet">

    <!-- Toastify CSS -->
    <link rel="stylesheet" href="{{ asset('admin_resources/assets/libs/toastify-js/src/toastify.css') }}">

    <!-- Toastify JS -->
    <script src="{{ asset('admin_resources/assets/libs/toastify-js/src/toastify.js') }}"></script>


</head>

<body class="authentication-background">
    <div class="container">
        <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="rounded my-4 bg-white basic-page">
                    <div class="basicpage-border"></div>
                    <div class="basicpage-border1"></div>
                    <div class="card-body p-5">
                        <div class="mb-3 d-flex justify-content-center">
                            @error('login_gagal')
                                <div class="toast align-items-center text-bg-danger border-0 fade show mb-4" role="alert"
                                    aria-live="assertive" aria-atomic="true">
                                    <div class="d-flex">
                                        <div class="toast-body">
                                            {{ $message }}
                                        </div>
                                        <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                            data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 d-flex justify-content-center">
                            <a href="index.html">
                                <img src="{{ asset('admin_resources/assets/images/user-general/patupa_logo_white_bg.png') }}"
                                    alt="logo" class="desktop-logo">
                                <img src="{{ asset('admin_resources/assets/images/user-general/patupa_logo_white_bg.png') }}"
                                    alt="logo" class="desktop-dark">
                            </a>
                        </div>
                        <p class="h4 fw-semibold mb-2 text-center">Login</p>
                        <!--<p class="mb-4 text-muted fw-normal text-center">Welcome back Jhon !</p> -->
                        <form action="{{url('proses_login')}}" method="POST" id="logForm">
                            {{ csrf_field() }}
                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label for="signin-username" class="form-label text-default">User Name</label>
                                    <input type="text" class="form-control" id="signin-username"
                                        placeholder="Masukkan Username" name="username">
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <!--<label for="signin-password" class="form-label text-default d-block">Password<a
                                            href="reset-password-basic.html"
                                            class="float-end  link-danger op-5 fw-medium fs-12">Lupa Password
                                            ?</a></label>-->
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="signin-password"
                                            placeholder="Masukkan Password" name="password">
                                        <a href="javascript:void(0);" class="input-group-text text-muted"
                                            onclick="createpassword('signin-password',this)"><i
                                                class="ri-eye-off-line align-middle"></i></a>
                                    </div>
                                    <div class="mt-2">
                                        <div class="form-check">
                                            <!--<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label text-muted fw-normal fs-12"
                                                for="defaultCheck1">
                                                Remember password ?
                                            </label>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid mt-4">
                                <button class="btn btn-primary btn-block" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="{{ asset('admin_resources/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Show Password JS -->
    <script src="{{ asset('admin_resources/assets/js/show-password.js') }}"></script>

</body>

</html>