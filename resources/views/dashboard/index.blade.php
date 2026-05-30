@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="fw-bold" style="font-size: 24px; color: #0f172a;">Ringkasan Data</h1>
        <nav class="breadcrumb-custom"><a href="#">Dashboard</a> / Beranda</nav>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="text-muted small"><i class="far fa-calendar me-1"></i>{{ now()->translatedFormat('l, d F Y') }}</span>
    </div>
</div>

<!-- Stat Cards Row 1 -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="fas fa-user-shield"></i></div>
            <div>
                <div class="stat-value" style="font-size: 22px; font-weight: 700; color: #0f172a;">{{ $stats['total_admin'] }}</div>
                <div class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500;">Total Admin</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon info"><i class="fas fa-chalkboard-teacher"></i></div>
            <div>
                <div class="stat-value" style="font-size: 22px; font-weight: 700; color: #0f172a;">{{ $stats['total_pegawai'] }}</div>
                <div class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500;">Total Pegawai</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon warning"><i class="fas fa-calendar-alt"></i></div>
            <div>
                <div class="stat-value" style="font-size: 22px; font-weight: 700; color: #0f172a;">{{ $stats['total_pendaftar_tahun_ini'] }}</div>
                <div class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500;">Pendaftar Baru</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon success"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-value" style="font-size: 22px; font-weight: 700; color: #0f172a;">{{ $stats['total_pendaftar'] }}</div>
                <div class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500;">Total Pendaftar</div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards Row 2 -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-value" style="font-size: 22px; font-weight: 700; color: #0f172a;">{{ $stats['total_lunas'] }}</div>
                <div class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500;">Adm. Lunas</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon danger"><i class="fas fa-clock"></i></div>
            <div>
                <div class="stat-value" style="font-size: 22px; font-weight: 700; color: #0f172a;">{{ $stats['total_belum_lunas'] }}</div>
                <div class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500;">Adm. Pending</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon info"><i class="fas fa-mars"></i></div>
            <div>
                <div class="stat-value" style="font-size: 22px; font-weight: 700; color: #0f172a;">{{ $stats['pendaftar_laki'] }}</div>
                <div class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500;">Siswa Laki-Laki</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon warning"><i class="fas fa-venus"></i></div>
            <div>
                <div class="stat-value" style="font-size: 22px; font-weight: 700; color: #0f172a;">{{ $stats['pendaftar_perempuan'] }}</div>
                <div class="stat-label" style="font-size: 12px; color: #64748b; font-weight: 500;">Siswa Perempuan</div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Registrations Table -->
<div class="card" style="border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
    <div class="card-header d-flex align-items-center justify-content-between bg-white" style="border-bottom: 1px solid #f1f5f9; padding: 18px 24px;">
        <span class="fw-bold text-dark" style="font-size: 15px;"><i class="fas fa-list me-2 text-primary"></i>Pendaftar Terbaru</span>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px; font-size: 13px; font-weight: 500;">
            Lihat Semua <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="text-muted px-4 py-3" style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">#</th>
                        <th class="text-muted px-3 py-3" style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">No. Pendaftaran</th>
                        <th class="text-muted px-3 py-3" style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Nama Siswa</th>
                        <th class="text-muted px-3 py-3" style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Tahun Ajaran</th>
                        <th class="text-muted px-3 py-3" style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Data Ortu</th>
                        <th class="text-muted px-3 py-3" style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Administrasi</th>
                        <th class="text-muted px-4 py-3" style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftar_terbaru as $i => $siswa)
                    <tr>
                        <td class="px-4 py-3 text-secondary">{{ $i + 1 }}</td>
                        <td class="px-3 py-3"><span class="badge bg-light text-dark border px-2.5 py-1.5" style="border-radius: 6px; font-weight: 600; font-size: 12px;">{{ $siswa->no_pendaftaran }}</span></td>
                        <td class="px-3 py-3">
                            <div class="fw-bold text-dark" style="font-size: 14px;">{{ $siswa->nama_peserta_didik }}</div>
                            <small class="text-muted" style="font-size: 12px;">NISN: {{ $siswa->nisn }}</small>
                        </td>
                        <td class="px-3 py-3 text-secondary" style="font-size: 13px;">{{ $siswa->tahun_ajaran }}</td>
                        <td class="px-3 py-3">
                            @if($siswa->status_ortu)
                                <span class="badge" style="background:#d1fae5; color:#065f46; border-radius: 6px; font-weight: 600;">Lengkap</span>
                            @else
                                <span class="badge" style="background:#fee2e2; color:#991b1b; border-radius: 6px; font-weight: 600;">Belum</span>
                            @endif
                        </td>
                        <td class="px-3 py-3">
                            @if($siswa->administrasi)
                                @if($siswa->administrasi->status === 'Lunas')
                                    <span class="badge" style="background:#d1fae5; color:#065f46; border-radius: 6px; font-weight: 600;">Lunas</span>
                                @else
                                    <span class="badge" style="background:#fef3c7; color:#92400e; border-radius: 6px; font-weight: 600;">Belum Lunas</span>
                                @endif
                            @else
                                <span class="badge bg-light text-muted border" style="border-radius: 6px; font-weight: 600;">Belum Ada</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-muted" style="font-size: 12px;">{{ $siswa->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block text-secondary" style="opacity: 0.5;"></i>
                            Belum ada data pendaftar baru
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
