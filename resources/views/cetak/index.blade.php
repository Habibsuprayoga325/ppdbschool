@extends('layouts.app')
@section('title', 'Cetak Kartu Pendaftaran')
@section('page-title', 'Cetak Kartu')

@push('styles')
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="page-header">
    <div>
        <h1>Cetak Kartu Pendaftaran</h1>
        <nav class="breadcrumb-custom"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Cetak Kartu</nav>
    </div>
</div>

<div class="card">
    <div class="card-header"><i class="fas fa-print text-primary me-2"></i>Daftar Calon Siswa & Cetak Kartu</div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tabelCetak" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Daftar</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Orang Tua</th>
                        <th>Administrasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $i => $s)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $s->no_pendaftaran }}</span></td>
                        <td>{{ $s->nisn }}</td>
                        <td>
                            <div class="fw-semibold">{{ $s->nama_peserta_didik }}</div>
                            <small class="text-muted">{{ $s->nama_panggilan }}</small>
                        </td>
                        <td>
                            @if($s->orangTuaWali)
                                <span class="badge" style="background:#d1fae5;color:#065f46;"><i class="fas fa-check me-1"></i>Lengkap</span>
                            @else
                                <span class="badge" style="background:#fee2e2;color:#991b1b;"><i class="fas fa-times me-1"></i>Belum</span>
                            @endif
                        </td>
                        <td>
                            @if($s->administrasi)
                                <span class="badge {{ $s->administrasi->status === 'Lunas' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $s->administrasi->status }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Belum Ada</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.cetak.kartu', $s->id) }}" class="btn btn-sm btn-success text-white" target="_blank">
                                <i class="fas fa-print me-1"></i> Cetak Kartu
                            </a>
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
    $('#tabelCetak').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json' },
        responsive: true,
        columnDefs: [{ orderable: false, targets: [-1] }]
    });
});
</script>
@endpush
