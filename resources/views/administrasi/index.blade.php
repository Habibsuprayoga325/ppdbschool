@extends('layouts.app')
@section('title', 'Administrasi Pembayaran')
@section('page-title', 'Administrasi Pembayaran')

@push('styles')
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="page-header">
    <div>
        <h1>Administrasi Pembayaran</h1>
        <nav class="breadcrumb-custom"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Administrasi</nav>
    </div>
    <a href="{{ route('admin.administrasi.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Pembayaran
    </a>
</div>

<!-- Stats Banner -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="fas fa-calculator"></i></div>
            <div>
                <div class="stat-value">{{ $administrasi->count() }}</div>
                <div class="stat-label">Total Data Keuangan</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-value">{{ $administrasi->where('status', 'Lunas')->count() }}</div>
                <div class="stat-label">Lunas</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon warning"><i class="fas fa-clock"></i></div>
            <div>
                <div class="stat-value">{{ $administrasi->where('status', 'Belum Lunas')->count() }}</div>
                <div class="stat-label">Belum Lunas</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><i class="fas fa-money-bill-wave text-primary me-2"></i>Daftar Keuangan & Pembayaran</div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tabelAdministrasi" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Daftar</th>
                        <th>Nama Siswa</th>
                        <th>Nominal Biaya</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($administrasi as $i => $adm)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $adm->identitasSiswa->no_pendaftaran ?? '-' }}</span></td>
                        <td>
                            <div class="fw-semibold">{{ $adm->identitasSiswa->nama_peserta_didik ?? '-' }}</div>
                            <small class="text-muted">{{ $adm->identitasSiswa->nisn ?? '' }}</small>
                        </td>
                        <td><span class="fw-bold">{{ $adm->harga_formatted }}</span></td>
                        <td>
                            @if($adm->status === 'Lunas')
                                <span class="badge" style="background:#d1fae5;color:#065f46;">Lunas</span>
                            @else
                                <span class="badge" style="background:#fef3c7;color:#92400e;">Belum Lunas</span>
                            @endif
                        </td>
                        <td>{{ $adm->keterangan ?: '-' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.administrasi.edit', $adm->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.administrasi.destroy', $adm->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus data administrasi siswa {{ $adm->identitasSiswa->nama_peserta_didik ?? '' }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#tabelAdministrasi').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json' },
        responsive: true,
        columnDefs: [{ orderable: false, targets: [-1] }]
    });
});
</script>
@endpush
