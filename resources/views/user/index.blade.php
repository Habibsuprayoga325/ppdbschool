@extends('layouts.app')
@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@push('styles')
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="page-header">
    <div>
        <h1>Manajemen Pengguna</h1>
        <nav class="breadcrumb-custom"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Pengguna</nav>
    </div>
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Pengguna
    </a>
</div>

<div class="card">
    <div class="card-header"><i class="fas fa-user-shield text-primary me-2"></i>Daftar Pengguna Sistem</div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tabelUsers" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Hak Akses</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $i => $u)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div class="fw-semibold">{{ $u->nama }}</div>
                            @if(auth()->id() === $u->id)
                                <span class="badge bg-light text-primary border small">Anda</span>
                            @endif
                        </td>
                        <td><code>{{ $u->username }}</code></td>
                        <td>
                            @if($u->hak === 'admin')
                                <span class="badge bg-primary text-white"><i class="fas fa-shield-alt me-1"></i>Admin</span>
                            @else
                                <span class="badge bg-info text-white"><i class="fas fa-user me-1"></i>Pegawai</span>
                            @endif
                        </td>
                        <td>
                            @if($u->status === 'aktif')
                                <span class="badge" style="background:#d1fae5;color:#065f46;">Aktif</span>
                            @else
                                <span class="badge" style="background:#fee2e2;color:#991b1b;">Tidak Aktif</span>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $u->created_at?->format('d/m/Y') ?: '-' }}</small></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.user.edit', $u->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(auth()->id() !== $u->id)
                                <form action="{{ route('admin.user.destroy', $u->id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $u->nama }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                                @endif
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
    $('#tabelUsers').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json' },
        responsive: true,
        columnDefs: [{ orderable: false, targets: [-1] }]
    });
});
</script>
@endpush
