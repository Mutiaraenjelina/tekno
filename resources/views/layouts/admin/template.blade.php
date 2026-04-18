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
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-width="fullwidth" data-menu-styles="light" data-toggled="close" loader="enable" style="--primary-rgb: 35, 144, 190;">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('admin_resources/assets/images/brand-logos/favicon2.ico') }}" type="image/x-icon">

    <!-- Choices JS -->
    <script src="{{ asset('admin_resources/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('admin_resources/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Jquery Cdn -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <!-- Main Theme Js -->
    <script src="{{ asset('admin_resources/assets/js/main.js') }}"></script>

    <!-- Toastify JS -->
    <script src="{{ asset('admin_resources/assets/libs/toastify-js/src/toastify.js') }}"></script>

    <!-- Google Maps API -->
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyCW16SmpzDNLsrP-npQii6_8vBu_EJvEjA"></script>

    <!-- Google Maps JS -->
    <script src="{{ asset('admin_resources/assets/libs/gmaps/gmaps.min.js') }}"></script>

    <!-- Gallery JS -->
    <script src="{{ asset('admin_resources/assets/libs/glightbox/js/glightbox.min.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('admin_resources/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ asset('admin_resources/assets/css/styles.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ asset('admin_resources/assets/css/icons.css') }}" rel="stylesheet">

    <!-- Node Waves Css -->
    <link href="{{ asset('admin_resources/assets/libs/node-waves/waves.min.css') }}" rel="stylesheet">

    <!-- Simplebar Css -->
    <link href="{{ asset('admin_resources/assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('admin_resources/assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_resources/assets/libs/@simonwep/pickr/themes/nano.min.css') }}">

    <!-- Choices Css -->
    <link rel="stylesheet"
        href="{{ asset('admin_resources/assets/libs/choices.js/public/assets/styles/choices.min.css') }}">

    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="{{ asset('admin_resources/assets/libs/flatpickr/flatpickr.min.css') }}">

    <!-- Auto Complete CSS -->
    <link rel="stylesheet"
        href="{{ asset('admin_resources/assets/libs/@tarekraafat/autocomplete.js/css/autoComplete.css') }}">

    <!-- Toastify CSS -->
    <link rel="stylesheet" href="{{ asset('admin_resources/assets/libs/toastify-js/src/toastify.css') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <!-- Filepond CSS -->
    <link rel="stylesheet" href="{{ asset('admin_resources/assets/libs/filepond/filepond.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin_resources/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin_resources/assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.css') }}">

    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="{{ asset('admin_resources/assets/libs/glightbox/css/glightbox.min.css') }}">

    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dataSession = {!! json_encode(Session::get('userSession', [])) !!};
            
            // Only try to load user photo if session data exists
            if (dataSession && Array.isArray(dataSession) && dataSession[0] && dataSession[0]["namaLengkap"]) {
                var fotoPath = '{{ url("storage/images") }}';
                console.log(fotoPath + '/' + dataSession[0]["fotoUser"]);
                $('#nama-lengkap').text(dataSession[0]["namaLengkap"]);
                if (dataSession[0]["fotoUser"]) {
                    $("#fotoUser").attr("src", fotoPath + '/' + dataSession[0]["fotoUser"]);
                }
            } else if ('{{ auth()->user()->name ?? '' }}') {
                // Fallback to authenticated user name
                var userName = '{{ auth()->user()->name ?? '' }}';
                $('#nama-lengkap').text(userName);
            }
        });
    </script>

    <style>
        .brand-logo-fit {
            width: 232px;
            height: 78px;
            object-fit: contain;
            object-position: center;
            display: block;
            mix-blend-mode: multiply;
            filter: contrast(1.08) saturate(1.06);
        }

        .main-sidebar-header .header-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 94px;
        }
    </style>
</head>

<body>

    <!-- Loader -->
    <div id="loader">
        <img src="{{ asset('admin_resources/assets/images/media/loader.svg') }}" alt="">
    </div>
    <!-- Loader -->

    <div class="page">
        <!-- app-header -->
        <header class="app-header sticky" id="header">

            <!-- Start::main-header-container -->
            <div class="main-header-container container-fluid">

                <!-- Start::header-content-left -->
                <div class="header-content-left">

                    <!-- Start::header-element -->
                    <div class="header-element">
                        <div class="horizontal-logo">
                            <div class="header-logo">
                                <img src="{{ asset('admin_resources/assets/images/brand-logos/desktop-logo.png') }}"
                                    alt="logo" class="desktop-logo">
                                <img src="{{ asset('admin_resources/assets/images/brand-logos/toggle-logo.png') }}"
                                    alt="logo" class="toggle-logo">
                                <img src="{{ asset('admin_resources/assets/images/brand-logos/desktop-dark.png') }}"
                                    alt="logo" class="desktop-dark">
                                <img src="{{ asset('admin_resources/assets/images/brand-logos/toggle-dark.png') }}"
                                    alt="logo" class="toggle-dark">
                            </div>
                        </div>
                    </div>
                    <!-- End::header-element -->

                    <!-- Start::header-element -->
                    <div class="header-element mx-lg-0 mx-2">
                        <a aria-label="Hide Sidebar"
                            class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                            data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                    </div>
                    <!-- End::header-element -->

                </div>
                <!-- End::header-content-left -->

                <!-- Start::header-content-right -->
                <ul class="header-content-right">

                    <!-- Start::header-element -->
                    <li class="header-element d-md-none d-block">
                        <a href="javascript:void(0);" class="header-link" data-bs-toggle="modal"
                            data-bs-target="#header-responsive-search">
                            <!-- Start::header-link-icon -->
                            <i class="bi bi-search header-link-icon"></i>
                            <!-- End::header-link-icon -->
                        </a>
                    </li>
                    <!-- End::header-element -->

                    <!-- Start::header-element -->
                    <li class="header-element dropdown">
                        <!-- Start::header-link|dropdown-toggle -->
                        <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <div class="me-xl-2 me-0 lh-1 d-flex align-items-center ">
                                    <span class="avatar avatar-xs avatar-rounded bg-primary-transparent">
                                        <img src="" alt="img" id="fotoUser">
                                    </span>
                                </div>
                                <div class="d-xl-block d-none lh-1">
                                    <span class="fw-medium lh-1" id="nama-lengkap">
                                             
                                    </span>
                                </div>
                            </div>
                        </a>
                        <!-- End::header-link|dropdown-toggle -->
                        <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                            aria-labelledby="mainHeaderProfile">
                            <li class="border-bottom"><a class="dropdown-item d-flex flex-column" href="#"><span
                                        class="fs-12 text-muted">Anda Login Sebagai:</span><span
                                        class="fs-14">{{ Auth::user()->role_name }}</span></a>
                            </li>
                            <li><a class="dropdown-item d-flex align-items-center" href="profile.html"><i
                                        class="ti ti-user me-2 fs-18 text-primary"></i>Profile</a></li>
                            <!--<li><a class="dropdown-item d-flex align-items-center" href="mail.html"><i
                                        class="ti ti-mail me-2 fs-18 text-primary"></i>Inbox</a></li>
                            <li><a class="dropdown-item d-flex align-items-center" href="to-do-list.html"><i
                                        class="ti ti-checklist me-2 fs-18 text-primary"></i>Task Manager</a></li>
                            <li><a class="dropdown-item d-flex align-items-center" href="mail-settings.html"><i
                                        class="ti ti-settings me-2 fs-18 text-primary"></i>Settings</a></li>
                            <li><a class="dropdown-item d-flex align-items-center" href="chat.html"><i
                                        class="ti ti-headset me-2 fs-18 text-primary"></i>Support</a></li>-->
                            <li><a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"><i
                                        class="ti ti-logout me-2 fs-18 text-primary"></i>Log Out</a></li>
                        </ul>
                    </li>
                    <!-- End::header-element -->

                </ul>
                <!-- End::header-content-right -->

            </div>
            <!-- End::main-header-container -->

        </header>
        <!-- /app-header -->
        <!-- Start::app-sidebar -->
        <aside class="app-sidebar sticky" id="sidebar">

            <!-- Start::main-sidebar-header -->
            <div class="main-sidebar-header">
                <div class="header-logo">
                    <img src="{{ asset($brandLogo) }}"
                        alt="logo" class="desktop-logo brand-logo-fit">
                    <img src="{{ asset($brandLogo) }}"
                        alt="logo" class="toggle-dark brand-logo-fit">
                    <img src="{{ asset($brandLogo) }}"
                        alt="logo" class="desktop-dark brand-logo-fit">
                    <img src="{{ asset($brandLogo) }}"
                        alt="logo" class="toggle-logo brand-logo-fit">
                </div>
            </div>
            <!-- End::main-sidebar-header -->

            <!-- Start::main-sidebar -->
            <div class="main-sidebar" id="sidebar-scroll">

                <!-- Start::nav -->
                <nav class="main-menu-container nav nav-pills flex-column sub-open">
                    <div class="slide-left" id="slide-left">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                            viewBox="0 0 24 24">
                            <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                        </svg>
                    </div>

                    @if (Auth::user()->roleId == '1')
                        @include('super_admin_menu')
                    @elseif (Auth::user()->roleId == '2')
                        @include('admin_menu')
                    @elseif (Auth::user()->roleId == '3')
                        @include('user_menu')
                    @endif

                    
                    <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                            width="24" height="24" viewBox="0 0 24 24">
                            <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                        </svg></div>
                </nav>
                <!-- End::nav -->

            </div>
            <!-- End::main-sidebar -->

        </aside>
        <!-- End::app-sidebar -->

        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                @include('flash_message')

                @yield('content')

            </div>
        </div>
        <!-- End::app-content -->


        <!-- Footer Start -->
        <footer class="footer mt-auto py-3 bg-white text-center">
            <div class="container">
                <span class="text-muted"> Copyright © <span id="year"></span> <a href="https://bkad.taputkab.go.id/"
                        class="fw-medium text-primary">Badan Keuangan Dan Aset Daerah Kabupaten Tapanuli Utara</a>
                </span>
            </div>
        </footer>
        <!-- Footer End -->
        <div class="modal fade" id="header-responsive-search" tabindex="-1" aria-labelledby="header-responsive-search"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="input-group">
                            <input type="text" class="form-control border-end-0" placeholder="Search Anything ..."
                                aria-label="Search Anything ..." aria-describedby="button-addon2">
                            <button class="btn btn-primary" type="button" id="button-addon2"><i
                                    class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow lh-1"><i class="ti ti-caret-up fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <!-- Scroll To Top -->

    <!-- Popper JS -->
    <script src="{{ asset('admin_resources/assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>

    <!-- Defaultmenu JS -->
    <script src="{{ asset('admin_resources/assets/js/defaultmenu.min.js') }}"></script>

    <!-- Node Waves JS-->
    <script src="{{ asset('admin_resources/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Sticky JS -->
    <script src="{{ asset('admin_resources/assets/js/sticky.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('admin_resources/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin_resources/assets/js/simplebar.js') }}"></script>

    <!-- Auto Complete JS -->
    <script src="{{ asset('admin_resources/assets/libs/@tarekraafat/autocomplete.js/autoComplete.min.js') }}"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('admin_resources/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

    <!-- Date & Time Picker JS -->
    <script src="{{ asset('admin_resources/assets/libs/flatpickr/flatpickr.min.js') }}"></script>

    <!-- Form Validation JS -->
    <script src="{{ asset('admin_resources/assets/js/validation.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('admin_resources/assets/js/custom.js') }}"></script>

    <!-- Datatables Cdn -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- Internal Datatables JS -->
    <script src="{{ asset('admin_resources/assets/js/datatables.js') }}"></script>

    <!-- Select2 Cdn -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @if ($message = Session::get('success'))
        <script>
            const primarytoastSuccess = document.getElementById('primaryToast')
            const toast = new bootstrap.Toast(primarytoastSuccess)
            toast.show()
        </script>
    @endif

    @if ($message = Session::get('error'))
        <script>
            const primarytoastError = document.getElementById('dangerToast')
            const toast = new bootstrap.Toast(primarytoastError)
            toast.show()
        </script>
    @endif
</body>

</html>
