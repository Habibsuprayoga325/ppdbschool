@extends('layouts.app')
@section('title', 'Edit Pembayaran Administrasi')
@section('page-title', 'Edit Pembayaran')

@section('content')
<div class="page-header">
    <div>
        <h1>Edit Pembayaran Administrasi</h1>
        <nav class="breadcrumb-custom">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
            <a href="{{ route('admin.administrasi.index') }}">Administrasi</a> / Edit
        </nav>
    </div>
    <a href="{{ route('admin.administrasi.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header"><i class="fas fa-edit text-primary me-2"></i>Form Edit Administrasi</div>
            <div class="card-body">
                <form action="{{ route('admin.administrasi.update', $administrasi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Siswa Terpilih (Tidak Dapat Diubah)</label>
                        <input type="text" class="form-control bg-light" value="{{ $administrasi->identitasSiswa->nama_peserta_didik }} (No. Daftar: {{ $administrasi->identitasSiswa->no_pendaftaran }} / NISN: {{ $administrasi->identitasSiswa->nisn }})" readonly>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nominal Biaya (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $administrasi->harga) }}" min="0" required>
                            @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Pembayaran <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Belum Lunas" {{ old('status', $administrasi->status) === 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                <option value="Lunas" {{ old('status', $administrasi->status) === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Keterangan / Catatan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan catatan pembayaran (opsional)">{{ old('keterangan', $administrasi->keterangan) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.administrasi.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Perbarui Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
