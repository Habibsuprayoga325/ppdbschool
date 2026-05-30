@extends('layouts.app')
@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@push('styles')
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="page-header">
    <div>
        <h1>Data Siswa</h1>
        <nav class="breadcrumb-custom"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Data Siswa</nav>
    </div>
    <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Siswa
    </a>
</div>

<div class="card">
    <div class="card-header"><i class="fas fa-child me-2 text-primary"></i>Daftar Siswa Terdaftar</div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tabelSiswa" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Daftar</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Tahun Ajaran</th>
                        <th>Data Ortu</th>
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
                        <td>{{ $s->tahun_ajaran }}</td>
                        <td>
                            @if($s->status_ortu)
                                <span class="badge" style="background:#d1fae5;color:#065f46;"><i class="fas fa-check me-1"></i>Ada</span>
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
                                <span class="badge bg-secondary">Belum</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.siswa.show', $s->id) }}" class="btn btn-sm btn-info text-white" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.siswa.edit', $s->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus data siswa {{ $s->nama_peserta_didik }}?')">
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
        $('#tabelSiswa').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
            },
            responsive: true,
            columnDefs: [{ orderable: false, targets: [-1] }]
        });
    });
</script>
@endpush
