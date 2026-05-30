<?php

namespace App\Http\Controllers;

use App\Models\IdentitasSiswa;
use App\Models\OrangTuaWali;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        return view('public.index');
    }

    public function daftarSiswa()
    {
        return view('public.daftar_siswa');
    }

    public function storeSiswa(Request $request)
    {
        $validated = $request->validate([
            'nisn'               => 'required|string|max:15|unique:identitas_siswa,nisn',
            'no_kk'              => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto_akta'          => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'nik'                => 'required|string|max:16|unique:identitas_siswa,nik',
            'nama_panggilan'     => 'required|string|max:50',
            'nama_peserta_didik' => 'required|string|max:100',
            'tempat_lahir'       => 'required|string|max:50',
            'tanggal_lahir'      => 'required|date',
            'jenis_kelamin'      => 'required|in:Laki-Laki,Perempuan',
            'agama'              => 'required|string|max:20',
            'gol_darah'          => 'nullable|string|max:5',
            'tinggi_badan'       => 'nullable|integer',
            'berat_badan'        => 'nullable|integer',
            'suku'               => 'nullable|string|max:30',
            'bahasa'             => 'nullable|string|max:30',
            'kewarganegaraan'    => 'required|string|max:20',
            'status_anak'        => 'nullable|string|max:20',
            'anak_ke'            => 'required|integer|min:1',
            'jml_saudara'        => 'required|integer|min:0',
            'jenis_tinggal'      => 'nullable|string|max:30',
            'alamat_tinggal'     => 'required|string',
            'provinsi_tinggal'   => 'required|string|max:50',
            'kab_kota_tinggal'   => 'required|string|max:50',
            'kec_tinggal'        => 'required|string|max:50',
            'kelurahan_tinggal'  => 'required|string|max:50',
            'kode_pos'           => 'nullable|string|max:10',
            'jarak_ke_sekolah'   => 'nullable|integer',
            'riwayat_penyakit'   => 'nullable|string',
        ], [
            'nisn.required'  => 'NISN wajib diisi!',
            'nisn.unique'    => 'NISN sudah terdaftar! Hubungi sekolah jika ada kendala.',
            'nik.unique'     => 'NIK sudah terdaftar! Hubungi sekolah jika ada kendala.',
            'nama_peserta_didik.required' => 'Nama lengkap siswa wajib diisi!',
            'jenis_kelamin.required'      => 'Jenis kelamin wajib dipilih!',
            'no_kk.required' => 'File Kartu Keluarga wajib diunggah!',
            'no_kk.file'     => 'File Kartu Keluarga tidak valid!',
            'no_kk.mimes'    => 'Format Kartu Keluarga harus JPG, JPEG, PNG, atau PDF!',
            'no_kk.max'      => 'Ukuran Kartu Keluarga maksimal 2MB!',
            'foto_akta.required' => 'File Akta Kelahiran wajib diunggah!',
            'foto_akta.file'     => 'File Akta Kelahiran tidak valid!',
            'foto_akta.mimes'    => 'Format Akta Kelahiran harus JPG, JPEG, PNG, atau PDF!',
            'foto_akta.max'      => 'Ukuran Akta Kelahiran maksimal 2MB!',
        ]);

        if ($request->hasFile('no_kk')) {
            $validated['no_kk'] = $request->file('no_kk')->store('kartu_keluarga', 'public');
        }

        if ($request->hasFile('foto_akta')) {
            $validated['foto_akta'] = $request->file('foto_akta')->store('akta_kelahiran', 'public');
        }

        $siswa = IdentitasSiswa::create($validated);

        return redirect()->route('public.daftar-ortu', ['siswumId' => $siswa->id])
            ->with('success', 'Data siswa berhasil disimpan! Silakan isi data orang tua/wali.')
            ->with('siswa_id', $siswa->id);
    }

    public function daftarOrtu(Request $request)
    {
        $siswaId = $request->get('siswumId') ?? session('siswa_id');
        $siswa   = IdentitasSiswa::findOrFail($siswaId);
        return view('public.daftar_ortu', compact('siswa'));
    }

    public function storeOrtu(Request $request)
    {
        $validated = $request->validate([
            'identitas_siswa_id'       => 'required|exists:identitas_siswa,id',
            'nama_ayah'                => 'required|string|max:60',
            'status_ayah'              => 'required|string',
            'tgl_lahir_ayah'           => 'nullable|date',
            'telepon_ayah'             => 'nullable|string|max:20',
            'pendidikan_terakhir_ayah' => 'nullable|string|max:30',
            'pekerjaan_ayah'           => 'nullable|string|max:50',
            'penghasilan_ayah'         => 'nullable|numeric',
            'alamat_ayah'              => 'nullable|string',
            'nama_ibu'                 => 'required|string|max:60',
            'status_ibu'               => 'required|string',
            'tgl_lahir_ibu'            => 'nullable|date',
            'telepon_ibu'              => 'nullable|string|max:20',
            'pendidikan_terakhir_ibu'  => 'nullable|string|max:30',
            'pekerjaan_ibu'            => 'nullable|string|max:50',
            'penghasilan_ibu'          => 'nullable|numeric',
            'alamat_ibu'               => 'nullable|string',
            'nama_wali'                => 'nullable|string|max:60',
            'status_wali'              => 'nullable|string|max:20',
            'telepon_wali'             => 'nullable|string|max:20',
        ]);

        OrangTuaWali::create($validated);

        $siswa = IdentitasSiswa::find($validated['identitas_siswa_id']);
        return redirect()->route('public.index')
            ->with('success', 'Pendaftaran berhasil! Nomor pendaftaran Anda: <strong>' . $siswa->no_pendaftaran . '</strong>. Harap catat nomor ini.');
    }

    public function syaratKetentuan()
    {
        return view('public.terms');
    }

    public function kebijakanPengembalian()
    {
        return view('public.refund');
    }
}
