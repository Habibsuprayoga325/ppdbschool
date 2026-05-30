@extends('layouts.app')
@section('title', 'Edit Data Siswa')
@section('page-title', 'Edit Data Siswa')

@section('content')
<div class="page-header">
    <div>
        <h1>Edit Data Siswa</h1>
        <nav class="breadcrumb-custom">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
            <a href="{{ route('admin.siswa.index') }}">Data Siswa</a> / Edit
        </nav>
    </div>
    <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-id-card me-2 text-primary"></i>Identitas Siswa</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NISN <span class="text-danger">*</span></label>
                            <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn', $siswa->nisn) }}">
                            @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $siswa->nik) }}">
                            @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Upload Gambar Kartu Keluarga (KK)</label>
                            <input type="file" name="no_kk" class="form-control @error('no_kk') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
                            <div class="form-text small text-muted">Format: JPG, PNG, PDF (Maks. 2MB)</div>
                            @if($siswa->no_kk)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $siswa->no_kk) }}" target="_blank" class="btn btn-sm btn-outline-primary py-1 px-3">
                                        <i class="fas fa-file-download me-1"></i> Lihat KK Saat Ini
                                    </a>
                                </div>
                            @endif
                            @error('no_kk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Upload Gambar Akta Kelahiran</label>
                            <input type="file" name="foto_akta" class="form-control @error('foto_akta') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
                            <div class="form-text small text-muted">Format: JPG, PNG, PDF (Maks. 2MB)</div>
                            @if($siswa->foto_akta)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $siswa->foto_akta) }}" target="_blank" class="btn btn-sm btn-outline-primary py-1 px-3">
                                        <i class="fas fa-file-download me-1"></i> Lihat Akta Saat Ini
                                    </a>
                                </div>
                            @endif
                            @error('foto_akta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Panggilan</label>
                            <input type="text" name="nama_panggilan" class="form-control" value="{{ old('nama_panggilan', $siswa->nama_panggilan) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_peserta_didik" class="form-control @error('nama_peserta_didik') is-invalid @enderror" value="{{ old('nama_peserta_didik', $siswa->nama_peserta_didik) }}">
                            @error('nama_peserta_didik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir?->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="Laki-Laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Agama</label>
                            <select name="agama" class="form-select">
                                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                                    <option value="{{ $agama }}" {{ old('agama', $siswa->agama) === $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gol. Darah</label>
                            <select name="gol_darah" class="form-select">
                                <option value="">--</option>
                                @foreach(['A','B','AB','O','A+','A-','B+','B-','AB+','AB-','O+','O-'] as $gb)
                                    <option value="{{ $gb }}" {{ old('gol_darah', $siswa->gol_darah) === $gb ? 'selected' : '' }}>{{ $gb }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tinggi Badan (cm)</label>
                            <input type="number" name="tinggi_badan" class="form-control" value="{{ old('tinggi_badan', $siswa->tinggi_badan) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Berat Badan (kg)</label>
                            <input type="number" name="berat_badan" class="form-control" value="{{ old('berat_badan', $siswa->berat_badan) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Suku</label>
                            <input type="text" name="suku" class="form-control" value="{{ old('suku', $siswa->suku) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Bahasa</label>
                            <input type="text" name="bahasa" class="form-control" value="{{ old('bahasa', $siswa->bahasa) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" class="form-control" value="{{ old('kewarganegaraan', $siswa->kewarganegaraan) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status Anak</label>
                            <select name="status_anak" class="form-select">
                                @foreach(['Kandung','Tiri','Angkat'] as $sa)
                                    <option value="{{ $sa }}" {{ old('status_anak', $siswa->status_anak) === $sa ? 'selected' : '' }}>{{ $sa }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Anak Ke</label>
                            <input type="number" name="anak_ke" class="form-control" value="{{ old('anak_ke', $siswa->anak_ke) }}" min="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Saudara</label>
                            <input type="number" name="jml_saudara" class="form-control" value="{{ old('jml_saudara', $siswa->jml_saudara) }}" min="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Tinggal</label>
                            <textarea name="alamat_tinggal" class="form-control" rows="2">{{ old('alamat_tinggal', $siswa->alamat_tinggal) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="provinsi_tinggal" class="form-control" value="{{ old('provinsi_tinggal', $siswa->provinsi_tinggal) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kabupaten / Kota</label>
                            <input type="text" name="kab_kota_tinggal" class="form-control" value="{{ old('kab_kota_tinggal', $siswa->kab_kota_tinggal) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="kec_tinggal" class="form-control" value="{{ old('kec_tinggal', $siswa->kec_tinggal) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kelurahan</label>
                            <input type="text" name="kelurahan_tinggal" class="form-control" value="{{ old('kelurahan_tinggal', $siswa->kelurahan_tinggal) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kode POS</label>
                            <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos', $siswa->kode_pos) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jarak ke Sekolah (m)</label>
                            <input type="number" name="jarak_ke_sekolah" class="form-control" value="{{ old('jarak_ke_sekolah', $siswa->jarak_ke_sekolah) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Tinggal</label>
                            <select name="jenis_tinggal" class="form-select">
                                @foreach(['Orang Tua','Wali','Kos/Mondok','Asrama','Panti','Kontrak'] as $jt)
                                    <option value="{{ $jt }}" {{ old('jenis_tinggal', $siswa->jenis_tinggal) === $jt ? 'selected' : '' }}>{{ $jt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Riwayat Penyakit</label>
                            <textarea name="riwayat_penyakit" class="form-control" rows="2">{{ old('riwayat_penyakit', $siswa->riwayat_penyakit) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header"><i class="fas fa-camera me-2 text-warning"></i>Foto Siswa</div>
                <div class="card-body text-center">
                    <div id="fotoPreview" style="width:150px;height:150px;border-radius:12px;background:#f1f5f9;margin:0 auto 12px;display:flex;align-items:center;justify-content:center;overflow:hidden;border:2px dashed #e2e8f0;">
                        @if($siswa->foto_siswa)
                            <img src="{{ asset('storage/' . $siswa->foto_siswa) }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <i class="fas fa-user fa-4x text-muted"></i>
                        @endif
                    </div>
                    <input type="file" name="foto_siswa" id="fotoInput" class="form-control" accept="image/*" onchange="previewFoto(this)">
                    <small class="text-muted d-block mt-2">Kosongkan jika tidak ingin mengubah foto</small>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">Info Pendaftaran</div>
                <div class="card-body">
                    <div class="mb-2"><small class="text-muted">No. Pendaftaran</small><br><strong>{{ $siswa->no_pendaftaran }}</strong></div>
                    <div class="mb-2"><small class="text-muted">Tahun Ajaran</small><br><strong>{{ $siswa->tahun_ajaran }}</strong></div>
                    <div><small class="text-muted">Terdaftar</small><br><strong>{{ $siswa->created_at->format('d/m/Y H:i') }}</strong></div>
                </div>
            </div>

            <div class="d-grid gap-2 mt-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">Batal</a>
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
