@extends('layouts.app')
@section('title', 'Verifikasi Pembayaran')
@section('page-title', 'Verifikasi Pembayaran')

@section('content')
<div class="page-header">
    <div>
        <h1>Verifikasi Pembayaran</h1>
        <nav class="breadcrumb-custom"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Verifikasi Pembayaran</nav>
    </div>
</div>

<!-- Stats Banner -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="fas fa-list-ol"></i></div>
            <div>
                <div class="stat-value">{{ $pembayaranGroups->count() }}</div>
                <div class="stat-label">Total Transaksi</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon warning"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <div class="stat-value">
                    {{ $pembayaranGroups->filter(fn($g) => $g->first()->status === 'menunggu_verifikasi')->count() }}
                </div>
                <div class="stat-label">Menunggu Verifikasi</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-value">
                    {{ $pembayaranGroups->filter(fn($g) => $g->first()->status === 'lunas')->count() }}
                </div>
                <div class="stat-label">Diterima / Lunas</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><i class="fas fa-check-double text-primary me-2"></i>Daftar Pengajuan Pembayaran</div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tabelPembayaran" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Bayar</th>
                        <th>Peserta</th>
                        <th>Item Administrasi</th>
                        <th class="text-end">Total Nominal</th>
                        <th>Tanggal</th>
                        <th>Bukti</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $idx = 1; @endphp
                    @foreach($pembayaranGroups as $paymentCode => $group)
                        @php
                            $first = $group->first();
                            if ($first->status !== 'menunggu_verifikasi') {
                                continue;
                            }
                            $student = $first->identitasSiswa;
                            $totalNominal = $group->sum(fn($p) => $p->administrasiItem->nominal);
                            $itemsNames = $group->map(fn($p) => $p->administrasiItem->nama)->implode(', ');
                            $fileUrl = filter_var($first->payment_proof, FILTER_VALIDATE_URL)
                                ? $first->payment_proof
                                : asset('storage/' . $first->payment_proof);
                            
                            $filePath = parse_url($first->payment_proof, PHP_URL_PATH) ?? $first->payment_proof;
                            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                        @endphp
                        <tr>
                            <td>{{ $idx++ }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $paymentCode }}</span></td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $student->nama_peserta_didik ?? '-' }}</div>
                                <small class="text-muted">NISN: {{ $student->nisn ?? '-' }}</small>
                            </td>
                            <td>
                                <div style="max-width: 250px; font-size: 13px;" class="text-dark">{{ $itemsNames }}</div>
                                @if($first->catatan)
                                    <div class="small text-muted mt-1">
                                        <i class="fas fa-comment-dots text-primary me-1"></i>Catatan: "{{ $first->catatan }}"
                                    </div>
                                @endif
                            </td>
                            <td class="text-end fw-bold text-dark">
                                Rp {{ number_format($totalNominal, 0, ',', '.') }}
                            </td>
                            <td>
                                <div style="font-size: 13px;">{{ $first->created_at?->format('d M Y') }}</div>
                                <small class="text-muted">{{ $first->created_at?->format('H:i') }} WIB</small>
                            </td>
                            <td>
                                @if($first->payment_proof)
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="showBukti('{{ $fileUrl }}', '{{ $fileExtension }}')">
                                        <i class="fas fa-image me-1"></i> Lihat
                                    </button>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge text-white bg-info">Menunggu Verifikasi</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <form action="{{ route('admin.pembayaran.konfirmasi', $paymentCode) }}" method="POST"
                                          onsubmit="return confirm('Konfirmasi Lunas transaksi ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success text-white">
                                            <i class="fas fa-check me-1"></i> Terima
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.pembayaran.tolak', $paymentCode) }}" method="POST"
                                          onsubmit="return confirm('Tolak transaksi ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger text-white">
                                            <i class="fas fa-times me-1"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Bukti Transaksi -->
<div class="modal fade" id="buktiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-receipt text-primary me-2"></i>Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4" id="buktiModalContent">
                <!-- Content loaded dynamically -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#tabelPembayaran').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json' },
        responsive: false,
        columnDefs: [{ orderable: false, targets: [6, 8] }]
    });
});

function showBukti(url, extension) {
    let content = '';
    if (extension === 'pdf') {
        content = `<iframe src="${url}" style="width:100%; height:550px; border-radius:10px;" frameborder="0"></iframe>`;
    } else {
        content = `<img src="${url}" class="img-fluid rounded-3 shadow-sm" style="max-height: 75vh; object-fit: contain;" />`;
    }
    $('#buktiModalContent').html(content);
    new bootstrap.Modal(document.getElementById('buktiModal')).show();
}
</script>
@endpush
