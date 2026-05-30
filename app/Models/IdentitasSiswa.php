<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IdentitasSiswa extends Model
{
    use HasFactory;

    protected $table = 'identitas_siswa';

    protected $fillable = [
        'nisn', 'no_kk', 'nik', 'nama_panggilan', 'nama_peserta_didik',
        'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'gol_darah',
        'tinggi_badan', 'berat_badan', 'suku', 'bahasa', 'kewarganegaraan',
        'status_anak', 'anak_ke', 'jml_saudara', 'jenis_tinggal', 'alamat_tinggal',
        'provinsi_tinggal', 'kab_kota_tinggal', 'kec_tinggal', 'kelurahan_tinggal',
        'kode_pos', 'jarak_ke_sekolah', 'riwayat_penyakit', 'status_ortu',
        'status_administrasi', 'tahun_ajaran', 'foto_siswa', 'foto_akta', 'no_pendaftaran',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'status_ortu' => 'boolean',
        'status_administrasi' => 'boolean',
    ];

    public function orangTuaWali(): HasOne
    {
        return $this->hasOne(OrangTuaWali::class, 'identitas_siswa_id');
    }

    public function administrasi(): HasOne
    {
        return $this->hasOne(Administrasi::class, 'identitas_siswa_id');
    }

    public function pembayaranPeserta(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PembayaranPeserta::class, 'identitas_siswa_id');
    }

    public function syncOverallAdministrasiStatus(): void
    {
        $totalItemsCount = \App\Models\AdministrasiItem::count();
        $paidItemsCount = $this->pembayaranPeserta()->where('status', 'lunas')->count();

        $isAllLunas = ($paidItemsCount === $totalItemsCount && $totalItemsCount > 0);

        $administrasi = $this->administrasi;
        if (!$administrasi) {
            $administrasi = new \App\Models\Administrasi();
            $administrasi->identitas_siswa_id = $this->id;
        }

        $administrasi->harga = 1345000; // total nominal
        $administrasi->status = $isAllLunas ? 'Lunas' : 'Belum Lunas';
        $administrasi->keterangan = $isAllLunas 
            ? 'Lunas Pembayaran Administrasi PPDB' 
            : 'Belum Lunas (' . $paidItemsCount . '/' . $totalItemsCount . ' item lunas)';
        $administrasi->save();
    }

    /**
     * Generate nomor pendaftaran otomatis
     */
    public static function generateNoPendaftaran(): string
    {
        $tahun = date('Y');
        $last = self::whereYear('created_at', $tahun)->max('id') ?? 0;
        return 'PPDB-' . $tahun . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }

    protected static function booted(): void
    {
        static::creating(function ($siswa) {
            if (empty($siswa->no_pendaftaran)) {
                $siswa->no_pendaftaran = self::generateNoPendaftaran();
            }
            if (empty($siswa->tahun_ajaran)) {
                $year = (int)date('Y');
                $siswa->tahun_ajaran = $year . '/' . ($year + 1);
            }
        });

        static::updated(function ($siswa) {
            // Status ortu & administrasi diupdate otomatis oleh relasi
        });
    }
}
