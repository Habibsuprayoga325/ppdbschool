<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | PPDB Sekolah Amanah Bangsa Cikarang</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #1e7c3e; /* Amanah Bangsa Green */
            --primary-dark: #166534;
            --primary-light: #f0fdf4;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
        }
        .login-wrapper {
            display: flex;
            max-width: 900px;
            width: 100%;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }
        .login-left {
            flex: 1;
            background-color: #1e7c3e;
            padding: 48px 40px;
            color: white;
            display: flex; flex-direction: column; justify-content: space-between;
        }
        .login-left .brand { display: flex; align-items: center; gap: 12px; }
        .brand-logo-img {
            height: 46px; width: auto;
            max-width: 150px;
            object-fit: contain;
        }
        .brand-name { font-weight: 800; font-size: 18px; }
        .brand-sub { font-size: 12px; opacity: 0.8; }
        .login-hero { margin-top: 40px; }
        .login-hero h2 { font-size: 28px; font-weight: 800; margin-bottom: 12px; }
        .login-hero p { font-size: 14px; opacity: 0.8; line-height: 1.7; }
        .login-features { margin-top: 32px; display: flex; flex-direction: column; gap: 12px; }
        .feature-item { display: flex; align-items: center; gap: 10px; font-size: 14px; }
        .feature-icon {
            width: 30px; height: 30px;
            background: rgba(255,255,255,0.15);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; flex-shrink: 0;
        }
        .login-right {
            width: 380px;
            background: white;
            padding: 48px 40px;
            display: flex; flex-direction: column; justify-content: center;
        }
        .login-right h3 { font-size: 22px; font-weight: 700; margin-bottom: 6px; color: #0f172a; }
        .login-right .subtitle { font-size: 14px; color: #64748b; margin-bottom: 32px; }
        .form-control {
            border-radius: 10px; padding: 12px 14px;
            border: 1.5px solid #e2e8f0; font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30, 124, 62, 0.15);
        }
        .form-label { font-weight: 500; font-size: 14px; color: #374151; }
        .input-group-text { border-radius: 10px 0 0 10px; background: #f8fafc; border: 1.5px solid #e2e8f0; border-right: none; }
        .input-group .form-control { border-radius: 0 10px 10px 0; }
        .btn-login {
            background: var(--primary); color: white;
            border: none; border-radius: 10px;
            font-weight: 600; font-size: 15px;
            padding: 12px; width: 100%;
            transition: all 0.2s; cursor: pointer;
        }
        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }
        .back-link { display: flex; align-items: center; gap: 6px; color: #64748b; text-decoration: none; font-size: 14px; margin-top: 20px; justify-content: center; }
        .back-link:hover { color: var(--primary); }
        .alert { border-radius: 10px; font-size: 14px; }
        @media (max-width: 767px) {
            .login-left { display: none; }
            .login-right { width: 100%; border-radius: 24px; }
            .login-wrapper { border-radius: 24px; }
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    <!-- Left Panel -->
    <div class="login-left">
        <div class="brand">
            <img class="brand-logo-img" src="{{ asset('img/tut.png') }}?v=1.1" alt="Logo">
            <div>
                <div class="brand-name">PPDB Online</div>
                <div class="brand-sub">Sekolah Amanah Bangsa Cikarang</div>
            </div>
        </div>
        <div class="login-hero">
            <h2>Sistem Manajemen PPDB</h2>
            <p>Kelola pendaftaran peserta didik baru secara efisien dan terorganisir.</p>
            <div class="login-features">
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <span>Sistem keamanan terenkripsi</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-chart-bar"></i></div>
                    <span>Dashboard statistik real-time</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
                    <span>Tampilan responsif semua perangkat</span>
                </div>
            </div>
        </div>
        <div style="font-size:12px;opacity:0.6;">© {{ date('Y') }} PPDB Sekolah Amanah Bangsa Cikarang</div>
    </div>

    <!-- Right Panel -->
    <div class="login-right">
        <h3>Selamat Datang 👋</h3>
        <p class="subtitle">Masuk ke panel administrasi PPDB</p>

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                           placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Masukkan password" required id="passwordInput">
                    <button type="button" class="btn btn-outline-secondary border-start-0" style="border-radius:0 10px 10px 0;border:1.5px solid #e2e8f0;border-left:none;" onclick="togglePassword()">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn-login">
                Masuk
            </button>
        </form>

        <a href="{{ route('public.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke halaman utama
        </a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const icon  = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
</body>
</html>
