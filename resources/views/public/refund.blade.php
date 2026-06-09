@extends('layouts.public')

@section('title', 'Kebijakan Pengembalian Dana | PPDB Online Sekolah Amanah Bangsa Cikarang')

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
                    <h1 class="compliance-title">Kebijakan Pengembalian Dana & Produk</h1>
                    <div class="compliance-meta">Terakhir Diperbarui: 30 Mei 2026</div>

                    <p class="compliance-text">Seluruh transaksi pembayaran yang diproses melalui portal PPDB Online Sekolah Amanah Bangsa Cikarang dialokasikan untuk pemenuhan kebutuhan atribut siswa baru (seperti seragam, buku wajib, kartu pelajar, dll) serta kegiatan penunjang akademik awal tahun ajaran.</p>

                    <p class="compliance-text">Mohon dipahami kebijakan kami mengenai pengembalian dana (refund) dan penukaran produk seragam/atribut berikut:</p>

                    <h3 class="compliance-section-title">1. Kebijakan Pengembalian Dana (Refund)</h3>
                    <ul class="compliance-list">
                        <li>Seluruh transaksi pembayaran administrasi PPDB yang telah sukses statusnya di sistem bersifat <strong>final dan tidak dapat dibatalkan atau dikembalikan (non-refundable)</strong> karena langsung diproses untuk pemesanan logistik siswa.</li>
                        <li>Pengecualian refund dana hanya berlaku apabila terjadi kasus **transaksi ganda** (pembayar secara tidak sengaja terpotong saldonya dua kali untuk item yang sama akibat kesalahan sistem atau delay gateway).</li>
                        <li>Untuk klaim transaksi ganda, silakan hubungi panitia melalui email support@amanahbangsa.sch.id dengan menyertakan bukti pembayaran dan kode transaksi pembayaran (payment code) yang sah. Klaim wajib diajukan maksimal 7 hari kerja sejak tanggal transaksi.</li>
                        <li>Proses pengembalian dana atas transaksi ganda yang disetujui akan diproses dalam waktu 7-14 hari kerja dikirimkan ke rekening asal pembayar.</li>
                    </ul>

                    <h3 class="compliance-section-title">2. Kebijakan Penukaran Produk (Retur Fisik)</h3>
                    <ul class="compliance-list">
                        <li>Barang fisik berupa seragam sekolah, atribut badge, atau buku yang telah diterima oleh siswa dapat ditukarkan jika terdapat **cacat produksi** (sobek, rusak, salah cetak) atau **salah ukuran** (ukuran tidak muat saat dicoba pertama kali).</li>
                        <li>Penukaran barang wajib diajukan langsung ke koperasi sekolah pada hari dinas (Senin - Jumat) paling lambat 3 hari setelah seragam atau buku dibagikan/diterima secara fisik oleh pihak orang tua.</li>
                        <li>Barang yang ditukarkan harus dalam kondisi **baru/belum pernah dipakai beraktivitas**, belum dicuci, dan label penanda ukuran masih terpasang dengan baik.</li>
                        <li>Sekolah Amanah Bangsa Cikarang tidak membebankan biaya tambahan untuk penukaran atribut/seragam yang cacat atau salah ukuran, selama persediaan stok di koperasi sekolah masih tersedia.</li>
                    </ul>

                    <h3 class="compliance-section-title">3. Bantuan Kontak Layanan</h3>
                    <p class="compliance-text">Jika terdapat kendala pembayaran atau klaim produk fisik, silakan hubungi kontak panitia resmi kami:</p>
                    <ul class="compliance-list">
                        <li><strong>Telepon Koperasi & PPDB:</strong> 0877-8329-6667</li>
                        <li><strong>Email Layanan:</strong> support@amanahbangsa.sch.id</li>
                        <li><strong>Alamat Penukaran:</strong> Koperasi Sekolah Amanah Bangsa Cikarang, Jl. Irigasi Raya, Jayamukti, Cikarang Pusat, 17530, Bekasi, Jawa Barat.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
