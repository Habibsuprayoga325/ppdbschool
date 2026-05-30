<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdministrasiItem extends Model
{
    use HasFactory;

    protected $table = 'administrasi_items';

    protected $fillable = [
        'nama',
        'nominal',
    ];

    public function pembayaranPeserta(): HasMany
    {
        return $this->hasMany(PembayaranPeserta::class, 'administrasi_item_id');
    }

    public function getNominalFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }
}
