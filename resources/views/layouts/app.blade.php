<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | PPDB Sekolah Amanah Bangsa Cikarang</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --primary: #1e7c3e; /* Amanah Bangsa Green */
            --primary-dark: #166534;
            --primary-light: #f0fdf4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --sidebar-bg: #ffffff;
            --sidebar-text: #475569;
            --sidebar-hover: #f8fafc;
            --sidebar-active: #f0fdf4;
            --topbar-height: 65px;
            --body-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-muted: #64748b;
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
            color: #0f172a;
            margin: 0;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            left: 0; top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid #e2e8f0;
            overflow-y: auto;
            overflow-x: hidden;
            transition: width 0.3s ease;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 2px; }

        .sidebar-brand {
            padding: 20px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #e2e8f0;
            text-decoration: none;
            flex-shrink: 0;
        }
        .sidebar-brand-icon {
            width: 38px; height: 38px;
            background: var(--primary-light);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: var(--primary);
            flex-shrink: 0;
        }
        .sidebar-brand-text {
            color: #0f172a;
            font-weight: 700;
            font-size: 14px;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
        }
        .sidebar-brand-text small {
            display: block;
            font-weight: 500;
            font-size: 10px;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .sidebar-menu { padding: 16px 0; flex: 1; }
        .menu-label {
            font-size: 10px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 20px 6px;
            white-space: nowrap;
            overflow: hidden;
        }
        .nav-item-sidebar { list-style: none; }
        .nav-link-sidebar {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 0;
            transition: all 0.2s;
            white-space: nowrap;
            overflow: hidden;
            position: relative;
        }
        .nav-link-sidebar:hover {
            background: var(--sidebar-hover);
            color: var(--primary);
        }
        .nav-link-sidebar.active {
            background: var(--sidebar-active);
            color: var(--primary);
        }
        .nav-link-sidebar.active::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--primary);
            border-radius: 0 2px 2px 0;
        }
        .nav-link-sidebar .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 15px;
            flex-shrink: 0;
        }
        .nav-link-sidebar .nav-text { flex: 1; }
        .nav-link-sidebar .badge-count {
            font-size: 10px;
            background: var(--primary);
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
        }

        /* Sub-menu */
        .sub-menu { display: none; padding: 0; }
        .sub-menu.open { display: block; }
        .sub-menu .nav-link-sidebar {
            padding-left: 52px;
            font-size: 13px;
            font-weight: 400;
        }
        .nav-link-sidebar.has-sub .arrow {
            margin-left: auto;
            transition: transform 0.2s;
            font-size: 12px;
        }
        .nav-link-sidebar.has-sub.open .arrow { transform: rotate(90deg); }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            height: var(--topbar-height);
            background: white;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 999;
            gap: 16px;
        }
        .topbar-toggle {
            background: none;border: none;
            color: #64748b; cursor: pointer;
            font-size: 18px; padding: 6px;
            border-radius: 8px;
            transition: background 0.2s;
        }
        .topbar-toggle:hover { background: var(--primary-light); color: var(--primary); }
        .topbar-title { font-size: 18px; font-weight: 700; color: #1e293b; flex: 1; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .user-avatar {
            width: 38px; height: 38px;
            background: var(--primary);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 14px;
            cursor: pointer;
        }
        .user-dropdown { position: relative; }
        .user-dropdown-menu {
            position: absolute;
            right: 0; top: calc(100% + 8px);
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            min-width: 200px;
            padding: 8px 0;
            display: none;
            z-index: 1001;
        }
        .user-dropdown-menu.show { display: block; }
        .user-dropdown-header { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; }
        .user-dropdown-header .user-name { font-weight: 600; font-size: 14px; }
        .user-dropdown-header .user-role {
            font-size: 12px; color: var(--text-muted);
            background: var(--primary-light); color: var(--primary);
            padding: 2px 8px; border-radius: 20px;
            display: inline-block; margin-top: 4px;
        }
        .user-dropdown-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 16px; color: #334155;
            text-decoration: none; font-size: 14px;
            transition: background 0.15s;
        }
        .user-dropdown-item:hover { background: #f8fafc; }
        .user-dropdown-item.text-danger:hover { background: #fef2f2; }

        /* ===== PAGE CONTENT ===== */
        .page-content { flex: 1; padding: 24px; }
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
        }
        .page-header h1 {
            font-size: 22px; font-weight: 700; color: #1e293b; margin: 0;
        }
        .breadcrumb-custom { font-size: 13px; color: var(--text-muted); margin: 0; }
        .breadcrumb-custom a { color: var(--primary); text-decoration: none; }

        /* ===== CARDS ===== */
        .card { border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: none; }
        .card-header {
            background: white; border-bottom: 1px solid #f1f5f9;
            border-radius: 16px 16px 0 0 !important;
            padding: 16px 20px;
            font-weight: 600; font-size: 15px;
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .stat-icon.primary { background: #eef2ff; color: var(--primary); }
        .stat-icon.success { background: #d1fae5; color: var(--success); }
        .stat-icon.warning { background: #fef3c7; color: var(--warning); }
        .stat-icon.danger  { background: #fee2e2; color: var(--danger); }
        .stat-icon.info    { background: #dbeafe; color: var(--info); }
        .stat-value { font-size: 28px; font-weight: 700; color: #1e293b; line-height: 1; }
        .stat-label { font-size: 13px; color: var(--text-muted); margin-top: 4px; }

        /* ===== ALERTS ===== */
        .alert { border-radius: 12px; border: none; padding: 14px 16px; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-danger  { background: #fee2e2; color: #991b1b; }
        .alert-warning { background: #fef3c7; color: #92400e; }
        .alert-info    { background: #dbeafe; color: #1e40af; }

        /* ===== BUTTONS ===== */
        .btn { border-radius: 10px; font-weight: 500; font-size: 14px; }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-sm { border-radius: 8px; font-size: 13px; }

        /* ===== TABLES ===== */
        .table-responsive { border-radius: 12px; overflow: hidden; }
        .table { margin-bottom: 0; }
        .table thead th {
            background: #f8fafc;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 16px;
        }
        .table td { padding: 12px 16px; vertical-align: middle; font-size: 14px; border-color: #f1f5f9; }
        .table tbody tr:hover { background: #f8fafc; }

        /* ===== BADGES ===== */
        .badge { border-radius: 6px; font-size: 12px; font-weight: 500; padding: 4px 10px; }

        /* ===== FORMS ===== */
        .form-control, .form-select {
            border-radius: 10px; font-size: 14px;
            border-color: #e2e8f0;
            padding: 10px 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }
        .form-label { font-weight: 500; font-size: 14px; color: #374151; margin-bottom: 6px; }
        .invalid-feedback { font-size: 12px; }

        /* ===== SIDEBAR COLLAPSED ===== */
        body.sidebar-collapsed .sidebar { width: var(--sidebar-collapsed-width); }
        body.sidebar-collapsed .main-content { margin-left: var(--sidebar-collapsed-width); }
        body.sidebar-collapsed .sidebar-brand-text,
        body.sidebar-collapsed .nav-text,
        body.sidebar-collapsed .menu-label,
        body.sidebar-collapsed .arrow { display: none !important; }
        body.sidebar-collapsed .sidebar-brand { padding: 20px 16px; justify-content: center; }
        body.sidebar-collapsed .nav-link-sidebar { padding: 12px; justify-content: center; }
        body.sidebar-collapsed .sub-menu { display: none !important; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991.98px) {
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
                box-shadow: 4px 0 20px rgba(0,0,0,0.2);
            }
            .sidebar.mobile-open { left: 0; }
            .main-content { margin-left: 0; }
            .sidebar-overlay {
                display: none;
                position: fixed; inset: 0;
                background: rgba(0,0,0,0.5); z-index: 999;
            }
            .sidebar-overlay.show { display: block; }
        }
        @media (max-width: 575.98px) {
            .page-content { padding: 16px; }
            .topbar { padding: 0 16px; }
            .stat-value { font-size: 22px; }
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- Sidebar Overlay (Mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <img src="{{ asset('img/tut.png') }}?v=1.1" alt="Logo" style="height: 35px; width: auto; max-width: 140px; object-fit: contain;">
        <div class="sidebar-brand-text">
            PPDB Online
            <small>Amanah Bangsa</small>
        </div>
    </a>

    <div class="sidebar-menu">
        <ul class="list-unstyled m-0">
            <li><div class="menu-label">Menu Utama</div></li>

            <li class="nav-item-sidebar">
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link-sidebar {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-chart-pie"></i></span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li><div class="menu-label">Data Pendaftar</div></li>

            <li class="nav-item-sidebar">
                <a href="#menuPendaftar"
                   class="nav-link-sidebar has-sub {{ request()->routeIs('admin.siswa.*') || request()->routeIs('admin.orangtua.*') ? 'open active' : '' }}"
                   onclick="toggleSubMenu(this, 'menuPendaftar'); return false;">
                    <span class="nav-icon"><i class="fas fa-users"></i></span>
                    <span class="nav-text">Data Pendaftar</span>
                    <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <ul class="sub-menu {{ request()->routeIs('admin.siswa.*') || request()->routeIs('admin.orangtua.*') ? 'open' : '' }}" id="menuPendaftar">
                    <li class="nav-item-sidebar">
                        <a href="{{ route('admin.siswa.index') }}"
                           class="nav-link-sidebar {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                            <span class="nav-icon"><i class="fas fa-child"></i></span>
                            <span class="nav-text">Data Siswa</span>
                        </a>
                    </li>
                    <li class="nav-item-sidebar">
                        <a href="{{ route('admin.orangtua.index') }}"
                           class="nav-link-sidebar {{ request()->routeIs('admin.orangtua.*') ? 'active' : '' }}">
                            <span class="nav-icon"><i class="fas fa-users"></i></span>
                            <span class="nav-text">Data Orang Tua</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item-sidebar">
                <a href="{{ route('admin.administrasi.index') }}"
                   class="nav-link-sidebar {{ request()->routeIs('admin.administrasi.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-money-bill-wave"></i></span>
                    <span class="nav-text">Administrasi</span>
                </a>
            </li>

            <li class="nav-item-sidebar">
                <a href="{{ route('admin.pembayaran.index') }}"
                   class="nav-link-sidebar {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-check-double"></i></span>
                    <span class="nav-text">Verifikasi Pembayaran</span>
                    @php
                        $pendingPaymentsCount = \App\Models\PembayaranPeserta::where('status', 'menunggu_verifikasi')->distinct('payment_code')->count('payment_code');
                    @endphp
                    @if($pendingPaymentsCount > 0)
                        <span class="badge bg-danger ms-auto rounded-pill" style="font-size: 11px; padding: 4px 8px;">{{ $pendingPaymentsCount }}</span>
                    @endif
                </a>
            </li>

            <li class="nav-item-sidebar">
                <a href="{{ route('admin.cetak.index') }}"
                   class="nav-link-sidebar {{ request()->routeIs('admin.cetak.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-print"></i></span>
                    <span class="nav-text">Cetak Kartu</span>
                </a>
            </li>

            @if(auth()->user()->isAdmin())
            <li><div class="menu-label">Pengaturan</div></li>
            <li class="nav-item-sidebar">
                <a href="{{ route('admin.user.index') }}"
                   class="nav-link-sidebar {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fas fa-user-shield"></i></span>
                    <span class="nav-text">Pengguna</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <!-- Topbar -->
    <div class="topbar">
        <button class="topbar-toggle" onclick="toggleSidebar()" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-right">
            <div class="user-dropdown" id="userDropdown">
                <div class="user-avatar" onclick="toggleUserMenu()">
                    {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                </div>
                <div class="user-dropdown-menu" id="userMenu">
                    <div class="user-dropdown-header">
                        <div class="user-name">{{ auth()->user()->nama }}</div>
                        <div class="user-role">{{ ucfirst(auth()->user()->hak) }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="user-dropdown-item text-danger w-100 border-0 bg-transparent text-start">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {!! session('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
    // Sidebar Toggle
    function toggleSidebar() {
        if (window.innerWidth <= 991) {
            document.getElementById('sidebar').classList.toggle('mobile-open');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        } else {
            document.body.classList.toggle('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', document.body.classList.contains('sidebar-collapsed'));
        }
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('mobile-open');
        document.getElementById('sidebarOverlay').classList.remove('show');
    }
    // Restore sidebar state
    if (localStorage.getItem('sidebarCollapsed') === 'true' && window.innerWidth > 991) {
        document.body.classList.add('sidebar-collapsed');
    }

    // Submenu toggle
    function toggleSubMenu(el, menuId) {
        const menu = document.getElementById(menuId);
        const isOpen = menu.classList.contains('open');
        document.querySelectorAll('.sub-menu.open').forEach(m => m.classList.remove('open'));
        document.querySelectorAll('.nav-link-sidebar.has-sub.open').forEach(l => l.classList.remove('open'));
        if (!isOpen) {
            menu.classList.add('open');
            el.classList.add('open');
        }
    }

    // User Dropdown
    function toggleUserMenu() {
        document.getElementById('userMenu').classList.toggle('show');
    }
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('userDropdown');
        if (!dropdown.contains(e.target)) {
            document.getElementById('userMenu').classList.remove('show');
        }
    });

    // Auto-dismiss alerts
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(el);
            bsAlert.close();
        });
    }, 5000);
</script>

@stack('scripts')
</body>
</html>
