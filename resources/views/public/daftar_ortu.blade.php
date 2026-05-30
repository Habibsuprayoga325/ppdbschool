@extends('layouts.public')

@section('title', 'Pendaftaran Orang Tua / Wali - PPDB Online')

@push('styles')
<style>
    .registration-container {
        padding: 50px 0 80px;
        background: #f8fafc;
        min-height: calc(100vh - 150px);
    }
    .form-wrapper {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    }
    .progress-bar-container {
        display: flex;
        justify-content: center;
        margin-bottom: 40px;
        position: relative;
    }
    .progress-bar-container::before {
        content: '';
        position: absolute;
        top: 23px; left: 25%; right: 25%;
        height: 3px;
        background: #e2e8f0;
        z-index: 1;
    }
    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        z-index: 2;
        width: 150px;
    }
    .step-indicator {
        width: 48px; height: 48px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #64748b;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
        margin-bottom: 10px;
        border: 4px solid white;
        transition: all 0.3s;
    }
    .progress-step.active .step-indicator {
        background: var(--primary);
        color: white;
        box-shadow: 0 0 0 4px rgba(15, 76, 129, 0.15);
    }
    .progress-step.completed .step-indicator {
        background: var(--success);
        color: white;
    }

    .step-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }
    .progress-step.active .step-label {
        color: var(--primary);
    }
    .progress-step.completed .step-label {
        color: var(--success);
    }
    .form-section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        border-bottom: 2px solid var(--primary-light);
        padding-bottom: 8px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-section-title i {
        color: var(--primary);
    }
</style>
@endpush

@section('content')
<div class="registration-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <!-- Progress Header -->
                <div class="progress-bar-container">
                    <div class="progress-step completed">
                        <div class="step-indicator"><i class="fas fa-check"></i></div>
                        <span class="step-label">Data Siswa</span>
                    </div>
                    <div class="progress-step active">
                        <div class="step-indicator">2</div>
                        <span class="step-label">Data Orang Tua</span>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="form-wrapper">
                    <div class="mb-4">
                        <h2 class="fw-bold text-dark mb-2">Formulir Orang Tua / Wali</h2>
                        <p class="text-muted">Isi identitas orang tua kandung atau wali dari calon peserta didik.</p>
                        <div class="alert alert-info border-0 shadow-sm d-flex align-items-center gap-3" style="border-radius:12px;">
                            <i class="fas fa-user-check fs-4"></i>
                            <div>
                                <small class="d-block text-muted">Siswa yang didaftarkan:</small>
                                <strong>{{ $siswa->nama_peserta_didik }}</strong> (NISN: {{ $siswa->nisn }})
                            </div>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan pada inputan Anda. Silakan periksa kembali.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('public.store-ortu') }}" method="POST">
                        @csrf
                        <input type="hidden" name="identitas_siswa_id" value="{{ $siswa->id }}">
                        
                        <!-- 1. Data Ayah -->
                        <div class="form-section-title">
                            <i class="fas fa-male"></i> Data Ayah Kandung
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap Ayah <span class="text-danger">*</span></label>
                                <input type="text" name="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah') }}" placeholder="Sesuai dokumen identitas" required>
                                @error('nama_ayah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status Ayah <span class="text-danger">*</span></label>
                                <select name="status_ayah" class="form-select @error('status_ayah') is-invalid @enderror" required>
                                    <option value="Kandung" {{ old('status_ayah') === 'Kandung' ? 'selected' : '' }}>Kandung</option>
                                    <option value="Tiri" {{ old('status_ayah') === 'Tiri' ? 'selected' : '' }}>Tiri</option>
                                    <option value="Angkat" {{ old('status_ayah') === 'Angkat' ? 'selected' : '' }}>Angkat</option>
                                    <option value="Meninggal Dunia" {{ old('status_ayah') === 'Meninggal Dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
                                </select>
                                @error('status_ayah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir Ayah</label>
                                <input type="date" name="tgl_lahir_ayah" class="form-control" value="{{ old('tgl_lahir_ayah') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. Telepon / HP Ayah</label>
                                <input type="text" name="telepon_ayah" class="form-control" value="{{ old('telepon_ayah') }}" placeholder="Cth: 08123456789">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pendidikan Terakhir Ayah</label>
                                <select name="pendidikan_terakhir_ayah" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['SD','SMP','SMA/SMK','D1/D2/D3','S1','S2/S3','Tidak Sekolah'] as $pd)
                                        <option value="{{ $pd }}" {{ old('pendidikan_terakhir_ayah') === $pd ? 'selected' : '' }}>{{ $pd }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pekerjaan Ayah</label>
                                <input type="text" name="pekerjaan_ayah" class="form-control" value="{{ old('pekerjaan_ayah') }}" placeholder="Cth: Karyawan Swasta, PNS">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Penghasilan Ayah (Rp / Bulan)</label>
                                <input type="number" name="penghasilan_ayah" class="form-control" value="{{ old('penghasilan_ayah') }}" placeholder="Cth: 3500000">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat Ayah</label>
                                <textarea name="alamat_ayah" class="form-control" rows="2" placeholder="Kosongkan jika sama dengan alamat siswa">{{ old('alamat_ayah') }}</textarea>
                            </div>
                        </div>

                        <!-- 2. Data Ibu -->
                        <div class="form-section-title">
                            <i class="fas fa-female"></i> Data Ibu Kandung
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap Ibu <span class="text-danger">*</span></label>
                                <input type="text" name="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu') }}" placeholder="Sesuai dokumen identitas" required>
                                @error('nama_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status Ibu <span class="text-danger">*</span></label>
                                <select name="status_ibu" class="form-select @error('status_ibu') is-invalid @enderror" required>
                                    <option value="Kandung" {{ old('status_ibu') === 'Kandung' ? 'selected' : '' }}>Kandung</option>
                                    <option value="Tiri" {{ old('status_ibu') === 'Tiri' ? 'selected' : '' }}>Tiri</option>
                                    <option value="Angkat" {{ old('status_ibu') === 'Angkat' ? 'selected' : '' }}>Angkat</option>
                                    <option value="Meninggal Dunia" {{ old('status_ibu') === 'Meninggal Dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
                                </select>
                                @error('status_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir Ibu</label>
                                <input type="date" name="tgl_lahir_ibu" class="form-control" value="{{ old('tgl_lahir_ibu') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. Telepon / HP Ibu</label>
                                <input type="text" name="telepon_ibu" class="form-control" value="{{ old('telepon_ibu') }}" placeholder="Cth: 08123456789">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pendidikan Terakhir Ibu</label>
                                <select name="pendidikan_terakhir_ibu" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['SD','SMP','SMA/SMK','D1/D2/D3','S1','S2/S3','Tidak Sekolah'] as $pd)
                                        <option value="{{ $pd }}" {{ old('pendidikan_terakhir_ibu') === $pd ? 'selected' : '' }}>{{ $pd }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pekerjaan Ibu</label>
                                <input type="text" name="pekerjaan_ibu" class="form-control" value="{{ old('pekerjaan_ibu') }}" placeholder="Cth: Ibu Rumah Tangga">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Penghasilan Ibu (Rp / Bulan)</label>
                                <input type="number" name="penghasilan_ibu" class="form-control" value="{{ old('penghasilan_ibu') }}" placeholder="Cth: 0">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat Ibu</label>
                                <textarea name="alamat_ibu" class="form-control" rows="2" placeholder="Kosongkan jika sama dengan alamat siswa">{{ old('alamat_ibu') }}</textarea>
                            </div>
                        </div>

                        <!-- 3. Data Wali (Opsional) -->
                        <div class="form-section-title">
                            <i class="fas fa-user-friends"></i> Data Wali (Opsional)
                        </div>
                        <div class="row g-3 mb-5">
                            <div class="col-md-6">
                                <label class="form-label">Nama Wali</label>
                                <input type="text" name="nama_wali" class="form-control" value="{{ old('nama_wali') }}" placeholder="Kosongkan jika tidak ada">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Hubungan Wali</label>
                                <input type="text" name="status_wali" class="form-control" value="{{ old('status_wali') }}" placeholder="Cth: Kakek, Paman">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Telepon Wali</label>
                                <input type="text" name="telepon_wali" class="form-control" value="{{ old('telepon_wali') }}">
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-outline-secondary px-4 py-2" style="border-radius:10px;" onclick="history.back()">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </button>
                            <button type="submit" class="btn btn-primary px-5 py-2 btn-navbar">
                                <i class="fas fa-save me-2"></i>Kirim Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
