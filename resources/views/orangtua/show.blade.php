@extends('layouts.app')
@section('title', 'Detail Orang Tua / Wali')
@section('page-title', 'Detail Orang Tua')

@section('content')
<div class="page-header">
    <div>
        <h1>Detail Orang Tua / Wali</h1>
        <nav class="breadcrumb-custom">
            <a href="{{ route('admin.orangtua.index') }}">Orang Tua</a> / Detail
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.orangtua.edit', $orangTua->id) }}" class="btn btn-warning text-white">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <a href="{{ route('admin.orangtua.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Summary Siswa -->
    <div class="col-12 col-lg-4">
        <div class="card text-center mb-4">
            <div class="card-body py-4">
                @if($orangTua->identitasSiswa && $orangTua->identitasSiswa->foto_siswa)
                    <img src="{{ asset('storage/' . $orangTua->identitasSiswa->foto_siswa) }}" class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;">
                @else
                    <div style="width:100px;height:100px;border-radius:50%;background:#f1f5f9;border:1.5px solid #cbd5e1;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:36px;color:#0f4c81;font-weight:700;">
                        {{ strtoupper(substr($orangTua->identitasSiswa->nama_peserta_didik ?? 'S', 0, 1)) }}
                    </div>
                @endif
                <h5 class="fw-bold mb-1">{{ $orangTua->identitasSiswa->nama_peserta_didik ?? 'Siswa Tidak Ditemukan' }}</h5>
                <p class="text-muted mb-2">Anak Didik</p>
                @if($orangTua->identitasSiswa)
                    <span class="badge" style="background:#eef2ff;color:#4f46e5;font-size:12px;">{{ $orangTua->identitasSiswa->no_pendaftaran }}</span>
                    <hr>
                    <div class="text-start" style="font-size:13px;">
                        <div class="mb-2"><span class="text-muted">NISN:</span> <strong class="float-end">{{ $orangTua->identitasSiswa->nisn }}</strong></div>
                        <div class="mb-2"><span class="text-muted">Jenis Kelamin:</span> <strong class="float-end">{{ $orangTua->identitasSiswa->jenis_kelamin }}</strong></div>
                        <div class="mb-2"><span class="text-muted">Tahun Ajaran:</span> <strong class="float-end">{{ $orangTua->identitasSiswa->tahun_ajaran }}</strong></div>
                        <a href="{{ route('admin.siswa.show', $orangTua->identitasSiswa->id) }}" class="btn btn-sm btn-outline-primary w-100 mt-2">
                            <i class="fas fa-eye me-1"></i>Lihat Profil Siswa
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Detail Ortu/Wali -->
    <div class="col-12 col-lg-8">
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-male text-success me-2"></i>Data Ayah Kandung</div>
            <div class="card-body">
                <div class="row g-3" style="font-size:14px;">
                    <div class="col-md-6"><span class="text-muted d-block small">Nama Ayah</span><strong>{{ $orangTua->nama_ayah }}</strong></div>
                    <div class="col-md-6"><span class="text-muted d-block small">Status Ayah</span><strong>{{ $orangTua->status_ayah }}</strong></div>
                    <div class="col-md-6"><span class="text-muted d-block small">Tanggal Lahir Ayah</span><strong>{{ $orangTua->tgl_lahir_ayah?->format('d F Y') ?: '-' }}</strong></div>
                    <div class="col-md-6"><span class="text-muted d-block small">Telepon / HP</span><strong>{{ $orangTua->telepon_ayah ?: '-' }}</strong></div>
                    <div class="col-md-4"><span class="text-muted d-block small">Pendidikan Terakhir</span><strong>{{ $orangTua->pendidikan_terakhir_ayah ?: '-' }}</strong></div>
                    <div class="col-md-4"><span class="text-muted d-block small">Pekerjaan</span><strong>{{ $orangTua->pekerjaan_ayah ?: '-' }}</strong></div>
                    <div class="col-md-4"><span class="text-muted d-block small">Penghasilan / Bulan</span><strong>Rp {{ number_format($orangTua->penghasilan_ayah ?? 0, 0, ',', '.') }}</strong></div>
                    <div class="col-12"><span class="text-muted d-block small">Alamat Ayah</span><strong>{{ $orangTua->alamat_ayah ?: 'Sama dengan alamat siswa' }}</strong></div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-female text-danger me-2"></i>Data Ibu Kandung</div>
            <div class="card-body">
                <div class="row g-3" style="font-size:14px;">
                    <div class="col-md-6"><span class="text-muted d-block small">Nama Ibu</span><strong>{{ $orangTua->nama_ibu }}</strong></div>
                    <div class="col-md-6"><span class="text-muted d-block small">Status Ibu</span><strong>{{ $orangTua->status_ibu }}</strong></div>
                    <div class="col-md-6"><span class="text-muted d-block small">Tanggal Lahir Ibu</span><strong>{{ $orangTua->tgl_lahir_ibu?->format('d F Y') ?: '-' }}</strong></div>
                    <div class="col-md-6"><span class="text-muted d-block small">Telepon / HP</span><strong>{{ $orangTua->telepon_ibu ?: '-' }}</strong></div>
                    <div class="col-md-4"><span class="text-muted d-block small">Pendidikan Terakhir</span><strong>{{ $orangTua->pendidikan_terakhir_ibu ?: '-' }}</strong></div>
                    <div class="col-md-4"><span class="text-muted d-block small">Pekerjaan</span><strong>{{ $orangTua->pekerjaan_ibu ?: '-' }}</strong></div>
                    <div class="col-md-4"><span class="text-muted d-block small">Penghasilan / Bulan</span><strong>Rp {{ number_format($orangTua->penghasilan_ibu ?? 0, 0, ',', '.') }}</strong></div>
                    <div class="col-12"><span class="text-muted d-block small">Alamat Ibu</span><strong>{{ $orangTua->alamat_ibu ?: 'Sama dengan alamat siswa' }}</strong></div>
                </div>
            </div>
        </div>

        @if($orangTua->nama_wali)
        <div class="card">
            <div class="card-header bg-light"><i class="fas fa-user text-info me-2"></i>Data Wali</div>
            <div class="card-body">
                <div class="row g-3" style="font-size:14px;">
                    <div class="col-md-6"><span class="text-muted d-block small">Nama Wali</span><strong>{{ $orangTua->nama_wali }}</strong></div>
                    <div class="col-md-6"><span class="text-muted d-block small">Hubungan Wali</span><strong>{{ $orangTua->status_wali ?: '-' }}</strong></div>
                    <div class="col-md-6"><span class="text-muted d-block small">Tanggal Lahir Wali</span><strong>{{ $orangTua->tgl_lahir_wali?->format('d F Y') ?: '-' }}</strong></div>
                    <div class="col-md-6"><span class="text-muted d-block small">Telepon / HP</span><strong>{{ $orangTua->telepon_wali ?: '-' }}</strong></div>
                    <div class="col-md-4"><span class="text-muted d-block small">Pendidikan Terakhir</span><strong>{{ $orangTua->pendidikan_terakhir_wali ?: '-' }}</strong></div>
                    <div class="col-md-4"><span class="text-muted d-block small">Pekerjaan</span><strong>{{ $orangTua->pekerjaan_wali ?: '-' }}</strong></div>
                    <div class="col-md-4"><span class="text-muted d-block small">Penghasilan / Bulan</span><strong>Rp {{ number_format($orangTua->penghasilan_wali ?? 0, 0, ',', '.') }}</strong></div>
                    <div class="col-12"><span class="text-muted d-block small">Alamat Wali</span><strong>{{ $orangTua->alamat_wali ?: '-' }}</strong></div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
