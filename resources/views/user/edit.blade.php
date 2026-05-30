@extends('layouts.app')
@section('title', 'Edit Data Pengguna')
@section('page-title', 'Edit Pengguna')

@section('content')
<div class="page-header">
    <div>
        <h1>Edit Data Pengguna</h1>
        <nav class="breadcrumb-custom">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
            <a href="{{ route('admin.user.index') }}">Pengguna</a> / Edit
        </nav>
    </div>
    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header"><i class="fas fa-user-edit text-primary me-2"></i>Form Edit Akun Pengguna</div>
            <div class="card-body">
                <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->nama) }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>
                        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="p-3 rounded border border-warning-subtle bg-warning-subtle bg-opacity-10 mb-3">
                        <small class="text-warning d-block mb-2 fw-semibold"><i class="fas fa-info-circle me-1"></i>Reset Password (Opsional)</small>
                        <small class="text-muted d-block mb-3">Kosongkan kolom di bawah ini jika Anda tidak ingin memperbarui password saat ini.</small>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min. 6 karakter">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Hak Akses <span class="text-danger">*</span></label>
                            <select name="hak" class="form-select @error('hak') is-invalid @enderror" required>
                                <option value="pegawai" {{ old('hak', $user->hak) === 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                                <option value="admin" {{ old('hak', $user->hak) === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('hak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Akun <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="aktif" {{ old('status', $user->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak aktif" {{ old('status', $user->status) === 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Perbarui Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
