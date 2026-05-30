@extends('layouts.app')
@section('title', 'Data Orang Tua / Wali')
@section('page-title', 'Data Orang Tua / Wali')

@push('styles')
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="page-header">
    <div>
        <h1>Data Orang Tua / Wali</h1>
        <nav class="breadcrumb-custom"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Data Orang Tua</nav>
    </div>
    <a href="{{ route('admin.orangtua.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Data
    </a>
</div>

<div class="card">
    <div class="card-header"><i class="fas fa-users me-2 text-primary"></i>Daftar Orang Tua / Wali</div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tabelOrtu" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Nama Ayah</th>
                        <th>Nama Ibu</th>
                        <th>Telepon Ayah</th>
                        <th>Telepon Ibu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orangTua as $i => $ot)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div class="fw-semibold">{{ $ot->identitasSiswa->nama_peserta_didik ?? '-' }}</div>
                            <small class="text-muted">{{ $ot->identitasSiswa->nisn ?? '' }}</small>
                        </td>
                        <td>{{ $ot->nama_ayah }}<br><small class="text-muted">{{ $ot->status_ayah }}</small></td>
                        <td>{{ $ot->nama_ibu }}<br><small class="text-muted">{{ $ot->status_ibu }}</small></td>
                        <td>{{ $ot->telepon_ayah ?: '-' }}</td>
                        <td>{{ $ot->telepon_ibu ?: '-' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.orangtua.edit', $ot->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.orangtua.destroy', $ot->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus data orang tua {{ $ot->nama_ayah }}?')">
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
    $('#tabelOrtu').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json' },
        responsive: true,
        columnDefs: [{ orderable: false, targets: [-1] }]
    });
});
</script>
@endpush
