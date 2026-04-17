<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TAPATUPA - Portal UMKM</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('admin_resources/assets/images/brand-logos/favicon2.ico') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('admin_resources/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tabler-icons@latest/tabler-icons.min.css">

    <!-- Custom User Styles -->
    <style>
        :root {
            --primary-color: #2390be;
            --primary-rgb: 35, 144, 190;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        /* Navbar Styles */
        .user-navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1a6fa0 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .user-navbar .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-navbar .navbar-brand img {
            height: 40px;
            width: auto;
        }

        .user-navbar .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
        }

        .user-navbar .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .user-navbar .nav-link.active {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .user-navbar .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-navbar .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 2px solid white;
        }

        /* Main Content Area */
        .user-container {
            flex: 1;
            padding: 2rem 0;
        }

        .user-main {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        /* Page Header */
        .user-page-header {
            margin-bottom: 2rem;
        }

        .user-page-header h1 {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .user-page-header .subtitle {
            color: #6c757d;
            font-size: 0.95rem;
        }

        /* Card Styles */
        .user-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: none;
            transition: all 0.3s ease;
        }

        .user-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .user-card-title {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-card-title i {
            font-size: 1.3rem;
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(35, 144, 190, 0.15);
        }

        .stat-card .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 1rem 0;
        }

        .stat-card .stat-label {
            color: #6c757d;
            font-weight: 500;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .stat-icon {
            font-size: 2rem;
            opacity: 0.2;
            margin-bottom: 0.5rem;
        }

        /* Alert Styles */
        .user-alert {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            border-left: 4px solid var(--primary-color);
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
        }

        .user-alert-title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .user-alert-message {
            color: #546e7a;
            font-size: 0.95rem;
        }

        /* Button Styles */
        .btn-user-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-user-primary:hover {
            background-color: #1a6fa0;
            border-color: #1a6fa0;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(35, 144, 190, 0.3);
        }

        .btn-user-secondary {
            background-color: #f0f0f0;
            border-color: #e0e0e0;
            color: #333;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-user-secondary:hover {
            background-color: #e0e0e0;
            border-color: #d0d0d0;
            color: #000;
        }

        /* Table Styles */
        .user-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .user-table table {
            margin-bottom: 0;
        }

        .user-table thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .user-table thead th {
            color: #333;
            font-weight: 700;
            padding: 1rem;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .user-table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }

        .user-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Badge Styles */
        .badge-status-bayar {
            background-color: #d4edda;
            color: #155724;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .badge-status-belum {
            background-color: #fff3cd;
            color: #856404;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Footer */
        .user-footer {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1a6fa0 100%);
            color: white;
            padding: 2rem 0;
            margin-top: auto;
            text-align: center;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.08);
        }

        .user-footer p {
            margin: 0.5rem 0;
            font-size: 0.95rem;
        }

        .user-footer a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .user-footer a:hover {
            text-decoration: underline;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #999;
        }

        .empty-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1rem;
        }

        .empty-state h4 {
            color: #666;
            margin: 1rem 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .user-main {
                padding: 1rem;
            }

            .user-page-header h1 {
                font-size: 1.5rem;
            }

            .stat-card {
                margin-bottom: 1rem;
            }

            .user-navbar .navbar-brand {
                font-size: 1.2rem;
            }

            .user-navbar .nav-link {
                padding: 0.5rem 0.5rem !important;
                font-size: 0.9rem;
            }
        }

        /* Breadcrumb */
        .user-breadcrumb {
            margin-bottom: 2rem;
        }

        .user-breadcrumb ol {
            background: none;
            padding: 0;
            margin: 0;
        }

        .user-breadcrumb ol li {
            font-size: 0.9rem;
        }

        .user-breadcrumb ol li a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .user-breadcrumb ol li a:hover {
            text-decoration: underline;
        }

        .user-breadcrumb ol li.active {
            color: #6c757d;
        }

        /* Loading Animation */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .loading {
            animation: pulse 1.5s ease-in-out infinite;
        }
    </style>

    @yield('extra-css')
</head>

<body>
    <!-- Navbar -->
    <nav class="user-navbar navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('user.dashboard.index') }}">
                <i class="ti ti-building-community"></i>
                TAPATUPA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNavbar"
                aria-controls="userNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="userNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.dashboard.index') ? 'active' : '' }}"
                            href="{{ route('user.dashboard.index') }}">
                            <i class="ti ti-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.tagihan.*') ? 'active' : '' }}"
                            href="{{ route('user.tagihan.index') }}">
                            <i class="ti ti-receipt"></i> Tagihan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.tagihan.status') || request()->routeIs('user.assignment.tagihan.index') ? 'active' : '' }}"
                            href="{{ route('user.assignment.tagihan.index') }}">
                            <i class="ti ti-credit-card"></i> Assignment Tagihan User
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.pelanggan.index') ? 'active' : '' }}"
                            href="{{ route('user.pelanggan.index') }}">
                            <i class="ti ti-user"></i> Pelanggan
                        </a>
                    </li>
                </ul>
                <div class="navbar-nav ms-auto">
                    <div class="nav-item user-profile">
                        <span class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                        </span>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link text-white dropdown-toggle" type="button" 
                                id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->username }}
                                <i class="ti ti-chevron-down ms-2"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="{{ route('logout') }}">
                                    <i class="ti ti-logout me-2"></i>Logout
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="user-container">
        <div class="user-main">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="user-footer">
        <p>&copy; 2024-2026 TAPATUPA - Sistem Manajemen Tagihan UMKM</p>
        <p>Platform Retribusi Pendapatan Daerah</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="{{ asset('admin_resources/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <!-- Toastify JS -->
    <script src="{{ asset('admin_resources/assets/libs/toastify-js/src/toastify.js') }}"></script>

    <!-- Toastify CSS -->
    <link rel="stylesheet" href="{{ asset('admin_resources/assets/libs/toastify-js/src/toastify.css') }}">

    @yield('extra-js')
</body>

</html>
