@extends('layouts.app')
@section('title', 'Tambah Orang Tua / Wali')
@section('page-title', 'Tambah Data Orang Tua')

@section('content')
<div class="page-header">
    <div>
        <h1>Tambah Orang Tua / Wali</h1>
        <nav class="breadcrumb-custom">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
            <a href="{{ route('admin.orangtua.index') }}">Orang Tua</a> / Tambah
        </nav>
    </div>
    <a href="{{ route('admin.orangtua.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form action="{{ route('admin.orangtua.store') }}" method="POST">
    @csrf
    
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-child text-primary me-2"></i>Hubungkan dengan Calon Siswa</div>
        <div class="card-body">
            <div class="mb-2">
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
                <small class="text-muted d-block mt-1">Hanya menampilkan siswa yang belum memiliki data orang tua/wali.</small>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Ayah Section -->
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-white"><i class="fas fa-male text-success me-2"></i>Data Ayah Kandung</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap Ayah <span class="text-danger">*</span></label>
                            <input type="text" name="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah') }}" required>
                            @error('nama_ayah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Ayah <span class="text-danger">*</span></label>
                            <select name="status_ayah" class="form-select" required>
                                <option value="Kandung" {{ old('status_ayah') === 'Kandung' ? 'selected' : '' }}>Kandung</option>
                                <option value="Tiri" {{ old('status_ayah') === 'Tiri' ? 'selected' : '' }}>Tiri</option>
                                <option value="Angkat" {{ old('status_ayah') === 'Angkat' ? 'selected' : '' }}>Angkat</option>
                                <option value="Meninggal Dunia" {{ old('status_ayah') === 'Meninggal Dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir Ayah</label>
                            <input type="date" name="tgl_lahir_ayah" class="form-control" value="{{ old('tgl_lahir_ayah') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon / HP</label>
                            <input type="text" name="telepon_ayah" class="form-control" value="{{ old('telepon_ayah') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir_ayah" class="form-select">
                                <option value="">-- Pilih --</option>
                                @foreach(['SD','SMP','SMA/SMK','D1/D2/D3','S1','S2/S3','Tidak Sekolah'] as $pd)
                                    <option value="{{ $pd }}" {{ old('pendidikan_terakhir_ayah') === $pd ? 'selected' : '' }}>{{ $pd }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan_ayah" class="form-control" value="{{ old('pekerjaan_ayah') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Penghasilan (Rp / Bulan)</label>
                            <input type="number" name="penghasilan_ayah" class="form-control" value="{{ old('penghasilan_ayah') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Ayah</label>
                            <textarea name="alamat_ayah" class="form-control" rows="2">{{ old('alamat_ayah') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ibu Section -->
        <div class="col-12 col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-white"><i class="fas fa-female text-danger me-2"></i>Data Ibu Kandung</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap Ibu <span class="text-danger">*</span></label>
                            <input type="text" name="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu') }}" required>
                            @error('nama_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Ibu <span class="text-danger">*</span></label>
                            <select name="status_ibu" class="form-select" required>
                                <option value="Kandung" {{ old('status_ibu') === 'Kandung' ? 'selected' : '' }}>Kandung</option>
                                <option value="Tiri" {{ old('status_ibu') === 'Tiri' ? 'selected' : '' }}>Tiri</option>
                                <option value="Angkat" {{ old('status_ibu') === 'Angkat' ? 'selected' : '' }}>Angkat</option>
                                <option value="Meninggal Dunia" {{ old('status_ibu') === 'Meninggal Dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir Ibu</label>
                            <input type="date" name="tgl_lahir_ibu" class="form-control" value="{{ old('tgl_lahir_ibu') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon / HP</label>
                            <input type="text" name="telepon_ibu" class="form-control" value="{{ old('telepon_ibu') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir_ibu" class="form-select">
                                <option value="">-- Pilih --</option>
                                @foreach(['SD','SMP','SMA/SMK','D1/D2/D3','S1','S2/S3','Tidak Sekolah'] as $pd)
                                    <option value="{{ $pd }}" {{ old('pendidikan_terakhir_ibu') === $pd ? 'selected' : '' }}>{{ $pd }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan_ibu" class="form-control" value="{{ old('pekerjaan_ibu') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Penghasilan (Rp / Bulan)</label>
                            <input type="number" name="penghasilan_ibu" class="form-control" value="{{ old('penghasilan_ibu') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Ibu</label>
                            <textarea name="alamat_ibu" class="form-control" rows="2">{{ old('alamat_ibu') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wali Section -->
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white"><i class="fas fa-user-friends text-info me-2"></i>Data Wali (Opsional)</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Nama Wali</label>
                            <input type="text" name="nama_wali" class="form-control" value="{{ old('nama_wali') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Hubungan / Status Wali</label>
                            <input type="text" name="status_wali" class="form-control" value="{{ old('status_wali') }}" placeholder="Cth: Paman, Kakek">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Lahir Wali</label>
                            <input type="date" name="tgl_lahir_wali" class="form-control" value="{{ old('tgl_lahir_wali') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">No. Telepon / HP Wali</label>
                            <input type="text" name="telepon_wali" class="form-control" value="{{ old('telepon_wali') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pendidikan Terakhir Wali</label>
                            <select name="pendidikan_terakhir_wali" class="form-select">
                                <option value="">-- Pilih --</option>
                                @foreach(['SD','SMP','SMA/SMK','D1/D2/D3','S1','S2/S3','Tidak Sekolah'] as $pd)
                                    <option value="{{ $pd }}" {{ old('pendidikan_terakhir_wali') === $pd ? 'selected' : '' }}>{{ $pd }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pekerjaan Wali</label>
                            <input type="text" name="pekerjaan_wali" class="form-control" value="{{ old('pekerjaan_wali') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Penghasilan Wali (Rp / Bulan)</label>
                            <input type="number" name="penghasilan_wali" class="form-control" value="{{ old('penghasilan_wali') }}">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Alamat Wali</label>
                            <textarea name="alamat_wali" class="form-control" rows="1">{{ old('alamat_wali') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{ route('admin.orangtua.index') }}" class="btn btn-outline-secondary">
            Batal
        </a>
        <button type="submit" class="btn btn-primary btn-lg px-4">
            <i class="fas fa-save me-2"></i>Simpan Data
        </button>
    </div>
</form>
@endsection
