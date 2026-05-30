<?php

namespace Database\Seeders;

use App\Models\AdministrasiItem;
use Illuminate\Database\Seeder;

class AdministrasiItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nama' => 'Biaya Pendaftaran', 'nominal' => 150000],
            ['nama' => 'Seragam Sekolah (Lengkap)', 'nominal' => 450000],
            ['nama' => 'Buku LKS Semester 1', 'nominal' => 120000],
            ['nama' => 'Buku Paket Wajib', 'nominal' => 200000],
            ['nama' => 'Kegiatan Orientasi Siswa (MOS)', 'nominal' => 75000],
            ['nama' => 'Iuran Komite Tahun Pertama', 'nominal' => 300000],
            ['nama' => 'Kartu Pelajar & Atribut', 'nominal' => 50000],
        ];

        foreach ($items as $item) {
            AdministrasiItem::updateOrCreate(
                ['nama' => $item['nama']],
                ['nominal' => $item['nominal']]
            );
        }
    }
}
