<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrangTuaWali extends Model
{
    use HasFactory;

    protected $table = 'orang_tua_wali';

    protected $fillable = [
        'identitas_siswa_id',
        'nama_ayah', 'status_ayah', 'tgl_lahir_ayah', 'telepon_ayah',
        'pendidikan_terakhir_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'alamat_ayah',
        'nama_ibu', 'status_ibu', 'tgl_lahir_ibu', 'telepon_ibu',
        'pendidikan_terakhir_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'alamat_ibu',
        'nama_wali', 'status_wali', 'tgl_lahir_wali', 'telepon_wali',
        'pendidikan_terakhir_wali', 'pekerjaan_wali', 'penghasilan_wali', 'alamat_wali',
    ];

    protected $casts = [
        'tgl_lahir_ayah' => 'date',
        'tgl_lahir_ibu'  => 'date',
        'tgl_lahir_wali' => 'date',
    ];

    public function identitasSiswa(): BelongsTo
    {
        return $this->belongsTo(IdentitasSiswa::class, 'identitas_siswa_id');
    }

    protected static function booted(): void
    {
        static::created(function ($ortu) {
            $ortu->identitasSiswa()->update(['status_ortu' => true]);
        });

        static::deleted(function ($ortu) {
            $ortu->identitasSiswa()->update(['status_ortu' => false]);
        });
    }
}
