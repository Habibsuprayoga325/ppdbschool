@extends('layouts.public')

@section('title', 'Dashboard Peserta - PPDB Online')

@push('styles')
<style>
    .dashboard-container {
        padding: 50px 0 80px;
        background: #f8fafc;
        min-height: calc(100vh - 150px);
    }
    .dashboard-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        margin-bottom: 30px;
    }
    .nav-pills-custom {
        display: flex;
        gap: 10px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 16px;
        margin-bottom: 30px;
        list-style: none;
        padding-left: 0;
    }
    .nav-pills-custom .nav-link {
        color: #64748b;
        font-weight: 600;
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 10px;
        border: 1px solid transparent;
        transition: all 0.2s;
        text-decoration: none;
        background: transparent;
        cursor: pointer;
    }
    .nav-pills-custom .nav-link:hover {
        color: var(--primary);
        background: #f1f5f9;
    }
    .nav-pills-custom .nav-link.active {
        color: white;
        background: var(--primary);
    }
    .form-section-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        border-bottom: 2px solid #eff6ff;
        padding-bottom: 6px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-section-title i {
        color: var(--primary);
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
    }
    .status-verified {
        background: #d1fae5;
        color: #065f46;
    }
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    .status-unpaid {
        background: #fee2e2;
        color: #991b1b;
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <div class="container">
        <!-- Welcoming Alert / Message -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between p-4 bg-white border rounded-4 shadow-sm">
                    <div>
                        <small class="text-muted d-block mb-1">Selamat datang,</small>
                        <h3 class="fw-bold text-dark m-0">{{ $siswa->nama_peserta_didik }}</h3>
                    </div>
                    <div class="text-end">
                        <small class="text-muted d-block">Nomor Pendaftaran:</small>
                        <span class="badge bg-primary px-3 py-2 fs-6 mt-1" style="font-weight: 700;">{{ $siswa->no_pendaftaran }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(request()->get('payment_success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="fas fa-check-circle me-2"></i> Pembayaran berhasil! Transaksi Anda sedang diproses secara otomatis oleh sistem.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(request()->get('payment_pending'))
            <div class="alert alert-warning alert-dismissible fade show mb-4">
                <i class="fas fa-info-circle me-2"></i> Pembayaran tertunda/menunggu pembayaran. Silakan selesaikan pembayaran Anda sesuai instruksi di Midtrans.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-3">
                <!-- Navigation Menu Left -->
                <div class="dashboard-card p-3">
                    <ul class="nav flex-column nav-pills-custom" id="dashboardTabs" role="tablist" style="border:none; margin:0; gap:6px;">
                        <li class="nav-item">
                            <button class="nav-link w-100 text-start active" id="summary-tab" data-bs-toggle="pill" data-bs-target="#summary" type="button" role="tab">
                                <i class="fas fa-home me-2"></i> Ringkasan
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link w-100 text-start" id="pembayaran-tab" data-bs-toggle="pill" data-bs-target="#pembayaran" type="button" role="tab">
                                <i class="fas fa-money-bill-wave me-2"></i> Administrasi
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link w-100 text-start" id="siswa-tab" data-bs-toggle="pill" data-bs-target="#siswa" type="button" role="tab">
                                <i class="fas fa-user-edit me-2"></i> Edit Data Siswa
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link w-100 text-start" id="ortu-tab" data-bs-toggle="pill" data-bs-target="#ortu" type="button" role="tab">
                                <i class="fas fa-users-cog me-2"></i> Edit Data Orang Tua
                            </button>
                        </li>
                    </ul>
                    <hr>
                    <div class="px-2">
                        <form action="{{ route('peserta.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 py-2 border-1 text-center" style="border-radius:10px; font-size:14px; font-weight:600;">
                                <i class="fas fa-sign-out-alt me-1"></i> Keluar Akun
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <!-- Tab Content Right -->
                <div class="tab-content" id="dashboardTabsContent">
                    
                    <!-- TAB 1: Summary -->
                    <div class="tab-pane fade show active" id="summary" role="tabpanel">
                        <div class="dashboard-card">
                            <h4 class="fw-bold mb-4">Ringkasan Pendaftaran</h4>
                            
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3 bg-light">
                                        <small class="text-muted d-block">Status Pendaftaran</small>
                                        @if($siswa->status_ortu)
                                            <span class="status-badge status-verified mt-2">
                                                <i class="fas fa-check-circle"></i> Berkas Lengkap
                                            </span>
                                        @else
                                            <span class="status-badge status-pending mt-2">
                                                <i class="fas fa-exclamation-circle"></i> Belum Lengkap (Isi Data Orang Tua)
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3 bg-light">
                                        <small class="text-muted d-block">Status Administrasi / Verifikasi</small>
                                        @if($siswa->administrasi && $siswa->administrasi->status === 'Lunas')
                                            <span class="status-badge status-verified mt-2">
                                                <i class="fas fa-shield-alt"></i> Terverifikasi (Lunas)
                                            </span>
                                        @else
                                            <span class="status-badge status-unpaid mt-2">
                                                <i class="fas fa-hourglass-half"></i> Pending Verifikasi
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="fw-bold">Kartu Bukti Pendaftaran</h5>
                                    <p class="text-muted small m-0">Gunakan kartu ini sebagai bukti resmi pendaftaran online untuk diserahkan ke panitia saat melakukan verifikasi fisik di sekolah.</p>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <a href="{{ route('peserta.cetak') }}" target="_blank" class="btn btn-primary btn-navbar py-2.5 px-4 w-100 text-center">
                                        <i class="fas fa-print me-2"></i> Cetak Kartu
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Details -->
                        <div class="dashboard-card">
                            <h5 class="fw-bold mb-3">Informasi Pokok Pendaftar</h5>
                            <div class="row g-3" style="font-size: 14px;">
                                <div class="col-md-6">
                                    <span class="text-muted d-block">Nama Lengkap</span>
                                    <strong>{{ $siswa->nama_peserta_didik }}</strong>
                                </div>
                                <div class="col-md-6">
                                    <span class="text-muted d-block">NISN</span>
                                    <strong>{{ $siswa->nisn }}</strong>
                                </div>
                                <div class="col-md-6">
                                    <span class="text-muted d-block">Tempat & Tanggal Lahir</span>
                                    <strong>{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir?->format('d F Y') }}</strong>
                                </div>
                                <div class="col-md-6">
                                    <span class="text-muted d-block">Jenis Kelamin</span>
                                    <strong>{{ $siswa->jenis_kelamin }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB: Administrasi -->
                    <div class="tab-pane fade" id="pembayaran" role="tabpanel">
                        <div class="dashboard-card">
                            <div class="mb-4">
                                <h4 class="fw-bold text-dark mb-1">Rincian Pembayaran Administrasi PPDB</h4>
                                <p class="text-muted small">Pilih beberapa atau seluruh item administrasi di bawah untuk melanjutkan ke proses pembayaran.</p>
                            </div>

                            @if($errors->has('items'))
                                <div class="alert alert-danger mb-4">
                                    <i class="fas fa-exclamation-circle me-2"></i> {{ $errors->first('items') }}
                                </div>
                            @endif

                            <div class="table-responsive border rounded-3 mb-4">
                                <table class="table align-middle table-hover">
                                    <thead>
                                        <tr class="table-light">
                                            <th style="width: 50px;" class="text-center">Pilih</th>
                                            <th style="width: 60px;" class="text-center">No</th>
                                            <th>Item Administrasi</th>
                                            <th class="text-end">Nominal</th>
                                            <th class="text-center" style="width: 180px;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($items as $index => $item)
                                            @php
                                                $payment = $siswa->pembayaranPeserta->where('administrasi_item_id', $item->id)->where('status', 'lunas')->first()
                                                    ?? $siswa->pembayaranPeserta->where('administrasi_item_id', $item->id)->where('status', 'menunggu_konfirmasi')->first()
                                                    ?? $siswa->pembayaranPeserta->where('administrasi_item_id', $item->id)->where('status', 'ditolak')->first();
                                                
                                                $status = $payment ? $payment->status : 'belum_dibayar';
                                                $canSelect = in_array($status, ['belum_dibayar', 'ditolak']);
                                            @endphp
                                            <tr>
                                                <td class="text-center">
                                                    @if($canSelect)
                                                        <input type="checkbox" class="form-check-input item-checkbox" 
                                                               data-id="{{ $item->id }}" 
                                                               data-nama="{{ $item->nama }}" 
                                                               data-nominal="{{ $item->nominal }}" 
                                                               value="{{ $item->id }}"
                                                               style="width: 20px; height: 20px; cursor: pointer;">
                                                    @else
                                                        <input type="checkbox" class="form-check-input" disabled style="width: 20px; height: 20px;">
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>
                                                    <span class="fw-semibold text-dark">{{ $item->nama }}</span>
                                                </td>
                                                <td class="text-end fw-bold text-dark">
                                                    {{ $item->nominal_formatted }}
                                                </td>
                                                <td class="text-center">
                                                    @if($status === 'lunas')
                                                        <span class="status-badge status-verified">
                                                            <i class="fas fa-check-circle me-1"></i> Lunas
                                                        </span>
                                                    @elseif($status === 'menunggu_konfirmasi')
                                                        <span class="status-badge status-pending">
                                                            <i class="fas fa-clock me-1"></i> Pending Verifikasi
                                                        </span>
                                                    @elseif($status === 'ditolak')
                                                        <span class="status-badge status-unpaid" title="Ditolak. Catatan: {{ $payment->catatan ?? '-' }}">
                                                            <i class="fas fa-times-circle me-1"></i> Ditolak (Bayar Ulang)
                                                        </span>
                                                    @else
                                                        <span class="status-badge status-unpaid">
                                                            <i class="fas fa-times-circle me-1"></i> Belum Dibayar
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="p-4 border rounded-4 d-flex flex-column flex-md-row justify-content-between align-items-center bg-light">
                                <div class="mb-3 mb-md-0 text-center text-md-start">
                                    <small class="text-muted d-block uppercase tracking-wider">TOTAL TAGIHAN TERPILIH</small>
                                    <h2 class="m-0 text-primary fw-bold" id="total-selected-payment">Rp 0</h2>
                                </div>
                                <button class="btn btn-primary py-3 px-5 fw-bold w-100 w-md-auto" id="btn-pay-now" disabled style="border-radius: 12px; font-size: 15px;">
                                    <i class="fas fa-money-bill-wave me-2"></i> Bayar Sekarang
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: Edit Siswa -->
                    <div class="tab-pane fade" id="siswa" role="tabpanel">
                        <div class="dashboard-card">
                            <div class="mb-4">
                                <h4 class="fw-bold text-dark mb-1">Edit Data Diri Siswa</h4>
                                <p class="text-muted small">Perbarui data identitas pokok calon peserta didik di bawah ini.</p>
                            </div>

                            <form action="{{ route('peserta.siswa.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="form-section-title">
                                    <i class="fas fa-id-card"></i> Identitas Pokok
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">NISN <span class="text-danger">*</span></label>
                                        <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                                        <input type="text" name="nik" class="form-control" value="{{ old('nik', $siswa->nik) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Upload Gambar Kartu Keluarga (KK)</label>
                                        <input type="file" name="no_kk" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                        <div class="form-text small text-muted">Format: JPG, PNG, PDF (Maks. 2MB)</div>
                                        @if($siswa->no_kk)
                                            <div class="mt-2">
                                                <a href="{{ asset('storage/' . $siswa->no_kk) }}" target="_blank" class="btn btn-sm btn-outline-primary py-1 px-3">
                                                    <i class="fas fa-file-download me-1"></i> Lihat KK Saat Ini
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Upload Gambar Akta Kelahiran</label>
                                        <input type="file" name="foto_akta" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                        <div class="form-text small text-muted">Format: JPG, PNG, PDF (Maks. 2MB)</div>
                                        @if($siswa->foto_akta)
                                            <div class="mt-2">
                                                <a href="{{ asset('storage/' . $siswa->foto_akta) }}" target="_blank" class="btn btn-sm btn-outline-primary py-1 px-3">
                                                    <i class="fas fa-file-download me-1"></i> Lihat Akta Saat Ini
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Panggilan <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_panggilan" class="form-control" value="{{ old('nama_panggilan', $siswa->nama_panggilan) }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Nama Lengkap Peserta Didik <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_peserta_didik" class="form-control" value="{{ old('nama_peserta_didik', $siswa->nama_peserta_didik) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir?->format('Y-m-d')) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select name="jenis_kelamin" class="form-select" required>
                                            <option value="Laki-Laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Agama <span class="text-danger">*</span></label>
                                        <select name="agama" class="form-select" required>
                                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                                                <option value="{{ $agama }}" {{ old('agama', $siswa->agama) === $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Gol. Darah</label>
                                        <select name="gol_darah" class="form-select">
                                            <option value="">-- Pilih --</option>
                                            @foreach(['A','B','AB','O'] as $gb)
                                                <option value="{{ $gb }}" {{ old('gol_darah', $siswa->gol_darah) === $gb ? 'selected' : '' }}>{{ $gb }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Tinggi Badan (cm)</label>
                                        <input type="number" name="tinggi_badan" class="form-control" value="{{ old('tinggi_badan', $siswa->tinggi_badan) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Berat Badan (kg)</label>
                                        <input type="number" name="berat_badan" class="form-control" value="{{ old('berat_badan', $siswa->berat_badan) }}">
                                    </div>
                                </div>

                                <div class="form-section-title">
                                    <i class="fas fa-home"></i> Tempat Tinggal & Hubungan
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Suku Bangsa</label>
                                        <input type="text" name="suku" class="form-control" value="{{ old('suku', $siswa->suku) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Bahasa Sehari-hari</label>
                                        <input type="text" name="bahasa" class="form-control" value="{{ old('bahasa', $siswa->bahasa) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Kewarganegaraan <span class="text-danger">*</span></label>
                                        <input type="text" name="kewarganegaraan" class="form-control" value="{{ old('kewarganegaraan', $siswa->kewarganegaraan) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Status Anak</label>
                                        <select name="status_anak" class="form-select">
                                            <option value="Kandung" {{ old('status_anak', $siswa->status_anak) === 'Kandung' ? 'selected' : '' }}>Kandung</option>
                                            <option value="Tiri" {{ old('status_anak', $siswa->status_anak) === 'Tiri' ? 'selected' : '' }}>Tiri</option>
                                            <option value="Angkat" {{ old('status_anak', $siswa->status_anak) === 'Angkat' ? 'selected' : '' }}>Angkat</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Anak Ke- <span class="text-danger">*</span></label>
                                        <input type="number" name="anak_ke" class="form-control" value="{{ old('anak_ke', $siswa->anak_ke) }}" min="1" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Jumlah Saudara <span class="text-danger">*</span></label>
                                        <input type="number" name="jml_saudara" class="form-control" value="{{ old('jml_saudara', $siswa->jml_saudara) }}" min="0" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jenis Tempat Tinggal</label>
                                        <select name="jenis_tinggal" class="form-select">
                                            @foreach(['Orang Tua','Wali','Kos/Mondok','Asrama','Panti','Kontrak'] as $jt)
                                                <option value="{{ $jt }}" {{ old('jenis_tinggal', $siswa->jenis_tinggal) === $jt ? 'selected' : '' }}>{{ $jt }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jarak ke Sekolah (meter)</label>
                                        <input type="number" name="jarak_ke_sekolah" class="form-control" value="{{ old('jarak_ke_sekolah', $siswa->jarak_ke_sekolah) }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Alamat Lengkap Tinggal <span class="text-danger">*</span></label>
                                        <textarea name="alamat_tinggal" class="form-control" rows="2" required>{{ old('alamat_tinggal', $siswa->alamat_tinggal) }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                        <input type="text" name="provinsi_tinggal" class="form-control" value="{{ old('provinsi_tinggal', $siswa->provinsi_tinggal) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kabupaten / Kota <span class="text-danger">*</span></label>
                                        <input type="text" name="kab_kota_tinggal" class="form-control" value="{{ old('kab_kota_tinggal', $siswa->kab_kota_tinggal) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                        <input type="text" name="kec_tinggal" class="form-control" value="{{ old('kec_tinggal', $siswa->kec_tinggal) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Kelurahan / Desa <span class="text-danger">*</span></label>
                                        <input type="text" name="kelurahan_tinggal" class="form-control" value="{{ old('kelurahan_tinggal', $siswa->kelurahan_tinggal) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Kode POS</label>
                                        <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos', $siswa->kode_pos) }}">
                                    </div>
                                </div>

                                <div class="form-section-title">
                                    <i class="fas fa-heartbeat"></i> Riwayat Kesehatan
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-12">
                                        <label class="form-label">Riwayat Penyakit (Alergi, Asma, dll)</label>
                                        <textarea name="riwayat_penyakit" class="form-control" rows="2">{{ old('riwayat_penyakit', $siswa->riwayat_penyakit) }}</textarea>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary btn-navbar">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- TAB 3: Edit Ortu -->
                    <div class="tab-pane fade" id="ortu" role="tabpanel">
                        <div class="dashboard-card">
                            <div class="mb-4">
                                <h4 class="fw-bold text-dark mb-1">Edit Data Orang Tua / Wali</h4>
                                <p class="text-muted small">Kelola identitas ayah, ibu kandung, atau wali dari calon siswa.</p>
                            </div>

                            @if(!$siswa->status_ortu)
                                <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center gap-3 mb-4" style="border-radius:12px;">
                                    <i class="fas fa-exclamation-circle fs-4"></i>
                                    <div>
                                        <strong>Lengkapi Data!</strong> Anda belum mengisi identitas orang tua/wali. Silakan isi form di bawah ini agar pendaftaran dapat divalidasi.
                                    </div>
                                </div>
                            @endif

                            <form action="{{ route('peserta.orangtua.update') }}" method="POST">
                                @csrf
                                
                                <!-- 1. Data Ayah -->
                                <div class="form-section-title">
                                    <i class="fas fa-male"></i> Data Ayah Kandung
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap Ayah <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_ayah" class="form-control" value="{{ old('nama_ayah', $siswa->orangTuaWali->nama_ayah ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Status Ayah <span class="text-danger">*</span></label>
                                        <select name="status_ayah" class="form-select" required>
                                            @foreach(['Kandung','Tiri','Angkat','Meninggal Dunia'] as $st)
                                                <option value="{{ $st }}" {{ old('status_ayah', $siswa->orangTuaWali->status_ayah ?? '') === $st ? 'selected' : '' }}>{{ $st }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Lahir Ayah</label>
                                        <input type="date" name="tgl_lahir_ayah" class="form-control" value="{{ old('tgl_lahir_ayah', isset($siswa->orangTuaWali->tgl_lahir_ayah) ? $siswa->orangTuaWali->tgl_lahir_ayah?->format('Y-m-d') : '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">No. Telepon / HP Ayah</label>
                                        <input type="text" name="telepon_ayah" class="form-control" value="{{ old('telepon_ayah', $siswa->orangTuaWali->telepon_ayah ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Pendidikan Terakhir Ayah</label>
                                        <select name="pendidikan_terakhir_ayah" class="form-select">
                                            <option value="">-- Pilih --</option>
                                            @foreach(['SD','SMP','SMA/SMK','D1/D2/D3','S1','S2/S3','Tidak Sekolah'] as $pd)
                                                <option value="{{ $pd }}" {{ old('pendidikan_terakhir_ayah', $siswa->orangTuaWali->pendidikan_terakhir_ayah ?? '') === $pd ? 'selected' : '' }}>{{ $pd }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Pekerjaan Ayah</label>
                                        <input type="text" name="pekerjaan_ayah" class="form-control" value="{{ old('pekerjaan_ayah', $siswa->orangTuaWali->pekerjaan_ayah ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Penghasilan Ayah (Rp / Bulan)</label>
                                        <input type="number" name="penghasilan_ayah" class="form-control" value="{{ old('penghasilan_ayah', $siswa->orangTuaWali->penghasilan_ayah ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Alamat Ayah</label>
                                        <textarea name="alamat_ayah" class="form-control" rows="2">{{ old('alamat_ayah', $siswa->orangTuaWali->alamat_ayah ?? '') }}</textarea>
                                    </div>
                                </div>

                                <!-- 2. Data Ibu -->
                                <div class="form-section-title">
                                    <i class="fas fa-female"></i> Data Ibu Kandung
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap Ibu <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu', $siswa->orangTuaWali->nama_ibu ?? '') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Status Ibu <span class="text-danger">*</span></label>
                                        <select name="status_ibu" class="form-select" required>
                                            @foreach(['Kandung','Tiri','Angkat','Meninggal Dunia'] as $st)
                                                <option value="{{ $st }}" {{ old('status_ibu', $siswa->orangTuaWali->status_ibu ?? '') === $st ? 'selected' : '' }}>{{ $st }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Lahir Ibu</label>
                                        <input type="date" name="tgl_lahir_ibu" class="form-control" value="{{ old('tgl_lahir_ibu', isset($siswa->orangTuaWali->tgl_lahir_ibu) ? $siswa->orangTuaWali->tgl_lahir_ibu?->format('Y-m-d') : '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">No. Telepon / HP Ibu</label>
                                        <input type="text" name="telepon_ibu" class="form-control" value="{{ old('telepon_ibu', $siswa->orangTuaWali->telepon_ibu ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Pendidikan Terakhir Ibu</label>
                                        <select name="pendidikan_terakhir_ibu" class="form-select">
                                            <option value="">-- Pilih --</option>
                                            @foreach(['SD','SMP','SMA/SMK','D1/D2/D3','S1','S2/S3','Tidak Sekolah'] as $pd)
                                                <option value="{{ $pd }}" {{ old('pendidikan_terakhir_ibu', $siswa->orangTuaWali->pendidikan_terakhir_ibu ?? '') === $pd ? 'selected' : '' }}>{{ $pd }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Pekerjaan Ibu</label>
                                        <input type="text" name="pekerjaan_ibu" class="form-control" value="{{ old('pekerjaan_ibu', $siswa->orangTuaWali->pekerjaan_ibu ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Penghasilan Ibu (Rp / Bulan)</label>
                                        <input type="number" name="penghasilan_ibu" class="form-control" value="{{ old('penghasilan_ibu', $siswa->orangTuaWali->penghasilan_ibu ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Alamat Ibu</label>
                                        <textarea name="alamat_ibu" class="form-control" rows="2">{{ old('alamat_ibu', $siswa->orangTuaWali->alamat_ibu ?? '') }}</textarea>
                                    </div>
                                </div>

                                <!-- 3. Data Wali -->
                                <div class="form-section-title">
                                    <i class="fas fa-user-friends"></i> Data Wali (Opsional)
                                </div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Wali</label>
                                        <input type="text" name="nama_wali" class="form-control" value="{{ old('nama_wali', $siswa->orangTuaWali->nama_wali ?? '') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Hubungan Wali</label>
                                        <input type="text" name="status_wali" class="form-control" value="{{ old('status_wali', $siswa->orangTuaWali->status_wali ?? '') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Telepon Wali</label>
                                        <input type="text" name="telepon_wali" class="form-control" value="{{ old('telepon_wali', $siswa->orangTuaWali->telepon_wali ?? '') }}">
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary btn-navbar">
                                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                   </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Simulator Midtrans -->
<div class="modal fade" id="midtransSimulatorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="midtransSimulatorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <!-- Simulation Banner -->
            <div class="bg-warning text-dark text-center py-2 px-3 fw-bold small d-flex align-items-center justify-content-center gap-2">
                <i class="fas fa-flask"></i>
                <span>MODE SIMULASI PEMBAYARAN</span>
            </div>
            
            <div class="modal-header border-0 bg-light px-4 py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <img src="https://midtrans.com/assets/img/midtrans-logo-white-background.png" alt="Midtrans Logo" style="height: 18px; filter: grayscale(100%);">
                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle" style="font-size: 11px;">Sandbox</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body px-4 py-4">
                <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis small mb-4" style="border-radius: 12px; font-size: 13px;">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Perhatian:</strong> Gerbang pembayaran ini berada dalam <strong>Mode Simulasi</strong> sementara menunggu aktivasi akun Midtrans resmi dari panitia. Tidak ada uang sungguhan yang ditransaksikan.
                </div>
                
                <div class="border rounded-4 p-3 mb-4 bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Kode Transaksi:</span>
                        <strong class="text-dark" id="sim-payment-code">-</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Penerima:</span>
                        <strong class="text-dark">PPDB SDN Mekar Mukti 06</strong>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-semibold">Total Tagihan:</span>
                        <h4 class="m-0 text-primary fw-bold" id="sim-total-amount">Rp 0</h4>
                    </div>
                </div>

                <div class="text-center mb-2">
                    <p class="text-muted small mb-2">Pindai QRIS Simulasi di bawah untuk membayar:</p>
                    <div class="d-inline-block p-3 bg-white border rounded-4 shadow-sm mb-2">
                        <svg width="180" height="180" viewBox="0 0 100 100" class="text-dark">
                            <rect x="0" y="0" width="100" height="100" fill="white"/>
                            <!-- QR Code-like patterns in blue and dark gray -->
                            <rect x="5" y="5" width="25" height="25" fill="#1e3a8a"/>
                            <rect x="10" y="10" width="15" height="15" fill="white"/>
                            <rect x="13" y="13" width="9" height="9" fill="#1e3a8a"/>
                            
                            <rect x="70" y="5" width="25" height="25" fill="#1e3a8a"/>
                            <rect x="75" y="10" width="15" height="15" fill="white"/>
                            <rect x="78" y="13" width="9" height="9" fill="#1e3a8a"/>
                            
                            <rect x="5" y="70" width="25" height="25" fill="#1e3a8a"/>
                            <rect x="10" y="75" width="15" height="15" fill="white"/>
                            <rect x="13" y="78" width="9" height="9" fill="#1e3a8a"/>

                            <rect x="40" y="40" width="20" height="20" fill="#1e3a8a"/>
                            <rect x="45" y="45" width="10" height="10" fill="white"/>
                            
                            <rect x="40" y="10" width="5" height="5" fill="#1e293b"/>
                            <rect x="50" y="15" width="5" height="10" fill="#1e293b"/>
                            <rect x="35" y="25" width="10" height="5" fill="#1e293b"/>
                            <rect x="15" y="40" width="5" height="15" fill="#1e293b"/>
                            <rect x="25" y="50" width="10" height="5" fill="#1e293b"/>
                            <rect x="50" y="70" width="5" height="10" fill="#1e293b"/>
                            <rect x="70" y="45" width="15" height="5" fill="#1e293b"/>
                            <rect x="80" y="55" width="5" height="15" fill="#1e293b"/>
                            <rect x="75" y="75" width="10" height="10" fill="#1e293b"/>
                        </svg>
                    </div>
                    <div class="text-muted" style="font-size: 11px;">GPN / QRIS STANDAR NASIONAL</div>
                </div>
            </div>
            
            <div class="modal-footer border-0 bg-light px-4 py-3 d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary py-2.5 px-4 flex-grow-1" data-bs-dismiss="modal" style="border-radius: 12px; font-weight: 600; font-size: 14px;">Batal</button>
                <button type="button" class="btn btn-success py-2.5 px-4 flex-grow-1" id="btn-simulate-success" style="border-radius: 12px; font-weight: 600; font-size: 14px;">
                    <i class="fas fa-check-circle me-1"></i> Simulasikan Bayar Sukses
                </button>
            </div>
        </div>
    </div>
</div>

@php
    $snapUrl = config('services.midtrans.is_production') 
        ? 'https://app.midtrans.com/snap/snap.js' 
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
@endphp

@endsection

@push('scripts')
<script type="text/javascript" src="{{ $snapUrl }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const totalSelectedPayment = document.getElementById('total-selected-payment');
    const btnPayNow = document.getElementById('btn-pay-now');

    // Checkbox and sum logic
    function updateSelectedPayment() {
        let total = 0;
        let selectedCount = 0;
        
        checkboxes.forEach(function(cb) {
            if (cb.checked) {
                total += parseFloat(cb.getAttribute('data-nominal'));
                selectedCount++;
            }
        });
        
        totalSelectedPayment.textContent = 'Rp ' + total.toLocaleString('id-ID');
        btnPayNow.disabled = (selectedCount === 0);
    }
    
    checkboxes.forEach(function(cb) {
        cb.addEventListener('change', updateSelectedPayment);
    });
    
    // Open payment modal
    btnPayNow.addEventListener('click', function() {
        btnPayNow.disabled = true;
        const originalContent = btnPayNow.innerHTML;
        btnPayNow.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
        
        let selectedItems = [];
        checkboxes.forEach(function(cb) {
            if (cb.checked) {
                selectedItems.push(cb.value);
            }
        });
        
        fetch('{{ route("peserta.pembayaran.initiate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                items: selectedItems
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            btnPayNow.disabled = false;
            btnPayNow.innerHTML = originalContent;
            
            if (data.token.startsWith('DUMMY-') || data.is_simulation) {
                // Set payment code and amount in simulation modal
                document.getElementById('sim-payment-code').textContent = data.payment_code;
                
                let total = 0;
                checkboxes.forEach(function(cb) {
                    if (cb.checked) {
                        total += parseFloat(cb.getAttribute('data-nominal'));
                    }
                });
                document.getElementById('sim-total-amount').textContent = 'Rp ' + total.toLocaleString('id-ID');
                
                // Store payment_code on simulator button
                const btnSimulateSuccess = document.getElementById('btn-simulate-success');
                btnSimulateSuccess.setAttribute('data-payment-code', data.payment_code);
                
                // Open bootstrap modal
                const simulatorModal = new bootstrap.Modal(document.getElementById('midtransSimulatorModal'));
                simulatorModal.show();
            } else {
                window.snap.pay(data.token, {
                    onSuccess: function(result) {
                        window.location.href = "{{ route('peserta.dashboard') }}?payment_success=1";
                    },
                    onPending: function(result) {
                        window.location.href = "{{ route('peserta.dashboard') }}?payment_pending=1";
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal. Silakan coba lagi.");
                    },
                    onClose: function() {
                        window.location.reload();
                    }
                });
            }
        })
        .catch(error => {
            btnPayNow.disabled = false;
            btnPayNow.innerHTML = originalContent;
            alert(error.error || "Gagal menginisialisasi pembayaran. Silakan coba lagi.");
        });
    });

    // Handle simulation success click
    const btnSimulateSuccess = document.getElementById('btn-simulate-success');
    btnSimulateSuccess.addEventListener('click', function() {
        btnSimulateSuccess.disabled = true;
        const originalContent = btnSimulateSuccess.innerHTML;
        btnSimulateSuccess.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
        
        const paymentCode = btnSimulateSuccess.getAttribute('data-payment-code');
        
        fetch('{{ route("peserta.pembayaran.simulate-success") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                payment_code: paymentCode
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            window.location.href = "{{ route('peserta.dashboard') }}?payment_success=1";
        })
        .catch(error => {
            btnSimulateSuccess.disabled = false;
            btnSimulateSuccess.innerHTML = originalContent;
            alert(error.error || "Gagal memproses simulasi pembayaran.");
        });
    });
});
</script>
@endpush
