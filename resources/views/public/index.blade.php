@extends('layouts.public')

@section('title', 'PPDB Online | Sekolah Amanah Bangsa Cikarang')

@push('styles')
<style>
    .hero-section {
        background-color: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 80px 0;
        position: relative;
    }
    .hero-badge {
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: var(--primary);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 20px;
    }
    .hero-title {
        font-size: 40px;
        font-weight: 800;
        line-height: 1.25;
        margin-bottom: 20px;
        color: #0f172a;
    }
    .hero-desc {
        font-size: 16px;
        color: #475569;
        line-height: 1.7;
        margin-bottom: 30px;
    }
    .hero-btns {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    .btn-hero-primary {
        background-color: var(--primary);
        color: white;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .btn-hero-primary:hover {
        background-color: var(--primary-dark);
        color: white;
    }
    .btn-hero-secondary {
        background-color: #ffffff;
        color: #475569;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 10px;
        text-decoration: none;
        border: 1px solid #cbd5e1;
        transition: all 0.2s;
    }
    .btn-hero-secondary:hover {
        background-color: #f8fafc;
        color: #0f172a;
    }
    .hero-logo-box {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .hero-logo-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        max-width: 380px;
        width: 100%;
        text-align: center;
    }
    .hero-logo-card img {
        height: auto;
        max-height: 120px;
        max-width: 100%;
        object-fit: contain;
        margin-bottom: 24px;
    }
    
    /* STEPS SECTION */
    .steps-section {
        padding: 70px 0;
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    .section-title {
        font-size: 28px;
        font-weight: 800;
        text-align: center;
        margin-bottom: 48px;
        color: #0f172a;
    }
    .step-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 30px;
        height: 100%;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: all 0.2s;
    }
    .step-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        border-color: #cbd5e1;
    }
    .step-num {
        width: 42px; height: 42px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 20px;
    }
    .step-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #0f172a;
    }
    .step-desc {
        font-size: 14px;
        color: #475569;
        line-height: 1.6;
        margin: 0;
    }
    
    /* GALLERY SECTION */
    .gallery-section {
        padding: 70px 0;
        background-color: #ffffff;
        border-bottom: 1px solid #e2e8f0;
    }
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }
    .gallery-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: all 0.2s;
    }
    .gallery-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    }
    .gallery-img-wrapper {
        height: 200px;
        overflow: hidden;
        background-color: #f1f5f9;
        position: relative;
    }
    .gallery-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .gallery-card:hover .gallery-img-wrapper img {
        transform: scale(1.05);
    }
    .gallery-body {
        padding: 20px;
    }
    .gallery-category {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--primary);
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: inline-block;
    }
    .gallery-title {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 6px;
    }
    .gallery-desc {
        font-size: 13px;
        color: #64748b;
        margin: 0;
        line-height: 1.5;
    }

    /* INFO SECTION */
    .info-section {
        padding: 70px 0;
        background: #f8fafc;
    }
    .info-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 30px;
        height: 100%;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }
    .info-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 12px;
    }
    .info-header i {
        font-size: 18px;
        color: var(--primary);
    }
    .info-header h4 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        color: #0f172a;
    }
    .info-list {
        padding-left: 20px;
        margin: 0;
    }
    .info-list li {
        font-size: 13px;
        color: #475569;
        margin-bottom: 10px;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="hero-badge"><i class="fas fa-bullhorn me-1.5"></i>Tahun Ajaran 2026/2027</span>
                <h1 class="hero-title">Penerimaan Peserta Didik Baru Online</h1>
                <p class="hero-desc">Pendaftaran siswa baru Sekolah Amanah Bangsa Cikarang kini dapat diakses dengan mudah dan transparan. Daftarkan putra-putri Anda secara online melalui platform resmi kami.</p>
                <div class="hero-btns">
                    <a href="{{ route('public.daftar-siswa') }}" class="btn-hero-primary">
                        Daftar Sekarang <i class="fas fa-arrow-right ms-1.5"></i>
                    </a>
                    <a href="#alur" class="btn-hero-secondary">
                        Alur Pendaftaran
                    </a>
                </div>
            </div>
            <div class="col-lg-5 hero-logo-box d-none d-lg-flex">
                <div class="hero-logo-card">
                    <img src="{{ asset('img/tut.png') }}?v=1.1" alt="Logo Tut Wuri">
                    <h3 class="fw-bold text-dark mb-1" style="font-size: 18px;">Amanah Bangsa</h3>
                    <p class="text-muted small mb-0">Kab. Bekasi, Jawa Barat</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Steps Section -->
<section class="steps-section" id="alur">
    <div class="container">
        <h2 class="section-title">Alur Pendaftaran</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-num">1</div>
                    <h3 class="step-title">Isi Data Siswa</h3>
                    <p class="step-desc">Lengkapi data pribadi calon siswa, NISN, NIK, riwayat kesehatan, dan alamat rumah.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-num">2</div>
                    <h3 class="step-title">Isi Data Orang Tua</h3>
                    <p class="step-desc">Isi data identitas ayah, ibu, atau wali beserta kontak telepon dan pekerjaan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-num">3</div>
                    <h3 class="step-title">Verifikasi Berkas</h3>
                    <p class="step-desc">Cetak nomor pendaftaran Anda dan bawa berkas persyaratan asli ke sekolah untuk diverifikasi oleh panitia.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="gallery-section">
    <div class="container">
        <h2 class="section-title">Dokumentasi Kegiatan Sekolah</h2>
        <div class="gallery-grid">
            
            <!-- Gallery Item 1 -->
            <div class="gallery-card">
                <div class="gallery-img-wrapper">
                    <img src="{{ asset('img/isra_miraj.jpg') }}" alt="Isra Miraj">
                </div>
                <div class="gallery-body">
                    <span class="gallery-category">Karakter</span>
                    <h4 class="gallery-title">Isra Miraj</h4>
                    <p class="gallery-desc">Peringatan hari besar keagamaan Isra Miraj oleh seluruh siswa dan guru.</p>
                </div>
            </div>

            <!-- Gallery Item 2 -->
            <div class="gallery-card">
                <div class="gallery-img-wrapper">
                    <img src="{{ asset('img/market_day.jpg') }}" alt="Market Day Anak">
                </div>
                <div class="gallery-body">
                    <span class="gallery-category">Kreativitas</span>
                    <h4 class="gallery-title">Market Day Anak</h4>
                    <p class="gallery-desc">Kegiatan kewirausahaan belajar berniaga sejak dini.</p>
                </div>
            </div>

            <!-- Gallery Item 3 -->
            <div class="gallery-card">
                <div class="gallery-img-wrapper">
                    <img src="{{ asset('img/berenang.jpg') }}" alt="Berenang">
                </div>
                <div class="gallery-body">
                    <span class="gallery-category">Kesehatan</span>
                    <h4 class="gallery-title">Berenang</h4>
                    <p class="gallery-desc">Kegiatan olahraga air rutin guna menjaga kesehatan dan kebugaran.</p>
                </div>
            </div>

            <!-- Gallery Item 4 -->
            <div class="gallery-card">
                <div class="gallery-img-wrapper">
                    <img src="{{ asset('img/ramadhan_berkah.jpg') }}" alt="Ramadhan Berkah">
                </div>
                <div class="gallery-body">
                    <span class="gallery-category">Sosial</span>
                    <h4 class="gallery-title">Ramadhan Berkah</h4>
                    <p class="gallery-desc">Penyaluran bantuan sosial dan takjil kepada masyarakat sekitar.</p>
                </div>
            </div>

            <!-- Gallery Item 5 -->
            <div class="gallery-card">
                <div class="gallery-img-wrapper">
                    <img src="{{ asset('img/tarhib_ramadhan.jpg') }}" alt="Tarhib Ramadhan">
                </div>
                <div class="gallery-body">
                    <span class="gallery-category">Karakter</span>
                    <h4 class="gallery-title">Tarhib Ramadhan</h4>
                    <p class="gallery-desc">Pawai menyambut bulan suci Ramadhan bersama seluruh siswa.</p>
                </div>
            </div>

            <!-- Gallery Item 6 -->
            <div class="gallery-card">
                <div class="gallery-img-wrapper">
                    <img src="{{ asset('img/field_trip.jpg') }}" alt="Field Trip">
                </div>
                <div class="gallery-body">
                    <span class="gallery-category">Akademik</span>
                    <h4 class="gallery-title">Field Trip</h4>
                    <p class="gallery-desc">Kegiatan pembelajaran di luar kelas untuk memperluas wawasan dan pengalaman langsung siswa.</p>
                </div>
            </div>

            <!-- Gallery Item 7 -->
            <div class="gallery-card">
                <div class="gallery-img-wrapper">
                    <img src="{{ asset('img/kurban.jpg') }}" alt="Kurban">
                </div>
                <div class="gallery-body">
                    <span class="gallery-category">Karakter</span>
                    <h4 class="gallery-title">Kurban</h4>
                    <p class="gallery-desc">Kegiatan penyembelihan dan penyaluran hewan kurban pada Hari Raya Idul Adha bersama warga sekolah.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Products & Services Section -->
<section class="products-section" style="padding: 70px 0; background-color: #ffffff; border-bottom: 1px solid #e2e8f0;">
    <div class="container">
        <h2 class="section-title">Rincian Layanan & Biaya Administrasi</h2>
        <p class="text-center text-muted mx-auto mb-5" style="max-width: 700px; font-size: 15px;">Berikut adalah rincian produk, seragam, buku, dan biaya administrasi PPDB Sekolah Amanah Bangsa Cikarang yang dapat dipesan dan dibayar oleh orang tua siswa melalui portal peserta setelah terdaftar resmi:</p>
        
        <div class="row g-4 justify-content-center">
            @php
                $ppdbProducts = [
                    [
                        'icon' => 'fa-file-invoice-dollar',
                        'title' => 'Biaya Pendaftaran',
                        'desc' => 'Biaya pendaftaran awal masuk sekolah dan pengolahan administrasi data calon siswa baru.',
                        'price' => 150000
                    ],
                    [
                        'icon' => 'fa-tshirt',
                        'title' => 'Seragam Sekolah (Lengkap)',
                        'desc' => 'Paket seragam merah-putih, batik sekolah, pakaian olahraga, pramuka lengkap dengan atribut topi & dasi.',
                        'price' => 450000
                    ],
                    [
                        'icon' => 'fa-book-open',
                        'title' => 'Buku LKS Semester 1',
                        'desc' => 'Buku Lembar Kerja Siswa (LKS) penunjang seluruh mata pelajaran untuk semester pertama.',
                        'price' => 120000
                    ],
                    [
                        'icon' => 'fa-book',
                        'title' => 'Buku Paket Wajib',
                        'desc' => 'Paket buku pelajaran wajib kurikulum nasional yang digunakan selama setahun penuh.',
                        'price' => 200000
                    ],
                    [
                        'icon' => 'fa-users',
                        'title' => 'Masa Orientasi Siswa (MOS)',
                        'desc' => 'Kegiatan pengenalan lingkungan sekolah, materi pembinaan karakter, dan perlengkapan MOS.',
                        'price' => 75000
                    ],
                    [
                        'icon' => 'fa-hand-holding-usd',
                        'title' => 'Iuran Komite Tahun Pertama',
                        'desc' => 'Kontribusi pembangunan sarana prasarana sekolah dan peningkatan kualitas kegiatan belajar mengajar.',
                        'price' => 300000
                    ],
                    [
                        'icon' => 'fa-id-card-alt',
                        'title' => 'Kartu Pelajar & Atribut',
                        'desc' => 'Pembuatan kartu tanda pengenal digital siswa serta atribut penanda sekolah.',
                        'price' => 50000
                    ],
                ];
            @endphp

            @foreach($ppdbProducts as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 25px; height: 100%; transition: all 0.2s;" class="product-compliance-card">
                        <div style="width: 50px; height: 50px; background: #f0fdf4; color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 16px;">
                            <i class="fas {{ $product['icon'] }}"></i>
                        </div>
                        <h4 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">{{ $product['title'] }}</h4>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 16px;">{{ $product['desc'] }}</p>
                        <div style="font-size: 16px; font-weight: 800; color: var(--primary);">Rp {{ number_format($product['price'], 0, ',', '.') }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <div class="alert alert-info d-inline-block py-2.5 px-4" style="border-radius: 12px; font-size: 14px;">
                <i class="fas fa-info-circle me-2"></i> Paket administrasi di atas dapat Anda pesan dan bayar dengan metode pembayaran <strong>QRIS</strong> di dalam Dashboard Peserta setelah registrasi.
            </div>
        </div>
    </div>
</section>

<!-- Info & Requirements Section -->
<section class="info-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-header">
                        <i class="fas fa-clipboard-check"></i>
                        <h4>Persyaratan Dokumen</h4>
                    </div>
                    <ul class="info-list">
                        <li>Mengisi formulir pendaftaran online secara lengkap.</li>
                        <li>FC Akta Kelahiran anak (bawa dokumen asli saat verifikasi).</li>
                        <li>FC Kartu Keluarga (KK) (bawa dokumen asli saat verifikasi).</li>
                        <li>FC KTP Orang Tua/Wali.</li>
                        <li>Pas foto hitam putih/berwarna ukuran 3x4 (2 lembar).</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-card">
                    <div class="info-header">
                        <i class="fas fa-info-circle"></i>
                        <h4>Contact Us</h4>
                    </div>
                    <ul class="info-list">
                        <li><i class="fas fa-phone me-2 text-primary"></i> <strong>Telepon:</strong> 0877-8329-6667</li>
                        <li><i class="fas fa-envelope me-2 text-primary"></i> <strong>Email:</strong> support@amanahbangsa.sch.id</li>
                        <li><i class="fas fa-globe me-2 text-primary"></i> <strong>Website:</strong> www.amanahbangsa.sch.id</li>
                        <li><strong>Alamat Sekolah:</strong> Jl. Irigasi Raya, Jayamukti, Cikarang Pusat, 17530, Bekasi, Jawa Barat.</li>
                        <li><strong>Hari Pelayanan Verifikasi:</strong> Senin s/d Sabtu (06.00 - 17.30 WIB).</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
