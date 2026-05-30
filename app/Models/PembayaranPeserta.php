<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranPeserta extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_peserta';

    protected $fillable = [
        'identitas_siswa_id',
        'administrasi_item_id',
        'payment_code',
        'bukti_bayar',
        'catatan',
        'status',
    ];

    public function identitasSiswa(): BelongsTo
    {
        return $this->belongsTo(IdentitasSiswa::class, 'identitas_siswa_id');
    }

    public function administrasiItem(): BelongsTo
    {
        return $this->belongsTo(AdministrasiItem::class, 'administrasi_item_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'lunas' => 'Lunas',
            'ditolak' => 'Ditolak',
            default => 'Belum Dibayar',
        };
    }
}
