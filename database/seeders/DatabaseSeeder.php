<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\IdentitasSiswa;
use App\Models\OrangTuaWali;
use App\Models\Administrasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Users
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'nama'     => 'Tiara Ekylia Eriza Putri',
                'password' => Hash::make('admin123'),
                'hak'      => 'admin',
                'status'   => 'aktif',
            ]
        );

        User::updateOrCreate(
            ['username' => 'pegawai'],
            [
                'nama'     => 'Andi Santoso',
                'password' => Hash::make('pegawai123'),
                'hak'      => 'pegawai',
                'status'   => 'aktif',
            ]
        );

        // Seed Siswa sample if not already seeded
        $siswaExists = IdentitasSiswa::where('nisn', '0001999901')->exists();
        if (!$siswaExists) {
            $siswa1 = IdentitasSiswa::create([
                'nisn'               => '0001999901',
                'no_kk'              => '0001999901666444',
                'nik'                => '0001999901666445',
                'nama_panggilan'     => 'Agung',
                'nama_peserta_didik' => 'Agung Dermawan',
                'tempat_lahir'       => 'Jember',
                'tanggal_lahir'      => '2014-11-14',
                'jenis_kelamin'      => 'Laki-Laki',
                'agama'              => 'Islam',
                'gol_darah'          => 'A',
                'tinggi_badan'       => 108,
                'berat_badan'        => 28,
                'suku'               => 'Jawa',
                'bahasa'             => 'Indonesia',
                'kewarganegaraan'    => 'Indonesia',
                'status_anak'        => 'Kandung',
                'anak_ke'            => 2,
                'jml_saudara'        => 3,
                'jenis_tinggal'      => 'Kontrak',
                'alamat_tinggal'     => 'Jl. Dr. Soebandi Gg. Kenitu',
                'provinsi_tinggal'   => 'Jawa Barat',
                'kab_kota_tinggal'   => 'Bekasi',
                'kec_tinggal'        => 'Cikarang Utara',
                'kelurahan_tinggal'  => 'Mekar Mukti',
                'kode_pos'           => '17530',
                'jarak_ke_sekolah'   => 500,
                'riwayat_penyakit'   => 'Tidak Ada',
                'tahun_ajaran'       => '2026/2027',
            ]);

            OrangTuaWali::create([
                'identitas_siswa_id'         => $siswa1->id,
                'nama_ayah'                  => 'Dedi Sunarto',
                'status_ayah'                => 'Kandung',
                'tgl_lahir_ayah'             => '1988-08-30',
                'telepon_ayah'               => '089623492347',
                'pendidikan_terakhir_ayah'   => 'SMA',
                'pekerjaan_ayah'             => 'Teknisi',
                'penghasilan_ayah'           => 4000000,
                'alamat_ayah'                => 'Jl. Dr. Soebandi Gg. Kenitu',
                'nama_ibu'                   => 'Dewi Setia',
                'status_ibu'                 => 'Kandung',
                'tgl_lahir_ibu'              => '1991-10-13',
                'telepon_ibu'                => '082323231231',
                'pendidikan_terakhir_ibu'    => 'SMA',
                'pekerjaan_ibu'              => 'Ibu Rumah Tangga',
                'penghasilan_ibu'            => 0,
                'alamat_ibu'                 => 'Jl. Dr. Soebandi Gg. Kenitu',
            ]);

            Administrasi::create([
                'identitas_siswa_id' => $siswa1->id,
                'harga'              => 1250000,
                'status'             => 'Lunas',
                'keterangan'         => 'Pembayaran biaya pendaftaran',
            ]);
        }

        $this->call(AdministrasiItemSeeder::class);
    }
}
