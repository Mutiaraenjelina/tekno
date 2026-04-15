<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed"
    data-theme-mode="light" style="--primary-rgb: 35, 144, 190;">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> TAPATUPA - Transformasi Pengelolaan Aset Tanah </title>
    <meta name="Description" content="TAPATUPA - Transformasi Pengelolaan Aset Tanah">
    <meta name="Ardiles Sinaga" content="Badan Keuangan dan Aset Daerah">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('admin_resources/assets/images/brand-logos/favicon2.ico') }}" type="image/x-icon">

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('admin_resources/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ asset('admin_resources/assets/css/styles.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ asset('admin_resources/assets/css/icons.css') }}" rel="stylesheet">

    <!-- Node Waves Css -->
    <link href="{{ asset('admin_resources/assets/libs/node-waves/waves.min.css') }}" rel="stylesheet">

    <!-- SwiperJS Css -->
    <link rel="stylesheet" href="{{ asset('admin_resources/assets/libs/swiper/swiper-bundle.min.css') }}">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('admin_resources/assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_resources/assets/libs/@simonwep/pickr/themes/nano.min.css') }}">

    <!-- Choices Css -->
    <link rel="stylesheet"
        href="{{ asset('admin_resources/assets/libs/choices.js/public/assets/styles/choices.min.css') }}">

    <script>
        if (localStorage.udonlandingdarktheme) {
            document.querySelector("html").setAttribute("data-theme-mode", "dark")
        }
        if (localStorage.udonlandingrtl) {
            document.querySelector("html").setAttribute("dir", "rtl")
            document.querySelector("#style")?.setAttribute("href", "../assets/libs/bootstrap/css/bootstrap.rtl.min.css");
        }
    </script>


</head>

<body class="landing-body">

    <div class="landing-page-wrapper">

        <!-- app-header -->
        <header class="app-header">

            <!-- Start::main-header-container -->
            <div class="main-header-container container-fluid">

                <!-- Start::header-content-left -->
                <div class="header-content-left">

                    <!-- Start::header-element -->
                    <div class="header-element">
                        <div class="horizontal-logo">
                            <a href="index.html" class="header-logo">
                                <img src="{{ asset('admin_resources/assets/images/brand-logos/desktop-logo.png') }}"
                                    alt="logo" class="desktop-logo">
                                <img src="{{ asset('admin_resources/assets/images/brand-logos/toggle-logo.png') }}"
                                    alt="logo" class="toggle-logo">
                                <img src="{{ asset('admin_resources/assets/images/brand-logos/desktop-dark.png') }}"
                                    alt="logo" class="desktop-dark">
                                <img src="{{ asset('admin_resources/assets/images/brand-logos/toggle-dark.png') }}"
                                    alt="logo" class="toggle-dark">
                            </a>
                        </div>
                    </div>
                    <!-- End::header-element -->
                    <!-- End::header-element -->

                    <!-- Start::header-element -->
                    <div class="header-element">
                        <!-- Start::header-link -->
                        <a href="javascript:void(0);" class="sidemenu-toggle header-link" data-bs-toggle="sidebar">
                            <span class="open-toggle">
                                <i class="ri-menu-3-line fs-20"></i>
                            </span>
                        </a>
                        <!-- End::header-link -->
                    </div>
                    <!-- End::header-element -->

                </div>
                <!-- End::header-content-left -->

            </div>
            <!-- End::main-header-container -->

        </header>
        <!-- /app-header -->

        <!-- Start::app-sidebar -->
        <aside class="app-sidebar sticky" id="sidebar">

            <div class="container-xl">
                <!-- Start::main-sidebar -->
                <div class="main-sidebar">

                    <!-- Start::nav -->
                    <nav class="main-menu-container nav nav-pills sub-open">
                        <div class="landing-logo-container">
                            <div class="horizontal-logo">
                                <a href="{{ "/home" }}" class="header-logo">
                                    <img src="{{ asset('admin_resources/assets/images/user-general/patupa_logo_white_bg.png') }}"
                                        alt="logo" class="desktop-logo">
                                    <img src="{{ asset('admin_resources/assets/images/user-general/patupa_logo_white_bg.png') }}"
                                        alt="logo" class="desktop-dark">
                                </a>
                            </div>
                        </div>
                        <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                                width="24" height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                            </svg></div>
                        <ul class="main-menu">
                            <!-- Start::slide -->
                            <li class="slide">
                                <a class="side-menu__item" href="#home">
                                    <span class="side-menu__label">Home</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#tentangKami" class="side-menu__item">
                                    <span class="side-menu__label">Tentang Kami</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#tujuan" class="side-menu__item">
                                    <span class="side-menu__label">Tujuan</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#fitur" class="side-menu__item">
                                    <span class="side-menu__label">Fitur-Fitur</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#pembayaran" class="side-menu__item">
                                    <span class="side-menu__label">Pembayaran</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#kontak" class="side-menu__item">
                                    <span class="side-menu__label">Kontak Kami</span>
                                </a>
                            </li>
                            <!-- End::slide -->

                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                                width="24" height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                                </path>
                            </svg></div>
                        <div class="d-lg-flex d-none">
                            <div class="btn-list d-lg-flex d-none mt-lg-2 mt-xl-0 mt-0">
                                <a href="{{ route('login') }}" class="btn btn-wave btn-secondary">
                                    Login
                                </a>
                            </div>
                        </div>
                    </nav>
                    <!-- End::nav -->

                </div>
                <!-- End::main-sidebar -->
            </div>

        </aside>
        <!-- End::app-sidebar -->

        <!-- Start::app-content -->
        <div class="main-content landing-main px-0">

            <!-- Start:: Section-1 -->
            <div class="landing-banner" id="home">
                <section class="section">
                    <div class="container main-banner-container pb-lg-0">
                        <div class="row">
                            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8">
                                <div class="py-lg-5">
                                    <div class="mb-3">
                                        <h3 class="fw-medium text-fixed-white op-9">TAPATUPA</h3>
                                    </div>
                                    <p class="landing-banner-heading mb-3"><span class="fw-semibold">Transformasi
                                            Pengelolaan Aset Tanah </span>Kabupaten Tapanuli Utara</p>
                                    <div class="fs-16 mb-5 text-fixed-white op-7">TAPATUPA - Mewujudkan transparansi,
                                        akuntabilitas, dan efisiensi serta berkelanjutan, sehingga dapat memberikan
                                        manfaat yang lebih besar bagi masyarakat dan pembangunan daerah.</div>
                                </div>
                            </div>
                            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-4 my-auto">
                                <div class="text-end landing-main-image landing-heading-img">
                                    <img src="{{ asset('admin_resources/assets/images/user-general/patupa_logo_white_bg.png') }}"
                                        alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- End:: Section-1 -->

            <!-- Start:: Section-2 -->
            <section class="section" id="tentangKami">
                <div class="container position-relative">
                    <div class="row gx-5 mx-0">
                        <div class="col-xl-5">
                            <div class="home-proving-image">
                                <img src="../assets/images/media/landing/2.png" alt=""
                                    class="img-fluid] about-image d-none d-xl-block">
                            </div>
                            <div class="proving-pattern-1"></div>
                        </div>
                        <div class="col-xl-7 my-auto">
                            <div class="heading-section text-start mb-4">
                                <p class="fs-12 fw-medium text-start text-success mb-1"><span
                                        class="landing-section-heading text-primary">TENTANG KAMI</span>
                                </p>
                                <h3 class="mt-3 fw-semibold mb-2">Exceeding your Expectations !</h3>
                                <div class="heading-description fs-16">Welcome to Vibro, where we offer a unique and
                                    tailored
                                    experience that is sure to exceed your expectations. Choose us and let us show you
                                    what true excellence looks like</div>
                            </div>
                            <div class="row gy-3 mb-0">
                                <div class="col-xl-12">
                                    <div class="d-flex align-items-top">
                                        <div class="me-2 home-prove-svg">
                                            <i
                                                class="ri-shining-line align-middle fs-14 text-primary d-inline-block"></i>
                                        </div>
                                        <div>
                                            <span class="fs-15">
                                                We have years of experience in our industry and have built a reputation.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="d-flex align-items-top">
                                        <div class="me-2 home-prove-svg">
                                            <i
                                                class="ri-shining-line align-middle fs-14 text-primary d-inline-block"></i>
                                        </div>
                                        <div>
                                            <span class="fs-15">
                                                Our team is made up of experienced and professional individuals.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="d-flex align-items-top">
                                        <div class="me-2 home-prove-svg">
                                            <i
                                                class="ri-shining-line align-middle fs-14 text-primary d-inline-block"></i>
                                        </div>
                                        <div>
                                            <span class="fs-15">
                                                We understand that every client is unique, and we tailor our services.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="d-flex align-items-top">
                                        <div class="me-2 home-prove-svg">
                                            <i
                                                class="ri-shining-line align-middle fs-14 text-primary d-inline-block"></i>
                                        </div>
                                        <div>
                                            <span class="fs-15">
                                                Our services are designed to be convenient and hassle-free, saving you
                                                time and effort.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="d-flex align-items-top">
                                        <div class="me-2 home-prove-svg">
                                            <i
                                                class="ri-shining-line align-middle fs-14 text-primary d-inline-block"></i>
                                        </div>
                                        <div>
                                            <span class="fs-15">
                                                We provide 24/7 support each day in a week for all 365 days.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-2 -->

            <!-- Start:: Section-3 -->
            <section class="section" id="tujuan">
                <div class="container">
                    <div class="text-center">
                        <p class="fs-12 fw-medium text-success mb-1"><span
                                class="landing-section-heading text-primary">TUJUAN</span>
                        </p>
                        <h3 class="fw-semibold mt-3 mb-2">Tujuan Proyek Perubahan</h3>
                        <div class="row justify-content-center">
                            <div class="col-xl-7">
                                <p class="text-muted fs-15 mb-5 fw-normal">Tujuan utama proyek perubahan transformasi
                                    pengelolaan aset daerah</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="card custom-card landing-card">
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <span
                                            class="svg-gradient avatar avatar-lg bg-primary mx-auto svg-container svg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M215,168.71a96.42,96.42,0,0,1-30.54,37l-9.36-9.37a8,8,0,0,0-3.63-2.09L150,188.59a8,8,0,0,1-5.88-8.9l2.38-16.2a8,8,0,0,1,4.84-6.22l30.46-12.66a8,8,0,0,1,8.47,1.49ZM159.89,105,182.06,79.2A8,8,0,0,0,184,74V50A96,96,0,0,0,50.49,184.65l9.92-6.52A8,8,0,0,0,64,171.49l.21-36.23a8.06,8.06,0,0,1,1.35-4.41l20.94-31.3a8,8,0,0,1,11.34-2l19.81,13a8.06,8.06,0,0,0,5.77,1.45l31.46-4.26A8,8,0,0,0,159.89,105Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,16a87.5,87.5,0,0,1,48,14.28V74L153.83,99.74,122.36,104l-.31-.22L102.38,90.92A16,16,0,0,0,79.87,95.1L58.93,126.4a16,16,0,0,0-2.7,8.81L56,171.44l-3.27,2.15A88,88,0,0,1,128,40ZM62.29,186.47l2.52-1.65A16,16,0,0,0,72,171.53l.21-36.23L93.17,104a3.62,3.62,0,0,0,.32.22l19.67,12.87a15.94,15.94,0,0,0,11.35,2.77L156,115.59a16,16,0,0,0,10-5.41l22.17-25.76A16,16,0,0,0,192,74V67.67A87.87,87.87,0,0,1,211.77,155l-16.14-14.76a16,16,0,0,0-16.93-3l-30.46,12.65a16.08,16.08,0,0,0-9.68,12.45l-2.39,16.19a16,16,0,0,0,11.77,17.81L169.4,202l2.36,2.37A87.88,87.88,0,0,1,62.29,186.47ZM185,195l-4.3-4.31a16,16,0,0,0-7.26-4.18L152,180.85l2.39-16.19L184.84,152,205,170.48A88.43,88.43,0,0,1,185,195Z">
                                                </path>
                                            </svg>
                                    </div>
                                    <h6 class="fw-semibold">Pengelolaan Aset</h6>
                                    <p class="fs-15 text-muted mb-0"> Pengelolaan aset tanah yang efektif, efisien, dan
                                        akuntabel serta tepat guna.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card custom-card landing-card">
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <div class="mb-4">
                                            <span
                                                class="svg-gradient avatar avatar-lg bg-primary mx-auto svg-container svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M208,40V208H152V40Z" opacity="0.2"></path>
                                                    <path
                                                        d="M224,200h-8V40a8,8,0,0,0-8-8H152a8,8,0,0,0-8,8V80H96a8,8,0,0,0-8,8v40H48a8,8,0,0,0-8,8v64H32a8,8,0,0,0,0,16H224a8,8,0,0,0,0-16ZM160,48h40V200H160ZM104,96h40V200H104ZM56,144H88v56H56Z">
                                                    </path>
                                                </svg>
                                        </div>
                                    </div>
                                    <h6 class="fw-semibold">Peningkatan Pendapatan</h6>
                                    <p class="fs-15 text-muted mb-0"> Meningkatkan pendapatan asli daerah untuk
                                        kesejahteraan masyarakat.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card custom-card landing-card">
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <span
                                            class="svg-gradient avatar avatar-lg bg-primary mx-auto svg-container svg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M16,152H48v56H16a8,8,0,0,1-8-8V160A8,8,0,0,1,16,152ZM204,56a28,28,0,0,0-12,2.71h0A28,28,0,1,0,176,85.29h0A28,28,0,1,0,204,56Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M230.33,141.06a24.43,24.43,0,0,0-21.24-4.23l-41.84,9.62A28,28,0,0,0,140,112H89.94a31.82,31.82,0,0,0-22.63,9.37L44.69,144H16A16,16,0,0,0,0,160v40a16,16,0,0,0,16,16H120a7.93,7.93,0,0,0,1.94-.24l64-16a6.94,6.94,0,0,0,1.19-.4L226,182.82l.44-.2a24.6,24.6,0,0,0,3.93-41.56ZM16,160H40v40H16Zm203.43,8.21-38,16.18L119,200H56V155.31l22.63-22.62A15.86,15.86,0,0,1,89.94,128H140a12,12,0,0,1,0,24H112a8,8,0,0,0,0,16h32a8.32,8.32,0,0,0,1.79-.2l67-15.41.31-.08a8.6,8.6,0,0,1,6.3,15.9ZM164,96a36,36,0,0,0,5.9-.48,36,36,0,1,0,28.22-47A36,36,0,1,0,164,96Zm60-12a20,20,0,1,1-20-20A20,20,0,0,1,224,84ZM164,40a20,20,0,0,1,19.25,14.61,36,36,0,0,0-15,24.93A20.42,20.42,0,0,1,164,80a20,20,0,0,1,0-40Z">
                                                </path>
                                            </svg>
                                    </div>
                                    <h6 class="fw-semibold">Pertumbuhan Ekonomi</h6>
                                    <p class="fs-15 text-muted mb-0">Mendukung pertumbuhan ekonomi daerah.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card custom-card landing-card">
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <span
                                            class="svg-gradient avatar avatar-lg bg-primary mx-auto svg-container svg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path d="M168,100a60,60,0,1,1-60-60A60,60,0,0,1,168,100Z" opacity="0.2">
                                                </path>
                                                <path
                                                    d="M144,157.68a68,68,0,1,0-71.9,0c-20.65,6.76-39.23,19.39-54.17,37.17a8,8,0,0,0,12.25,10.3C50.25,181.19,77.91,168,108,168s57.75,13.19,77.87,37.15a8,8,0,0,0,12.25-10.3C183.18,177.07,164.6,164.44,144,157.68ZM56,100a52,52,0,1,1,52,52A52.06,52.06,0,0,1,56,100Zm197.66,33.66-32,32a8,8,0,0,1-11.32,0l-16-16a8,8,0,0,1,11.32-11.32L216,148.69l26.34-26.35a8,8,0,0,1,11.32,11.32Z">
                                                </path>
                                            </svg>
                                    </div>
                                    <h6 class="fw-semibold">Perlindungan Hak</h6>
                                    <p class="fs-15 text-muted mb-0">Melindungi hak- hak masyarakat.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-3 -->

            <!-- Start:: Section-4 -->
            <section class="section landing-Features" id="fitur">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-8">
                            <div class="heading-section text-center mb-0">
                                <p class="fs-12 fw-medium text-success mb-1"><span
                                        class="landing-section-heading landing-section-heading-dark text-fixed-white">FITUR-FITUR</span>
                                </p>
                                <h3 class="text-fixed-white text-center mt-3 fw-medium">FITUR UTAMA TAPATUPA</h3>
                                <div class="fs-16 text-fixed-white text-center op-8">Ullamco ea commodo.Sed ut
                                    perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                    laudantium, totam rem aperiam.perspiciatis unde omnis.</div>
                            </div>
                        </div>
                        <div class="col-xl-10 my-auto">
                            <div
                                class="d-flex align-items-center justify-content-center trusted-companies sub-card-companies flex-wrap mb-3 mb-xl-0 gap-4">
                                <div class="trust-img"><img src="../assets/images/media/landing/web/1.png" alt="img"
                                        class="border-0"></div>
                                <div class="trust-img"><img src="../assets/images/media/landing/web/2.png" alt="img"
                                        class="border-0"></div>
                                <div class="trust-img"><img src="../assets/images/media/landing/web/4.png" alt="img"
                                        class="border-0"></div>
                                <div class="trust-img"><img src="../assets/images/media/landing/web/5.png" alt="img"
                                        class="border-0"></div>
                                <div class="trust-img"><img src="../assets/images/media/landing/web/6.png" alt="img"
                                        class="border-0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-4 -->

            <!-- Start:: Section-6
            <section class="section" id="team">
                <div class="container">
                    <div class="text-center">
                        <p class="fs-12 fw-medium text-success mb-1"><span
                                class="landing-section-heading text-primary">OUR TEAM</span>
                        </p>
                        <h3 class="fw-semibold mt-3 mb-2">The people who make our organization Successful</h3>
                        <div class="row justify-content-center">
                            <div class="col-xl-7">
                                <p class="text-muted fs-15 mb-5 fw-normal">Our team is made up of real people who are
                                    passionate about what they do.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-lg-0 mb-4">
                            <div class="card custom-card  team-card text-center">
                                <div class="top-left"></div>
                                <div class="top-right"></div>
                                <div class="bottom-left"></div>
                                <div class="bottom-right"></div>
                                <div class="card-body"> <img src="../assets/images/media/landing/team/1.png"
                                        class="avatar avatar-xxl mb-4 mb-3 border p-1 bg-light landing-team-img mt-2"
                                        alt="...">
                                    <div class="text-center py-2">
                                        <h5 class="mb-0 fw-medium">Charlie John</h5>
                                        <p class="mb-1 fs-14 fw-medium text-primary">HR Manager</p>
                                        <p class="mb-0 fs-13 text-muted op-8">Aliquam ullamcorper neque vitae dui
                                            ullamcorper, at varius erat feugiat. Proin aliquam, purus ut.</p>
                                        <div class="d-flex justify-content-center mt-3">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light"><i
                                                    class="ri-twitter-x-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-facebook-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-instagram-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-linkedin-fill"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-lg-0 mb-4">
                            <div class="card custom-card  team-card text-center">
                                <div class="top-left"></div>
                                <div class="top-right"></div>
                                <div class="bottom-left"></div>
                                <div class="bottom-right"></div>
                                <div class="card-body"> <img src="../assets/images/media/landing/team/2.png"
                                        class="avatar avatar-xxl mb-4 mb-3 border p-1 bg-light landing-team-img mt-2"
                                        alt="...">
                                    <div class="text-center py-2">
                                        <h5 class="mb-0 fw-medium">Marlin Shane</h5>
                                        <p class="mb-1 fs-14 fw-medium text-primary">Team Lead</p>
                                        <p class="mb-0 fs-13 text-muted op-8">Aliquam ullamcorper neque vitae dui
                                            ullamcorper, at varius erat feugiat. Proin aliquam, purus ut.</p>
                                        <div class="d-flex justify-content-center mt-3">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light"><i
                                                    class="ri-twitter-x-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-facebook-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-instagram-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-linkedin-fill"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-lg-0 mb-4">
                            <div class="card custom-card  team-card text-center">
                                <div class="top-left"></div>
                                <div class="top-right"></div>
                                <div class="bottom-left"></div>
                                <div class="bottom-right"></div>
                                <div class="card-body"> <img src="../assets/images/media/landing/team/3.png"
                                        class="avatar avatar-xxl mb-4 mb-3 border p-1 bg-light landing-team-img mt-2"
                                        alt="...">
                                    <div class="text-center py-2">
                                        <h5 class="mb-0 fw-medium">Angela Lia</h5>
                                        <p class="mb-1 fs-14 fw-medium text-primary">Project Manager</p>
                                        <p class="mb-0 fs-13 text-muted op-8">Aliquam ullamcorper neque vitae dui
                                            ullamcorper, at varius erat feugiat. Proin aliquam, purus ut.</p>
                                        <div class="d-flex justify-content-center mt-3">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light"><i
                                                    class="ri-twitter-x-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-facebook-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-instagram-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-linkedin-fill"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-lg-0 mb-4">
                            <div class="card custom-card  team-card text-center">
                                <div class="top-left"></div>
                                <div class="top-right"></div>
                                <div class="bottom-left"></div>
                                <div class="bottom-right"></div>
                                <div class="card-body"> <img src="../assets/images/media/landing/team/4.png"
                                        class="avatar avatar-xxl mb-4 mb-3 border p-1 bg-light landing-team-img mt-2"
                                        alt="...">
                                    <div class="text-center py-2">
                                        <h5 class="mb-0 fw-medium">Stella Daisy</h5>
                                        <p class="mb-1 fs-14 fw-medium text-primary">Head of Department</p>
                                        <p class="mb-0 fs-13 text-muted op-8">Aliquam ullamcorper neque vitae dui
                                            ullamcorper, at varius erat feugiat. Proin aliquam, purus ut.</p>
                                        <div class="d-flex justify-content-center mt-3">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light"><i
                                                    class="ri-twitter-x-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-facebook-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-instagram-fill"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="btn btn-icon btn-pil btn-primary-light ms-2"><i
                                                    class="ri-linkedin-fill"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            End:: Section-6 -->

            <!-- Start:: Section-7 -->
            <section class="section section-bg" id="pembayaran">
                <div class="container">
                    <div class="text-center">
                        <p class="fs-12 fw-medium text-success mb-1"><span
                                class="landing-section-heading text-primary">PEMBAYARAN</span>
                        </p>
                        <h3 class="fw-semibold mt-3 mb-2">Kemudahan pembayaran sewa objek retribusi</h3>
                        <div class="row justify-content-center">
                            <div class="col-xl-7">
                                <p class="text-muted fs-15 mb-5 fw-normal">Pembayaran sewa objek retribusi dapat
                                    dilakukan dengan QRIS dan tansfer ke rekening bank.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card custom-card landing-card pricing-card border shadow-none">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <p class="fs-18 fw-medium mb-1">QRIS</p>
                                        <p class="text-justify fw-medium mb-1">
                                            <span class="fs-2">$</span><span class="fs-2 me-1">0</span>
                                            <span class="fs-24"><span class="fs-20">/</span> month</span>
                                        </p>
                                        <p class="mb-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <p class="fs-12 mb-2 badge bg-primary-transparent text-primary">Billed monthly
                                            on regular basis!</p>
                                    </div>
                                    <ul class="text-justify list-unstyled pricing-body ps-0">
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> 2 Free
                                            Services
                                        </li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span>1 Month Pack
                                        </li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> No
                                            Agreement</li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> Money
                                            BackGuarantee</li>
                                        <li class="mb-0"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> 24/7
                                            support</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card custom-card landing-card pricing-card border shadow-none">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <p class="fs-18 fw-medium mb-1">Transfer Bank</p>
                                        <p class="text-justify fw-medium mb-1">
                                            <span class="fs-2">$</span><span class="fs-2 me-1">49</span>
                                            <span class="fs-24"><span class="fs-20">/</span> month</span>
                                        </p>
                                        <p class="mb-1">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        <p class="fs-12 mb-2 badge bg-primary-transparent text-primary">Billed monthly
                                            on regular basis!</p>
                                    </div>
                                    <ul class="text-justify list-unstyled pricing-body ps-0">
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> 10 Free
                                            Services
                                        </li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span>6 Months
                                            Pack
                                        </li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> 6 Months
                                            Agreement</li>
                                        <li class="mb-3"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> Money
                                            BackGuarantee</li>
                                        <li class="mb-0"><span class="me-1"><i
                                                    class="ri-shining-2-line text-primary fs-14"></i></span> 24/7
                                            support</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-7 -->

            <!-- Start:: Section-8
            <section class="section" id="faqs">
                <div class="container text-center">
                    <p class="fs-12 fw-medium text-success mb-1"><span
                            class="landing-section-heading text-primary">F.A.Q 's</span>
                    </p>
                    <h3 class="fw-semibold mt-3 mb-2">Frequently asked questions ?</h3>
                    <div class="row justify-content-center">
                        <div class="col-xl-7">
                            <p class="text-muted fs-15 mb-5 fw-normal">We have shared some of the most frequently asked
                                questions to help you out.</p>
                        </div>
                    </div>
                    <div class="row text-start">
                        <div class="col-xl-12">
                            <div class="row gy-2">
                                <div class="col-xl-6">
                                    <div class="accordion accordion-customicon1 accordion-primary accordions-items-seperate"
                                        id="accordionFAQ1">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon1One">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapsecustomicon1One" aria-expanded="true"
                                                    aria-controls="collapsecustomicon1One">
                                                    Where can I subscribe to your newsletter?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon1One" class="accordion-collapse collapse show"
                                                aria-labelledby="headingcustomicon1One" data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon1Two">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1Two"
                                                    aria-expanded="false" aria-controls="collapsecustomicon1Two">
                                                    Where can in edit my address?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon1Two" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon1Two" data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon1Three">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1Three"
                                                    aria-expanded="false" aria-controls="collapsecustomicon1Three">
                                                    What are your opening hours?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon1Three" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon1Three"
                                                data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon1Four">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1Four"
                                                    aria-expanded="false" aria-controls="collapsecustomicon1Four">
                                                    Do I have the right to return an item?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon1Four" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon1Four"
                                                data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon1Five">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1Five"
                                                    aria-expanded="false" aria-controls="collapsecustomicon1Five">
                                                    General Terms & Conditions (GTC)
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon1Five" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon1Five"
                                                data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon1Six">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon1Six"
                                                    aria-expanded="false" aria-controls="collapsecustomicon1Six">
                                                    Do I need to create an account to make an order?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon1Six" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon1Six" data-bs-parent="#accordionFAQ1">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="accordion accordion-customicon1 accordion-primary accordions-items-seperate"
                                        id="accordionFAQ2">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2Five">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Five"
                                                    aria-expanded="false" aria-controls="collapsecustomicon2Five">
                                                    General Terms & Conditions (GTC)
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2Five" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon2Five"
                                                data-bs-parent="#accordionFAQ2">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2Six">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Six"
                                                    aria-expanded="false" aria-controls="collapsecustomicon2Six">
                                                    Do I need to create an account to make an order?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2Six" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon2Six" data-bs-parent="#accordionFAQ2">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2One">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2One"
                                                    aria-expanded="true" aria-controls="collapsecustomicon2One">
                                                    Where can I subscribe to your newsletter?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2One" class="accordion-collapse collapse "
                                                aria-labelledby="headingcustomicon2One" data-bs-parent="#accordionFAQ2">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2Two">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Two"
                                                    aria-expanded="false" aria-controls="collapsecustomicon2Two">
                                                    Where can in edit my address?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2Two" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon2Two" data-bs-parent="#accordionFAQ2">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2Three">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsecustomicon2Three"
                                                    aria-expanded="false" aria-controls="collapsecustomicon2Three">
                                                    What are your opening hours?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2Three" class="accordion-collapse collapse"
                                                aria-labelledby="headingcustomicon2Three"
                                                data-bs-parent="#accordionFAQ2">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingcustomicon2Four">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapsecustomicon2Four" aria-expanded="false"
                                                    aria-controls="collapsecustomicon2Four">
                                                    Do I have the right to return an item?
                                                </button>
                                            </h2>
                                            <div id="collapsecustomicon2Four" class="accordion-collapse collapse show"
                                                aria-labelledby="headingcustomicon2Four"
                                                data-bs-parent="#accordionFAQ2">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is
                                                    shown by
                                                    default, until the collapse plugin adds the appropriate classes that
                                                    we
                                                    use to style each element. These classes control the overall
                                                    appearance,
                                                    as well as the showing and hiding via CSS transitions. You can
                                                    modify
                                                    any of this with custom CSS or overriding our default variables.
                                                    It's
                                                    also worth noting that just about any HTML can go within the
                                                    <code>.accordion-body</code>, though the transition does limit
                                                    overflow.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            End:: Section-8 -->

            <!-- Start:: Section-9
            <section class="section landing-Features" id="testimonials">
                <div class="container reviews-container">
                    <div class="row justify-content-center">
                        <div class="col-xl-10">
                            <div class="text-center mb-0 mt-4 heading-section">
                                <p class="fs-12 fw-medium text-success mb-1"><span
                                        class="landing-section-heading landing-section-heading-dark text-fixed-white">TESTIMONALS</span>
                                </p>
                                <div class="h3 mt-3 text-fixed-white">Have a look at what people say About Us</div>
                                <div class="fs-15 text-fixed-white mb-4 op-8">We care about our customer satisfaction
                                    and
                                    experience.</div>
                            </div>
                        </div>
                        <div class="col-xl-10">
                            <div class="swiper pagination-dynamic testimonialSwiperService">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="card mb-0 text-fixed-white position-relative">
                                            <i class="bx bxs-quote-alt-left review-quote review-quote1"></i> <i
                                                class="bx bxs-quote-alt-right review-quote review-quote2"></i>
                                            <div class="card-body p-4 text-fixed-white">
                                                <div class="d-sm-flex align-items-start gap-3">
                                                    <div> <img src="../assets/images/faces/4.jpg" alt="img"
                                                            class="text-center avatar avatar-xl rounded-circle border-5 border border-white-1 mb-2 mb-sm-0">
                                                    </div>
                                                    <div class="me-4">
                                                        <h5 class="mb-0 text-fixed-white">Penny Black</h5>
                                                        <div class="mb-2 text-fixed-white fs-15"> <i
                                                                class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i> <i class="ri-star-fill"></i> <i
                                                                class="ri-star-half-line"></i>
                                                        </div>
                                                        <p class="mb-0 op-9 fs-14"> "To achieve error-free paradigms,
                                                            organizations must foster a culture of continuous
                                                            improvement and quality assurance. By implementing robust
                                                            processes, conducting thorough testing, and leveraging
                                                            automation tools, businesses can minimize errors and
                                                            ensure." </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card mb-0 text-fixed-white position-relative">
                                            <i class="bx bxs-quote-alt-left review-quote review-quote1"></i> <i
                                                class="bx bxs-quote-alt-right review-quote review-quote2"></i>
                                            <div class="card-body p-4 text-fixed-white">
                                                <div class="d-sm-flex align-items-start gap-3">
                                                    <div> <img src="../assets/images/faces/3.jpg" alt="img"
                                                            class="text-center avatar avatar-xl rounded-circle border-5 border border-white-1 mb-2 mb-sm-0">
                                                    </div>
                                                    <div class="me-4">
                                                        <h5 class="mb-0 text-fixed-white">Laura Norda</h5>
                                                        <div class="mb-2 text-fixed-white fs-15"> <i
                                                                class="ri-star-fill"></i> <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i> <i class="ri-star-fill"></i> <i
                                                                class="ri-star-half-line"></i>
                                                        </div>
                                                        <p class="mb-0 op-9 fs-14"> "The ability to tailor strategies to
                                                            meet specific objectives and adapt to changing market
                                                            dynamics is paramount. Embracing innovation as a core value
                                                            allows companies to stay ahead of the curve, consistently
                                                            delivering value to their customers while maintaining a
                                                            competitive." </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card mb-0  text-fixed-white position-relative">
                                            <i class="bx bxs-quote-alt-left review-quote review-quote1"></i> <i
                                                class="bx bxs-quote-alt-right review-quote review-quote2"></i>
                                            <div class="card-body p-4 text-fixed-white">
                                                <div class="d-sm-flex align-items-start gap-3">
                                                    <div> <img src="../assets/images/faces/2.jpg" alt="img"
                                                            class="text-center avatar avatar-xl rounded-circle border-5 border border-white-1 mb-2 mb-sm-0">
                                                    </div>
                                                    <div class="me-4">
                                                        <h5 class="mb-0 text-fixed-white">Percy Kewsh</h5>
                                                        <div class="mb-2 text-fixed-white fs-15"> <i
                                                                class="ri-star-fill"></i> <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i> <i class="ri-star-fill"></i> <i
                                                                class="ri-star-half-line"></i>
                                                        </div>
                                                        <p class="mb-0 op-9 fs-14"> "In today's rapidly evolving
                                                            business landscape, it is essential to efficiently innovate
                                                            customized growth strategies that propel organizations
                                                            toward success. By analyzing market trends, consumer
                                                            behavior, and competitive landscapes, businesses can
                                                            identify unique." </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card mb-0 text-fixed-white position-relative">
                                            <i class="bx bxs-quote-alt-left review-quote review-quote1"></i> <i
                                                class="bx bxs-quote-alt-right review-quote review-quote2"></i>
                                            <div class="card-body p-4 text-fixed-white">
                                                <div class="d-sm-flex align-items-start gap-3">
                                                    <div> <img src="../assets/images/faces/3.jpg" alt="img"
                                                            class="text-center avatar avatar-xl rounded-circle border-5 border border-white-1 mb-2 mb-sm-0">
                                                    </div>
                                                    <div class="me-4">
                                                        <h5 class="mb-0 text-fixed-white">Laura Norda</h5>
                                                        <div class="mb-2 text-fixed-white fs-15"> <i
                                                                class="ri-star-fill"></i> <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i> <i class="ri-star-fill"></i> <i
                                                                class="ri-star-half-line"></i>
                                                        </div>
                                                        <p class="mb-0 op-9 fs-14"> "The ability to tailor strategies to
                                                            meet specific objectives and adapt to changing market
                                                            dynamics is paramount. Embracing innovation as a core value
                                                            allows companies to stay ahead of the curve, consistently
                                                            delivering value to their customers while maintaining a
                                                            competitive." </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card mb-0 text-fixed-white position-relative">
                                            <i class="bx bxs-quote-alt-left review-quote review-quote1"></i> <i
                                                class="bx bxs-quote-alt-right review-quote review-quote2"></i>
                                            <div class="card-body p-4 text-fixed-white">
                                                <div class="d-sm-flex align-items-start gap-3">
                                                    <div> <img src="../assets/images/faces/2.jpg" alt="img"
                                                            class="text-center avatar avatar-xl rounded-circle border-5 border border-white-1 mb-2 mb-sm-0">
                                                    </div>
                                                    <div class="me-4">
                                                        <h5 class="mb-0 text-fixed-white">Percy Kewsh</h5>
                                                        <div class="mb-2 text-fixed-white fs-15"> <i
                                                                class="ri-star-fill"></i> <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i> <i class="ri-star-fill"></i> <i
                                                                class="ri-star-half-line"></i>
                                                        </div>
                                                        <p class="mb-0 op-9 fs-14"> "In today's rapidly evolving
                                                            business landscape, it is essential to efficiently innovate
                                                            customized growth strategies that propel organizations
                                                            toward success. By analyzing market trends, consumer
                                                            behavior, and competitive landscapes, businesses can
                                                            identify unique." </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card mb-0 text-fixed-white position-relative">
                                            <i class="bx bxs-quote-alt-left review-quote review-quote1"></i> <i
                                                class="bx bxs-quote-alt-right review-quote review-quote2"></i>
                                            <div class="card-body p-4 text-fixed-white">
                                                <div class="d-sm-flex align-items-start gap-3">
                                                    <div> <img src="../assets/images/faces/6.jpg" alt="img"
                                                            class="text-center avatar avatar-xl rounded-circle border-5 border border-white-1 mb-2 mb-sm-0">
                                                    </div>
                                                    <div class="me-4">
                                                        <h5 class="mb-0 text-fixed-white">Audie Yose</h5>
                                                        <div class="mb-2 text-warning fs-15"> <i
                                                                class="ri-star-fill"></i> <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i> <i class="ri-star-fill"></i> <i
                                                                class="ri-star-half-line"></i>
                                                        </div>
                                                        <p class="mb-0 op-9 fs-14"> "The QuantumGlide Smart Hoverboard
                                                            has exceeded my expectations! Not only does it look
                                                            futuristic with its sleek design, but the ride is incredibly
                                                            smooth. The app connectivity is a standout feature - I can
                                                            customize the LED lights to match my mood and track my
                                                            rides.
                                                            " </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            End:: Section-9 -->

            <!-- Start:: Section-10 -->
            <section class="section" id="kontak">
                <div class="container text-center">
                    <p class="fs-12 fw-medium text-success mb-1"><span
                            class="landing-section-heading text-primary">KONTAK KAMI</span>
                    </p>
                    <h3 class="fw-semibold mt-3 mb-2">Ada pertanyaan? Kami dengan senang hati mendengarkanmu.</h3>
                    <div class="row justify-content-center">
                        <div class="col-xl-9">
                            <p class="text-muted fs-15 mb-5 fw-normal">Kamu dapat menghubungi kami kapanpun terkait
                                dengan aplikasi TAPATUPA. Kami akan membantu Anda memdapatkan pengalaman yang luar biasa
                                dalam menggunakan aplikasi TAPATUPA.</p>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row text-start">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 pe-0">
                                <div class="p-5 bg-light rounded">
                                    <div class="row gy-3">
                                        <div class="col-xl-6">
                                            <div class="row gy-3">
                                                <div class="col-xl-12">
                                                    <label for="contact-address-name" class="form-label ">Nama Lengkap
                                                        :</label>
                                                    <input type="text" class="form-control" id="contact-address-name"
                                                        placeholder="Masukkan Nama Lengkap">
                                                </div>
                                                <div class="col-xl-12">
                                                    <label for="contact-address-phone" class="form-label ">Nomor
                                                        Telepon/WhatsApp
                                                        :</label>
                                                    <input type="text" class="form-control" id="contact-address-phone"
                                                        placeholder="Masukkan Nomor Telepon/WhatsApp">
                                                </div>
                                                <div class="col-xl-12">
                                                    <label for="contact-address-address" class="form-label">Alamat
                                                        :</label>
                                                    <textarea class="form-control" id="contact-address-address"  placeholder="Masukkan Alamat"
                                                        rows="2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="contact-address-message" class="form-label ">Pesan
                                                :</label>
                                            <textarea class="form-control" id="contact-address-message"
                                                rows="8"></textarea>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="d-flex  mt-3">
                                                <div class="">
                                                    <div class="btn-list">
                                                        <a class="btn btn-icon btn-primary-light btn-wave" target="blank" href="https://www.facebook.com/share/p/vaZp2ZCCgq7wxRke/?mibextid=WC7FNe">
                                                            <i class="ri-facebook-line fw-bold"></i>
                                                        </a>
                                                        <a class="btn btn-icon btn-primary-light btn-wave" target="blank" href="https://youtu.be/dwy0ry3QJ-k?feature=shared">
                                                            <i class="ri-youtube-line fw-bold"></i>
                                                        </a>
                                                        <a class="btn btn-icon btn-primary-light btn-wave" target="blank" href="https://www.instagram.com/p/C-1ohzPT_eU/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA%3D%3D&img_index=1">
                                                            <i class="ri-instagram-line fw-bold"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="btn btn-primary  btn-wave">Kirim Pesan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 pe-0">
                                <div class="p-4 landing-contact-info border rounded">
                                    <div class="">
                                        <div class="fs-18 text-primary fw-medium mb-3">Informasi Kontak</div>
                                        <div class="mb-3 text-default"> <i
                                                class="ri-map-pin-fill me-2 text-primary"></i> Jl. Letjend Soeprapto
                                            No.1 Tarutung 22411 Kabupaten Tapanuli Utara Provinsi Sumatera Utara. </div>
                                        <div class="d-flex"> <i
                                                class="ri-phone-fill me-2 d-inline-block text-primary"></i>
                                            <div class="text-default mb-3">
                                                <div>(0633) 21713</div>
                                            </div>&nbsp;&nbsp;&nbsp;
                                            <span>
                                                <div class="text-default">
                                                    <div>
                                                    <i class="ri-printer-fill me-2 d-inline-block text-primary"></i> (0633) 20885</div>
                                                </div>
                                            </span>
                                        </div>
                                        <div class="mb-4 text-default"><i
                                                class="ri-mail-fill me-2 d-inline-block text-primary"></i>
                                            bkadkabtaput@gmail.com</div>
                                    </div>
                                    <div class="">
                                        <div class="card custom-card border mb-0 shadow-none overflow-hidden">
                                            <div style="overflow:hidden;max-width:100%;width:600px;height:175px;">
                                                <div id="embedded-map-display"
                                                    style="height:100%; width:100%;max-width:100%;"><iframe
                                                        style="height:100%;width:100%;border:0;" frameborder="0"
                                                        src="https://www.google.com/maps/embed/v1/search?q=Jl.+Letjend.+Suprapto+No.1,+Hutagalung+Siwaluompu,+Kec.+Tarutung,+Kabupaten+Tapanuli+Utara,+Sumatera+Utara+22411&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8"></iframe>
                                                </div><a class="embed-ded-maphtml"
                                                    href="https://www.bootstrapskins.com/themes"
                                                    id="enable-maps-data">premium bootstrap themes</a>
                                                <style>
                                                    #embedded-map-display img {
                                                        max-width: none !important;
                                                        background: none !important;
                                                        font-size: inherit;
                                                        font-weight: inherit;
                                                    }
                                                </style>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-10 -->

            <!-- Start:: Section-11 -->
            <section class="section landing-footer text-fixed-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-sm-6 col-12 mb-md-0 mb-3">
                            <div class="px-4">
                            <p class="fw-medium mb-3"><a href="{{ "/home" }}"><img height="40px"
                            src="{{ asset('admin_resources/assets/images/user-general/patupa_logo_white_bg.png') }}" alt=""></a></p>
                                <p class="mb-2 op-6 fw-normal">
                                    Badan Keuangan dan Aset Daerah bertanggungjawab atas penganggaran APBD,
                                    penatausahaan keuangan, pengelolaan aset daerah dan penyusunan laporan serta
                                    pertanggungjawaban pelaksanaan APBD secara efektif, efesien dan akuntabel
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="px-4">
                                <h6 class="fw-medium text-fixed-white">INFO</h6>
                                <ul class="list-unstyled op-6 fw-normal landing-footer-list">
                                    <li>
                                        <a href="#kontak" class="text-fixed-white">Kontak Kami</a>
                                    </li>
                                    <li>
                                        <a href="#tentangKami" class="text-fixed-white">Tentang Kami</a>
                                    </li>
                                    <li>
                                        <a href="#tujuan" class="text-fixed-white">Tujuan</a>
                                    </li>
                                    <li>
                                        <a href="#fitur" class="text-fixed-white">Fitur-Fitur</a>
                                    </li>
                                    <li>
                                        <a href="#pembayaran" class="text-fixed-white">Pembayaran</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="px-4">
                                <h6 class="fw-medium text-fixed-white">KONTAK</h6>
                                <ul class="list-unstyled fw-normal landing-footer-list">
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white op-6"><i
                                                class="ri-home-4-line me-1 align-middle"></i> Jl. Letjend Soeprapto
                                                No.1 Tarutung 22411 Kabupaten Tapanuli Utara Provinsi Sumatera Utara.</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white op-6"><i
                                                class="ri-mail-line me-1 align-middle"></i> bkadkabtaput@gmail.com</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white op-6"><i
                                                class="ri-phone-line me-1 align-middle"></i> (0633) 21713</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-fixed-white op-6"><i
                                                class="ri-printer-line me-1 align-middle"></i> (0633) 20885</a>
                                    </li>
                                    <li class="mt-3">
                                        <p class="mb-2 fw-medium op-8">IKUTI KAMI :</p>
                                        <div class="mb-0">
                                            <div class="btn-list">
                                                <a
                                                    class="btn btn-sm btn-icon btn-primary-light btn-wave waves-effect waves-light" target="blank" href="https://www.facebook.com/share/p/vaZp2ZCCgq7wxRke/?mibextid=WC7FNe">
                                                    <i class="ri-facebook-line fw-bold"></i>
                                                </a>
                                                <button
                                                    class="btn btn-sm btn-icon btn-primary-light btn-wave waves-effect waves-light" target="blank" href="https://www.instagram.com/p/C-1ohzPT_eU/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA%3D%3D&img_index=1">
                                                    <i class="ri-instagram-line fw-bold"></i>
                                                </button>
                                                <button
                                                    class="btn btn-sm btn-icon btn-primary-light btn-wave waves-effect waves-light" target="blank" href="https://youtu.be/dwy0ry3QJ-k?feature=shared">
                                                    <i class="ri-youtube-line fw-bold"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-11 -->

            <div class="text-center landing-main-footer py-3">
                <span class="text-muted"> Copyright © <span id="year"></span> <a href="https://bkad.taputkab.go.id/"
                        class="fw-medium text-primary">Badan Keuangan Dan Aset Daerah Kabupaten Tapanuli Utara</a>
                </span>
            </div>

        </div>
        <!-- End::app-content -->

    </div>

    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>

    <!-- Popper JS -->
    <script src="{{ asset('admin_resources/assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('admin_resources/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('admin_resources/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

    <!-- Choices JS -->
    <script src="{{ asset('admin_resources/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

    <!-- Swiper JS -->
    <script src="{{ asset('admin_resources/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Defaultmenu JS -->
    <script src="{{ asset('admin_resources/assets/js/defaultmenu.min.js') }}"></script>

    <!-- Internal Landing JS -->
    <script src="{{ asset('admin_resources/assets/js/landing.js') }}"></script>

    <!-- Node Waves JS-->
    <script src="{{ asset('admin_resources/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Sticky JS -->
    <script src="{{ asset('admin_resources/assets/js/sticky.js') }}"></script>

</body>

</html>