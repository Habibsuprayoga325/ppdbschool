<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PPDB Sekolah Amanah Bangsa Cikarang')</title>
    <meta name="description" content="@yield('meta-description', 'Penerimaan Peserta Didik Baru Sekolah Amanah Bangsa Cikarang - Daftarkan putra/putri Anda sekarang.')">
    <link rel="icon" href="{{ asset('img/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary: #1e7c3e; /* Amanah Bangsa Green */
            --primary-dark: #166534;
            --accent: #dc2626; /* Red accent */
            --text-dark: #0f172a;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; color: var(--text-dark); margin: 0; background-color: #f8fafc; }

        /* NAVBAR */
        .public-navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.08);
            padding: 14px 0;
            position: fixed; top: 0; left: 0; right: 0;
            z-index: 1000;
            transition: all 0.3s;
        }
        .public-navbar.scrolled {
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .navbar-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .navbar-logo-text {
            font-weight: 800; font-size: 16px; color: var(--text-dark);
            line-height: 1.1;
        }
        .navbar-logo-text small {
            display: block; font-weight: 500; font-size: 11px; color: #64748b;
        }
        .nav-link-public {
            font-weight: 500; font-size: 14px; color: #475569;
            text-decoration: none; padding: 6px 14px;
            border-radius: 8px; transition: all 0.2s;
        }
        .nav-link-public:hover { color: var(--primary); background: #f1f5f9; }
        .btn-navbar {
            background: var(--primary); color: white;
            font-weight: 600; font-size: 14px;
            padding: 8px 20px; border-radius: 10px;
            text-decoration: none; border: none;
            transition: all 0.2s;
        }
        .btn-navbar:hover { background: var(--primary-dark); color: white; transform: translateY(-1px); }

        /* Page spacer */
        .page-spacer { height: 80px; }

        /* Alert */
        .alert { border-radius: 12px; }

        /* FOOTER */
        .public-footer {
            background: #0f172a; color: #94a3b8;
            padding: 30px 0 20px;
            font-size: 14px;
        }
        .public-footer p { margin: 0; }
        .public-footer a:hover { color: #ffffff !important; }
        .hover-link:hover { color: #ffffff !important; }

        /* Responsive hamburger */
        .navbar-toggler { border: none; }
        .navbar-toggler:focus { box-shadow: none; }

        @media (max-width: 767px) {
            .page-spacer { height: 72px; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Navbar -->
<nav class="public-navbar" id="publicNavbar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('public.index') }}" class="navbar-logo">
                <img src="{{ asset('img/tut.png') }}?v=1.1" alt="Logo" style="height: 42px; width: auto; max-width: 160px; object-fit: contain;">
                <div class="navbar-logo-text">
                    PPDB Online
                    <small>Sekolah Amanah Bangsa</small>
                </div>
            </a>
            <div class="d-none d-md-flex align-items-center gap-3">
                <a href="{{ route('public.index') }}" class="nav-link-public">Beranda</a>
                @if(session()->has('peserta_id'))
                    <a href="{{ route('peserta.dashboard') }}" class="nav-link-public">Dashboard Peserta</a>
                    <form action="{{ route('peserta.logout') }}" method="POST" class="d-inline m-0">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-navbar py-2 px-3 bg-danger border-0" style="font-size: 14px;">
                            <i class="fas fa-sign-out-alt me-1"></i> Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('public.daftar-siswa') }}" class="nav-link-public">Pendaftaran</a>
                    <a href="{{ route('peserta.login') }}" class="nav-link-public">Login Peserta</a>
                    <a href="{{ route('login') }}" class="btn-navbar">
                        <i class="fas fa-lock me-1"></i> Login Admin
                    </a>
                @endif
            </div>

            <!-- Mobile Menu Button -->
            <button class="navbar-toggler d-md-none" type="button" onclick="toggleMobileNav()">
                <i class="fas fa-bars fa-lg text-dark"></i>
            </button>
        </div>

        <!-- Mobile Nav -->
        <div class="d-md-none mt-3" id="mobileNav" style="display:none!important">
            <div class="d-flex flex-column gap-2 pb-2">
                <a href="{{ route('public.index') }}" class="nav-link-public">Beranda</a>
                @if(session()->has('peserta_id'))
                    <a href="{{ route('peserta.dashboard') }}" class="nav-link-public">Dashboard Peserta</a>
                    <form action="{{ route('peserta.logout') }}" method="POST" class="w-100 m-0">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100 py-2 border-0 text-center" style="font-size: 14px; border-radius: 10px;">
                            <i class="fas fa-sign-out-alt me-1"></i> Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('public.daftar-siswa') }}" class="nav-link-public">Pendaftaran</a>
                    <a href="{{ route('peserta.login') }}" class="nav-link-public">Login Peserta</a>
                    <a href="{{ route('login') }}" class="btn-navbar text-center">Login Admin</a>
                @endif
            </div>
        </div>
    </div>
</nav>

<div class="page-spacer"></div>

@if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i> {!! session('success') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

@yield('content')

<!-- Footer -->
<footer class="public-footer" style="background-color: #0f172a; color: #94a3b8; padding: 50px 0 30px;">
    <div class="container">
        <div class="row g-4 text-start">
            <div class="col-md-5">
                <h5 class="text-white fw-bold mb-3" style="font-size: 16px;">Sekolah Amanah Bangsa</h5>
                <p class="small mb-3" style="line-height: 1.6; font-size: 13px;">Portal Penerimaan Peserta Didik Baru (PPDB) Online resmi Sekolah Amanah Bangsa Cikarang. Proses pendaftaran yang mudah, aman, transparan, dan terintegrasi.</p>
                <p class="small" style="font-size: 12px;">© {{ date('Y') }} Sekolah Amanah Bangsa. All Rights Reserved.</p>
            </div>
            <div class="col-md-4">
                <h5 class="text-white fw-bold mb-3" style="font-size: 16px;">Contact Us</h5>
                <ul class="list-unstyled small d-flex flex-column gap-2" style="font-size: 13px; padding: 0;">
                    <li><i class="fas fa-phone me-2 text-primary-light"></i> 0877-8329-6667</li>
                    <li><i class="fas fa-envelope me-2 text-primary-light"></i> support@amanahbangsa.sch.id</li>
                    <li><i class="fas fa-globe me-2 text-primary-light"></i> <a href="{{ route('public.index') }}" class="text-decoration-none text-muted" style="transition: color 0.2s;">www.amanahbangsa.sch.id</a></li>
                    <li><i class="fas fa-map-marker-alt me-2 text-primary-light"></i> Jl. Irigasi Raya, Jayamukti, Cikarang Pusat, 17530, Bekasi, Jawa Barat</li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="text-white fw-bold mb-3" style="font-size: 16px;">Kebijakan & Layanan</h5>
                <ul class="list-unstyled small d-flex flex-column gap-2" style="font-size: 13px; padding: 0;">
                    <li><a href="{{ route('public.syarat-ketentuan') }}" class="text-decoration-none text-muted hover-link" style="transition: color 0.2s;"><i class="fas fa-chevron-right me-2" style="font-size: 10px;"></i> Syarat & Ketentuan</a></li>
                    <li><a href="{{ route('public.kebijakan-pengembalian') }}" class="text-decoration-none text-muted hover-link" style="transition: color 0.2s;"><i class="fas fa-chevron-right me-2" style="font-size: 10px;"></i> Kebijakan Refund</a></li>
                    <li><a href="{{ route('public.daftar-siswa') }}" class="text-decoration-none text-muted hover-link" style="transition: color 0.2s;"><i class="fas fa-chevron-right me-2" style="font-size: 10px;"></i> Pendaftaran Baru</a></li>
                    <li><a href="{{ route('peserta.login') }}" class="text-decoration-none text-muted hover-link" style="transition: color 0.2s;"><i class="fas fa-chevron-right me-2" style="font-size: 10px;"></i> Portal Login Peserta</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('publicNavbar');
        nav.classList.toggle('scrolled', window.scrollY > 30);
    });

    // Mobile nav toggle
    function toggleMobileNav() {
        const nav = document.getElementById('mobileNav');
        const isHidden = nav.style.display === 'none' || nav.style.display === '';
        nav.style.display = isHidden ? 'flex' : 'none';
        nav.style.flexDirection = 'column';
    }
</script>
@stack('scripts')
</body>
</html>
