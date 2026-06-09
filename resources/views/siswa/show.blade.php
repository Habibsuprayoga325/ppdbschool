@extends('layouts.app')
@section('title', 'Detail Siswa')
@section('page-title', 'Detail Siswa')

@section('content')
<div class="page-header">
    <div>
        <h1>Detail Siswa</h1>
        <nav class="breadcrumb-custom">
            <a href="{{ route('admin.siswa.index') }}">Data Siswa</a> / Detail
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.cetak.kartu', $siswa->id) }}" class="btn btn-success" target="_blank">
            <i class="fas fa-print me-2"></i>Cetak Kartu
        </a>
        <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning text-white">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-4">
        <div class="card text-center">
            <div class="card-body py-4">
                @if($siswa->foto_siswa)
                    <img src="{{ asset('storage/' . $siswa->foto_siswa) }}" class="rounded-circle mb-3" style="width:120px;height:120px;object-fit:cover;">
                @else
                    <div style="width:120px;height:120px;border-radius:50%;background:#f1f5f9;border:1.5px solid #cbd5e1;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:48px;color:#1e7c3e;font-weight:700;">
                        {{ strtoupper(substr($siswa->nama_peserta_didik, 0, 1)) }}
                    </div>
                @endif
                <h5 class="fw-bold mb-1">{{ $siswa->nama_peserta_didik }}</h5>
                <p class="text-muted mb-2">{{ $siswa->nama_panggilan }}</p>
                <span class="badge" style="background:#eef2ff;color:#4f46e5;font-size:13px;">{{ $siswa->no_pendaftaran }}</span>
                <hr>
                <div class="row text-start g-2" style="font-size:13px;">
                    <div class="col-6"><span class="text-muted">NISN</span><br><strong>{{ $siswa->nisn }}</strong></div>
                    <div class="col-6"><span class="text-muted">NIK</span><br><strong>{{ $siswa->nik }}</strong></div>
                    <div class="col-12"><span class="text-muted">Tahun Ajaran</span><br><strong>{{ $siswa->tahun_ajaran }}</strong></div>
                    <div class="col-6">
                        <span class="text-muted">Data Ortu</span><br>
                        @if($siswa->status_ortu)
                            <span class="badge" style="background:#d1fae5;color:#065f46;">Lengkap</span>
                        @else
                            <span class="badge" style="background:#fee2e2;color:#991b1b;">Belum</span>
                        @endif
                    </div>
                    <div class="col-6">
                        <span class="text-muted">Administrasi</span><br>
                        @if($siswa->administrasi)
                            <span class="badge {{ $siswa->administrasi->status === 'Lunas' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $siswa->administrasi->status }}</span>
                        @else
                            <span class="badge bg-secondary">Belum</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-id-card me-2 text-primary"></i>Data Identitas</div>
            <div class="card-body">
                <div class="row g-3" style="font-size:14px;">
                    @php $fields = [
                        'Tempat Lahir' => $siswa->tempat_lahir,
                        'Tanggal Lahir' => $siswa->tanggal_lahir?->format('d F Y'),
                        'Jenis Kelamin' => $siswa->jenis_kelamin,
                        'Agama' => $siswa->agama,
                        'Gol. Darah' => $siswa->gol_darah ?: '-',
                        'Tinggi Badan' => ($siswa->tinggi_badan ? $siswa->tinggi_badan . ' cm' : '-'),
                        'Berat Badan' => ($siswa->berat_badan ? $siswa->berat_badan . ' kg' : '-'),
                        'Suku' => $siswa->suku ?: '-',
                        'Bahasa' => $siswa->bahasa ?: '-',
                        'Kewarganegaraan' => $siswa->kewarganegaraan,
                        'Status Anak' => $siswa->status_anak ?: '-',
                        'Anak Ke' => $siswa->anak_ke,
                        'Jml Saudara' => $siswa->jml_saudara,
                        'Jenis Tinggal' => $siswa->jenis_tinggal ?: '-',
                        'Jarak ke Sekolah' => ($siswa->jarak_ke_sekolah ? $siswa->jarak_ke_sekolah . ' m' : '-'),
                    ]; @endphp
                    @foreach($fields as $label => $value)
                    <div class="col-6 col-md-4">
                        <div class="text-muted" style="font-size:12px;">{{ $label }}</div>
                        <div class="fw-medium">{{ $value }}</div>
                    </div>
                    @endforeach
                    <div class="col-12">
                        <div class="text-muted" style="font-size:12px;">Alamat Tinggal</div>
                        <div class="fw-medium">{{ $siswa->alamat_tinggal }}, {{ $siswa->kelurahan_tinggal }}, {{ $siswa->kec_tinggal }}, {{ $siswa->kab_kota_tinggal }}, {{ $siswa->provinsi_tinggal }} {{ $siswa->kode_pos }}</div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted" style="font-size:12px;">Riwayat Penyakit</div>
                        <div class="fw-medium">{{ $siswa->riwayat_penyakit ?: '-' }}</div>
                    </div>
                    <div class="col-12 mt-3 border-top pt-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="text-muted mb-1" style="font-size:12px;">Dokumen Kartu Keluarga (KK)</div>
                                @if($siswa->no_kk)
                                    <a href="{{ asset('storage/' . $siswa->no_kk) }}" target="_blank" class="btn btn-sm btn-outline-primary py-2 px-3">
                                        <i class="fas fa-file-download me-1"></i> Lihat / Unduh Kartu Keluarga
                                    </a>
                                @else
                                    <span class="text-danger small"><i class="fas fa-times-circle me-1"></i> Belum diunggah</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted mb-1" style="font-size:12px;">Dokumen Akta Kelahiran</div>
                                @if($siswa->foto_akta)
                                    <a href="{{ asset('storage/' . $siswa->foto_akta) }}" target="_blank" class="btn btn-sm btn-outline-primary py-2 px-3">
                                        <i class="fas fa-file-download me-1"></i> Lihat / Unduh Akta Kelahiran
                                    </a>
                                @else
                                    <span class="text-danger small"><i class="fas fa-times-circle me-1"></i> Belum diunggah</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($siswa->orangTuaWali)
        <div class="card">
            <div class="card-header"><i class="fas fa-users me-2 text-success"></i>Data Orang Tua / Wali</div>
            <div class="card-body" style="font-size:14px;">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Data Ayah</h6>
                        <div><span class="text-muted">Nama:</span> {{ $siswa->orangTuaWali->nama_ayah }}</div>
                        <div><span class="text-muted">Status:</span> {{ $siswa->orangTuaWali->status_ayah }}</div>
                        <div><span class="text-muted">Telepon:</span> {{ $siswa->orangTuaWali->telepon_ayah ?: '-' }}</div>
                        <div><span class="text-muted">Pekerjaan:</span> {{ $siswa->orangTuaWali->pekerjaan_ayah ?: '-' }}</div>
                        <div><span class="text-muted">Pendidikan:</span> {{ $siswa->orangTuaWali->pendidikan_terakhir_ayah ?: '-' }}</div>
                        <div><span class="text-muted">Penghasilan:</span> Rp {{ number_format($siswa->orangTuaWali->penghasilan_ayah ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-2">Data Ibu</h6>
                        <div><span class="text-muted">Nama:</span> {{ $siswa->orangTuaWali->nama_ibu }}</div>
                        <div><span class="text-muted">Status:</span> {{ $siswa->orangTuaWali->status_ibu }}</div>
                        <div><span class="text-muted">Telepon:</span> {{ $siswa->orangTuaWali->telepon_ibu ?: '-' }}</div>
                        <div><span class="text-muted">Pekerjaan:</span> {{ $siswa->orangTuaWali->pekerjaan_ibu ?: '-' }}</div>
                        <div><span class="text-muted">Pendidikan:</span> {{ $siswa->orangTuaWali->pendidikan_terakhir_ibu ?: '-' }}</div>
                        <div><span class="text-muted">Penghasilan:</span> Rp {{ number_format($siswa->orangTuaWali->penghasilan_ibu ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>Data orang tua belum diisi.
            <a href="{{ route('admin.orangtua.create') }}" class="alert-link">Tambah sekarang</a>
        </div>
        @endif
    </div>
</div>
@endsection
