<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="1.2;url={{ $redirectUrl }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPAYDA - Memproses Login</title>
    <link href="{{ asset('admin_resources/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_resources/assets/css/icons.css') }}" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2390be 0%, #1a6fa0 100%);
            color: #fff;
            font-family: Arial, sans-serif;
        }
        .login-card {
            width: min(520px, calc(100vw - 32px));
            background: rgba(255,255,255,0.96);
            color: #1f2d3d;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 18px 50px rgba(0,0,0,0.18);
            text-align: center;
        }
        .badge-role {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 999px;
            background: #e6f5fb;
            color: #2390be;
            font-weight: 700;
            margin-bottom: 16px;
        }
        .brand-name {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }
        .btn-primary {
            background: #2390be;
            border-color: #2390be;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="badge-role">{{ $user->role_name }}</div>
        <div class="brand-name">SIPAYDA</div>
        @if ((string) $user->roleId === '3')
            <h4 class="mb-2">Selamat datang, Pelanggan</h4>
            <p class="text-muted mb-4">Sistem mengenali akun pelanggan Anda dan sedang menyiapkan halaman user.</p>
        @else
            <h4 class="mb-2">Selamat datang, Admin UMKM</h4>
            <p class="text-muted mb-4">Sistem mengenali akun admin Anda dan sedang menyiapkan halaman admin.</p>
        @endif
        <div class="mb-4">
            <div><strong>{{ $user->username }}</strong></div>
            <div class="text-muted small">Arah tujuan: {{ $redirectRoute }}</div>
        </div>
        <a href="{{ $redirectUrl }}" class="btn btn-primary btn-lg w-100">Lanjut ke Halaman Saya</a>
        <p class="text-muted small mt-3 mb-0">Anda akan diarahkan otomatis dalam 1 detik.</p>
    </div>
</body>
</html>
