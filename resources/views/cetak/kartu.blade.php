<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Pendaftaran - {{ $siswa->nama_peserta_didik }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .no-print-area {
            margin-bottom: 24px;
        }
        .btn-print {
            background-color: #1e7c3e;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(30, 124, 62, 0.2);
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-print:hover {
            background-color: #166534;
            transform: translateY(-1px);
        }

        /* Card Container */
        .kartu-pendaftaran {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 650px;
            overflow: hidden;
            background-image: radial-gradient(circle at 100% 0%, rgba(30, 124, 62, 0.03) 0%, transparent 60%);
        }
        
        /* Card Header */
        .kartu-header {
            background: #1e7c3e;
            color: white;
            padding: 24px 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
        }
        .kartu-logo {
            width: 54px;
            height: 54px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #06b6d4;
        }
        .kartu-title h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .kartu-title p {
            margin: 4px 0 0;
            font-size: 12px;
            opacity: 0.8;
            letter-spacing: 0.5px;
        }
        .reg-number {
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 700;
            color: #06b6d4;
        }

        /* Card Body */
        .kartu-body {
            padding: 30px;
            display: flex;
            gap: 30px;
        }
        .kartu-photo-section {
            width: 140px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
        }
        .kartu-photo {
            width: 130px;
            height: 170px;
            border-radius: 12px;
            background-color: #f8fafc;
            border: 2px dashed #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            font-size: 40px;
            color: #94a3b8;
        }
        .kartu-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .status-stamp {
            border: 2px solid #10b981;
            color: #10b981;
            border-radius: 8px;
            padding: 4px 12px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            transform: rotate(-5deg);
            display: inline-block;
        }
        .status-stamp.pending {
            border-color: #f59e0b;
            color: #f59e0b;
        }
        
        /* Details Section */
        .kartu-details {
            flex: 1;
        }
        .detail-row {
            display: flex;
            padding: 6px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            width: 140px;
            font-weight: 600;
            color: #64748b;
        }
        .detail-value {
            flex: 1;
            font-weight: 500;
            color: #1e293b;
        }
        
        /* Card Footer */
        .kartu-footer {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: #64748b;
        }
        .signature-block {
            text-align: center;
            width: 180px;
        }
        .signature-title {
            margin-bottom: 50px;
        }
        .signature-name {
            font-weight: 700;
            color: #1e293b;
            border-bottom: 1px solid #94a3b8;
            padding-bottom: 2px;
            display: inline-block;
        }

        /* Print Media Styles */
        @media print {
            body {
                background-color: white;
                padding: 0;
                margin: 0;
            }
            .no-print-area {
                display: none;
            }
            .kartu-pendaftaran {
                border: none;
                box-shadow: none;
                max-width: 100%;
                width: 100%;
                border-radius: 0;
            }
            .kartu-header {
                background: #1e7c3e !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .reg-number {
                border-color: rgba(255,255,255,0.4) !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .kartu-footer {
                background-color: transparent !important;
                border-top: 1px solid #e2e8f0;
            }
        }
    </style>
</head>
<body>

    <!-- Print Control Bar -->
    <div class="no-print-area">
        <button onclick="window.print()" class="btn-print">
            <i class="fas fa-print"></i> Cetak Kartu Pendaftaran
        </button>
        <button onclick="window.close()" class="btn-print" style="background-color: #64748b; box-shadow: none; margin-left: 10px;">
            Tutup
        </button>
    </div>

    <!-- Official Registration Card -->
    <div class="kartu-pendaftaran">
        <div class="kartu-header">
            <div class="kartu-logo" style="background: white; padding: 6px 12px; border-radius: 10px; height: 50px; width: 180px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <img src="{{ asset('img/tut.png') }}" alt="Logo" style="height: 100%; width: 100%; object-fit: contain;">
            </div>
            <div class="kartu-title">
                <h2>KARTU PENDAFTARAN PPDB</h2>
                <p>Sekolah Amanah Bangsa Cikarang | TA 2026/2027</p>
            </div>
            <div class="reg-number">
                {{ $siswa->no_pendaftaran }}
            </div>
        </div>
        
        <div class="kartu-body">
            <div class="kartu-photo-section">
                <div class="kartu-photo">
                    @if($siswa->foto_siswa)
                        <img src="{{ asset('storage/' . $siswa->foto_siswa) }}" alt="Foto Siswa">
                    @else
                        <i class="fas fa-user"></i>
                    @endif
                </div>
                
                @if($siswa->administrasi && $siswa->administrasi->status === 'Lunas')
                    <span class="status-stamp">Terverifikasi</span>
                @else
                    <span class="status-stamp pending">Pending Verifikasi</span>
                @endif
            </div>
            
            <div class="kartu-details">
                <div class="detail-row">
                    <span class="detail-label">NISN</span>
                    <span class="detail-value">{{ $siswa->nisn }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Nama Lengkap</span>
                    <span class="detail-value fw-semibold" style="text-transform: uppercase;">{{ $siswa->nama_peserta_didik }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tempat/Tgl Lahir</span>
                    <span class="detail-value">{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir?->format('d/m/Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jenis Kelamin</span>
                    <span class="detail-value">{{ $siswa->jenis_kelamin }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Orang Tua / Wali</span>
                    <span class="detail-value">{{ $siswa->orangTuaWali->nama_ayah ?? ($siswa->orangTuaWali->nama_ibu ?? '-') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Alamat</span>
                    <span class="detail-value" style="font-size: 12px; line-height: 1.4;">{{ $siswa->alamat_tinggal }}</span>
                </div>
            </div>
        </div>
        
        <div class="kartu-footer">
            <div>
                <p style="margin: 0; font-weight: 600;">Catatan:</p>
                <p style="margin: 2px 0 0; line-height: 1.3;">1. Kartu ini dicetak sebagai bukti pendaftaran online.<br>2. Bawa dokumen KK & Akta Asli untuk verifikasi di sekolah.</p>
            </div>
            
            <div class="signature-block">
                <div class="signature-title">Panitia PPDB,</div>
                <div class="signature-name">Keuangan & Adm. PPDB</div>
            </div>
        </div>
    </div>

    <script>
        // Auto trigger print when page opens
        window.addEventListener('DOMContentLoaded', () => {
            // setTimeout to ensure fonts are loaded
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
