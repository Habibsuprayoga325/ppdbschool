@extends('layouts.app')
@section('title', 'Tambah Pembayaran Administrasi')
@section('page-title', 'Tambah Pembayaran')

@section('content')
<div class="page-header">
    <div>
        <h1>Tambah Pembayaran Administrasi</h1>
        <nav class="breadcrumb-custom">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
            <a href="{{ route('admin.administrasi.index') }}">Administrasi</a> / Tambah
        </nav>
    </div>
    <a href="{{ route('admin.administrasi.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header"><i class="fas fa-money-bill-wave text-primary me-2"></i>Form Administrasi Baru</div>
            <div class="card-body">
                <form action="{{ route('admin.administrasi.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Calon Siswa <span class="text-danger">*</span></label>
                        <select name="identitas_siswa_id" class="form-select @error('identitas_siswa_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Calon Siswa --</option>
                            @foreach($siswa as $s)
                                <option value="{{ $s->id }}" {{ old('identitas_siswa_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama_peserta_didik }} (No. Daftar: {{ $s->no_pendaftaran }} / NISN: {{ $s->nisn }})
                                </option>
                            @endforeach
                        </select>
                        @error('identitas_siswa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted d-block mt-1">Hanya menampilkan siswa yang belum memiliki data administrasi pembayaran.</small>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nominal Biaya (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', 1250000) }}" min="0" required>
                            @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Pembayaran <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Belum Lunas" {{ old('status') === 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                <option value="Lunas" {{ old('status') === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Keterangan / Catatan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan catatan pembayaran (opsional)">{{ old('keterangan', 'Pembayaran biaya pendaftaran') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.administrasi.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
