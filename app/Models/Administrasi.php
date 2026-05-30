<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Administrasi extends Model
{
    use HasFactory;

    protected $table = 'administrasi';

    protected $fillable = [
        'identitas_siswa_id',
        'harga',
        'status',
        'keterangan',
    ];

    public function identitasSiswa(): BelongsTo
    {
        return $this->belongsTo(IdentitasSiswa::class, 'identitas_siswa_id');
    }

    protected static function booted(): void
    {
        static::created(function ($adm) {
            $adm->identitasSiswa()->update(['status_administrasi' => true]);
        });

        static::deleted(function ($adm) {
            $adm->identitasSiswa()->update(['status_administrasi' => false]);
        });

        static::updated(function ($adm) {
            $status = $adm->status === 'Lunas' ? true : false;
            $adm->identitasSiswa()->update(['status_administrasi' => $status]);
        });
    }

    public function getHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
