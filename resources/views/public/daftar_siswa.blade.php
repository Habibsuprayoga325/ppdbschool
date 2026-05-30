@extends('layouts.public')

@section('title', 'Pendaftaran Siswa Baru - PPDB Online')

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
                    <div class="progress-step active">
                        <div class="step-indicator">1</div>
                        <span class="step-label">Data Siswa</span>
                    </div>
                    <div class="progress-step">
                        <div class="step-indicator">2</div>
                        <span class="step-label">Data Orang Tua</span>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="form-wrapper">
                    <div class="mb-4">
                        <h2 class="fw-bold text-dark mb-2">Formulir Pendaftaran Siswa Baru</h2>
                        <p class="text-muted">Isi informasi data identitas calon peserta didik di bawah ini dengan lengkap dan benar.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan pada inputan Anda. Silakan periksa kembali.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('public.store-siswa') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- 1. Identitas Pokok -->
                        <div class="form-section-title">
                            <i class="fas fa-id-card"></i> Identitas Pokok Siswa
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">NISN <span class="text-danger">*</span></label>
                                <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn') }}" placeholder="10 digit nomor NISN" required>
                                @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" placeholder="16 digit nomor NIK sesuai KK" required>
                                @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Upload Gambar Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                                <input type="file" name="no_kk" class="form-control @error('no_kk') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf" required>
                                <div class="form-text small text-muted">Format: JPG, PNG, PDF (Maks. 2MB)</div>
                                @error('no_kk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Upload Gambar Akta Kelahiran <span class="text-danger">*</span></label>
                                <input type="file" name="foto_akta" class="form-control @error('foto_akta') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf" required>
                                <div class="form-text small text-muted">Format: JPG, PNG, PDF (Maks. 2MB)</div>
                                @error('foto_akta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Panggilan <span class="text-danger">*</span></label>
                                <input type="text" name="nama_panggilan" class="form-control @error('nama_panggilan') is-invalid @enderror" value="{{ old('nama_panggilan') }}" placeholder="Panggilan akrab siswa" required>
                                @error('nama_panggilan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Nama Lengkap Peserta Didik <span class="text-danger">*</span></label>
                                <input type="text" name="nama_peserta_didik" class="form-control @error('nama_peserta_didik') is-invalid @enderror" value="{{ old('nama_peserta_didik') }}" placeholder="Nama lengkap sesuai Akta Lahir" required>
                                @error('nama_peserta_didik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}" required>
                                @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}" required>
                                @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-Laki" {{ old('jenis_kelamin') === 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Agama <span class="text-danger">*</span></label>
                                <select name="agama" class="form-select @error('agama') is-invalid @enderror" required>
                                    <option value="">-- Pilih Agama --</option>
                                    @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                                        <option value="{{ $agama }}" {{ old('agama') === $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                    @endforeach
                                </select>
                                @error('agama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Gol. Darah</label>
                                <select name="gol_darah" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['A','B','AB','O','A+','A-','B+','B-','AB+','AB-','O+','O-'] as $gb)
                                        <option value="{{ $gb }}" {{ old('gol_darah') === $gb ? 'selected' : '' }}>{{ $gb }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tinggi Badan (cm)</label>
                                <input type="number" name="tinggi_badan" class="form-control" value="{{ old('tinggi_badan') }}" min="50" max="250">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Berat Badan (kg)</label>
                                <input type="number" name="berat_badan" class="form-control" value="{{ old('berat_badan') }}" min="5" max="150">
                            </div>
                        </div>

                        <!-- 2. Data Keluarga & Tempat Tinggal -->
                        <div class="form-section-title">
                            <i class="fas fa-home"></i> Data Tempat Tinggal & Keluarga
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Suku Bangsa</label>
                                <input type="text" name="suku" class="form-control" value="{{ old('suku') }}" placeholder="Cth: Jawa, Sunda">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Bahasa Sehari-hari</label>
                                <input type="text" name="bahasa" class="form-control" value="{{ old('bahasa') }}" placeholder="Cth: Indonesia">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kewarganegaraan <span class="text-danger">*</span></label>
                                <input type="text" name="kewarganegaraan" class="form-control @error('kewarganegaraan') is-invalid @enderror" value="{{ old('kewarganegaraan', 'Indonesia') }}" required>
                                @error('kewarganegaraan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status Anak</label>
                                <select name="status_anak" class="form-select">
                                    <option value="Kandung" {{ old('status_anak') === 'Kandung' ? 'selected' : '' }}>Kandung</option>
                                    <option value="Tiri" {{ old('status_anak') === 'Tiri' ? 'selected' : '' }}>Tiri</option>
                                    <option value="Angkat" {{ old('status_anak') === 'Angkat' ? 'selected' : '' }}>Angkat</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Anak Ke- <span class="text-danger">*</span></label>
                                <input type="number" name="anak_ke" class="form-control @error('anak_ke') is-invalid @enderror" value="{{ old('anak_ke', 1) }}" min="1" required>
                                @error('anak_ke')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jumlah Saudara <span class="text-danger">*</span></label>
                                <input type="number" name="jml_saudara" class="form-control @error('jml_saudara') is-invalid @enderror" value="{{ old('jml_saudara', 0) }}" min="0" required>
                                @error('jml_saudara')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Tempat Tinggal</label>
                                <select name="jenis_tinggal" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['Orang Tua','Wali','Kos/Mondok','Asrama','Panti','Kontrak'] as $jt)
                                        <option value="{{ $jt }}" {{ old('jenis_tinggal') === $jt ? 'selected' : '' }}>{{ $jt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jarak ke Sekolah (meter)</label>
                                <input type="number" name="jarak_ke_sekolah" class="form-control" value="{{ old('jarak_ke_sekolah') }}" min="0" placeholder="Estimasi jarak dalam meter">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat Lengkap Tinggal <span class="text-danger">*</span></label>
                                <textarea name="alamat_tinggal" class="form-control @error('alamat_tinggal') is-invalid @enderror" rows="2" placeholder="Nama jalan, nomor rumah, RT/RW" required>{{ old('alamat_tinggal') }}</textarea>
                                @error('alamat_tinggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" name="provinsi_tinggal" class="form-control @error('provinsi_tinggal') is-invalid @enderror" value="{{ old('provinsi_tinggal') }}" required>
                                @error('provinsi_tinggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kabupaten / Kota <span class="text-danger">*</span></label>
                                <input type="text" name="kab_kota_tinggal" class="form-control @error('kab_kota_tinggal') is-invalid @enderror" value="{{ old('kab_kota_tinggal') }}" required>
                                @error('kab_kota_tinggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" name="kec_tinggal" class="form-control @error('kec_tinggal') is-invalid @enderror" value="{{ old('kec_tinggal') }}" required>
                                @error('kec_tinggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kelurahan / Desa <span class="text-danger">*</span></label>
                                <input type="text" name="kelurahan_tinggal" class="form-control @error('kelurahan_tinggal') is-invalid @enderror" value="{{ old('kelurahan_tinggal') }}" required>
                                @error('kelurahan_tinggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kode POS</label>
                                <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos') }}" maxlength="10">
                            </div>
                        </div>

                        <!-- 3. Riwayat Kesehatan -->
                        <div class="form-section-title">
                            <i class="fas fa-heartbeat"></i> Riwayat Kesehatan
                        </div>
                        <div class="row g-3 mb-5">
                            <div class="col-12">
                                <label class="form-label">Riwayat Penyakit (Alergi, Asma, dll)</label>
                                <textarea name="riwayat_penyakit" class="form-control" rows="2" placeholder="Kosongkan jika tidak ada, atau isi 'Tidak Ada'">{{ old('riwayat_penyakit', 'Tidak Ada') }}</textarea>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('public.index') }}" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 10px;">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-2 btn-navbar">
                                Lanjut Langkah 2 <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
