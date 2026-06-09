@extends('layouts.public')

@section('title', 'Syarat dan Ketentuan | PPDB Online Sekolah Amanah Bangsa Cikarang')

@push('styles')
<style>
    .compliance-container {
        padding: 60px 0 80px;
        background-color: #f8fafc;
        min-height: calc(100vh - 150px);
    }
    .compliance-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }
    .compliance-title {
        color: var(--primary);
        font-weight: 800;
        font-size: 28px;
        margin-bottom: 8px;
        border-bottom: 2px solid #f0fdf4;
        padding-bottom: 12px;
    }
    .compliance-meta {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 30px;
    }
    .compliance-section-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 24px;
        margin-bottom: 12px;
    }
    .compliance-text {
        font-size: 14px;
        color: #475569;
        line-height: 1.7;
        margin-bottom: 16px;
        text-align: justify;
    }
    .compliance-list {
        font-size: 14px;
        color: #475569;
        line-height: 1.7;
        margin-bottom: 20px;
        padding-left: 20px;
    }
    .compliance-list li {
        margin-bottom: 8px;
    }
</style>
@endpush

@section('content')
<div class="compliance-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="compliance-card">
                    <h1 class="compliance-title">Syarat & Ketentuan</h1>
                    <div class="compliance-meta">Terakhir Diperbarui: 30 Mei 2026</div>

                    <p class="compliance-text">Selamat datang di portal Penerimaan Peserta Didik Baru (PPDB) Online Sekolah Amanah Bangsa Cikarang. Syarat & ketentuan berikut mengatur penggunaan situs web kami dan layanan pembayaran administrasi sekolah terintegrasi kami. Dengan mengakses situs ini dan mendaftar, Anda menyetujui seluruh ketentuan di bawah ini.</p>

                    <h3 class="compliance-section-title">1. Ketentuan Umum</h3>
                    <p class="compliance-text">Situs ini disediakan untuk memfasilitasi pendaftaran siswa baru secara daring dan pembayaran administrasi penunjang pendidikan di Sekolah Amanah Bangsa Cikarang. Pihak sekolah berhak untuk menolak pendaftaran apabila data yang diserahkan terbukti tidak valid atau palsu.</p>

                    <h3 class="compliance-section-title">2. Akun dan Keamanan Data</h3>
                    <p class="compliance-text">Pendaftar bertanggung jawab penuh atas kerahasiaan nomor pendaftaran dan password akun yang digunakan untuk login ke portal peserta. Pihak sekolah berkomitmen menjaga keamanan data pribadi Anda dan tidak akan membagikannya kepada pihak ketiga tanpa persetujuan tertulis.</p>

                    <h3 class="compliance-section-title">3. Kebijakan Pembayaran</h3>
                    <ul class="compliance-list">
                        <li>Semua nilai transaksi yang tercantum pada sistem menggunakan mata uang resmi <strong>Rupiah (IDR)</strong>.</li>
                        <li>Pembayaran administrasi sekolah (meliputi Seragam, Buku, MOS, Iuran Komite, dan Atribut) dilakukan secara manual menggunakan metode QRIS Sekolah.</li>
                        <li>Transaksi pembayaran dikonfirmasi dan diverifikasi secara manual oleh panitia PPDB setelah pendaftar mengunggah bukti transfer yang sah melalui Dashboard Peserta.</li>
                        <li>Pendaftar wajib menyelesaikan pembayaran dalam batas waktu yang ditentukan oleh metode pembayaran yang dipilih (e-wallet, virtual account bank, QRIS, dll).</li>
                    </ul>

                    <h3 class="compliance-section-title">4. Dokumen Persyaratan</h3>
                    <p class="compliance-text">Calon peserta didik diwajibkan mengunggah berkas asli Kartu Keluarga (KK) dan Akta Kelahiran berformat JPG, PNG, atau PDF dengan ukuran maksimal 2MB. Ketidaksesuaian atau pemalsuan dokumen fisik yang dibawa saat verifikasi tatap muka dapat membatalkan status kelulusan pendaftaran.</p>

                    <h3 class="compliance-section-title">5. Perubahan Syarat & Ketentuan</h3>
                    <p class="compliance-text">Sekolah Amanah Bangsa Cikarang dapat mengubah syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan terlebih dahulu. Perubahan akan berlaku segera setelah dipublikasikan pada halaman ini. Harap meninjau halaman ini secara berkala.</p>

                    <h3 class="compliance-section-title">6. Informasi Hubung Kami</h3>
                    <p class="compliance-text">Jika Anda memiliki pertanyaan mengenai Syarat & Ketentuan ini, Anda dapat menghubungi kami melalui:</p>
                    <ul class="compliance-list">
                        <li><strong>Telepon:</strong> 0877-8329-6667</li>
                        <li><strong>Email:</strong> support@amanahbangsa.sch.id</li>
                        <li><strong>Website Resmi:</strong> www.amanahbangsa.sch.id</li>
                        <li><strong>Alamat:</strong> Jl. Irigasi Raya, Jayamukti, Cikarang Pusat, 17530, Bekasi, Jawa Barat.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
