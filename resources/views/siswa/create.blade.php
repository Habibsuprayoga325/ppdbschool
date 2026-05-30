@extends('layouts.app')
@section('title', 'Tambah Data Siswa')
@section('page-title', 'Tambah Data Siswa')

@section('content')
<div class="page-header">
    <div>
        <h1>Tambah Data Siswa</h1>
        <nav class="breadcrumb-custom">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
            <a href="{{ route('admin.siswa.index') }}">Data Siswa</a> / Tambah
        </nav>
    </div>
    <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <!-- Identitas Siswa -->
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-id-card me-2 text-primary"></i>Identitas Siswa</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NISN <span class="text-danger">*</span></label>
                            <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn') }}" placeholder="10 digit NISN">
                            @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" placeholder="16 digit NIK">
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
                            <input type="text" name="nama_panggilan" class="form-control @error('nama_panggilan') is-invalid @enderror" value="{{ old('nama_panggilan') }}">
                            @error('nama_panggilan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap Peserta Didik <span class="text-danger">*</span></label>
                            <input type="text" name="nama_peserta_didik" class="form-control @error('nama_peserta_didik') is-invalid @enderror" value="{{ old('nama_peserta_didik') }}">
                            @error('nama_peserta_didik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}">
                            @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                            @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-Laki" {{ old('jenis_kelamin') === 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Agama</label>
                            <select name="agama" class="form-select @error('agama') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
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
                </div>
            </div>

            <!-- Data Keluarga -->
            <div class="card mt-4">
                <div class="card-header"><i class="fas fa-home me-2 text-success"></i>Data Keluarga & Tempat Tinggal</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Suku</label>
                            <input type="text" name="suku" class="form-control" value="{{ old('suku') }}" placeholder="cth: Jawa">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Bahasa</label>
                            <input type="text" name="bahasa" class="form-control" value="{{ old('bahasa') }}" placeholder="cth: Indonesia">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" class="form-control" value="{{ old('kewarganegaraan', 'Indonesia') }}">
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
                            <label class="form-label">Anak Ke</label>
                            <input type="number" name="anak_ke" class="form-control" value="{{ old('anak_ke', 1) }}" min="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Saudara</label>
                            <input type="number" name="jml_saudara" class="form-control" value="{{ old('jml_saudara', 0) }}" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Tinggal</label>
                            <select name="jenis_tinggal" class="form-select">
                                <option value="">-- Pilih --</option>
                                @foreach(['Orang Tua','Wali','Kos/Mondok','Asrama','Panti','Kontrak'] as $jt)
                                    <option value="{{ $jt }}" {{ old('jenis_tinggal') === $jt ? 'selected' : '' }}>{{ $jt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jarak ke Sekolah (m)</label>
                            <input type="number" name="jarak_ke_sekolah" class="form-control" value="{{ old('jarak_ke_sekolah') }}" min="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Tinggal <span class="text-danger">*</span></label>
                            <textarea name="alamat_tinggal" class="form-control @error('alamat_tinggal') is-invalid @enderror" rows="2">{{ old('alamat_tinggal') }}</textarea>
                            @error('alamat_tinggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="provinsi_tinggal" class="form-control" value="{{ old('provinsi_tinggal') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kabupaten / Kota</label>
                            <input type="text" name="kab_kota_tinggal" class="form-control" value="{{ old('kab_kota_tinggal') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="kec_tinggal" class="form-control" value="{{ old('kec_tinggal') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kelurahan / Desa</label>
                            <input type="text" name="kelurahan_tinggal" class="form-control" value="{{ old('kelurahan_tinggal') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kode POS</label>
                            <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos') }}" maxlength="10">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Riwayat Penyakit</label>
                            <textarea name="riwayat_penyakit" class="form-control" rows="2" placeholder="Tuliskan riwayat penyakit atau tulis 'Tidak Ada'">{{ old('riwayat_penyakit', 'Tidak Ada') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Foto & Info -->
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header"><i class="fas fa-camera me-2 text-warning"></i>Foto Siswa</div>
                <div class="card-body text-center">
                    <div id="fotoPreview" style="width:150px;height:150px;border-radius:12px;background:#f1f5f9;margin:0 auto 12px;display:flex;align-items:center;justify-content:center;overflow:hidden;border:2px dashed #e2e8f0;">
                        <i class="fas fa-user fa-4x text-muted"></i>
                    </div>
                    <input type="file" name="foto_siswa" id="fotoInput" class="form-control" accept="image/*" onchange="previewFoto(this)">
                    <small class="text-muted d-block mt-2">Format: JPG, JPEG, PNG. Max 2MB</small>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header"><i class="fas fa-info-circle me-2 text-info"></i>Informasi</div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0" style="font-size:13px;">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Nomor pendaftaran akan dibuat otomatis</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Tahun ajaran terisi otomatis</li>
                        <li class="mb-2"><i class="fas fa-info-circle text-info me-2"></i>Field bertanda <span class="text-danger">*</span> wajib diisi</li>
                    </ul>
                </div>
            </div>

            <div class="d-grid gap-2 mt-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>Simpan Data
                </button>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('fotoPreview').innerHTML =
                `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
