<?php

namespace App\Http\Controllers;

use App\Models\IdentitasSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = IdentitasSiswa::with('orangTuaWali', 'administrasi')->latest()->get();
        return view('siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
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
            'foto_siswa'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nisn.required'               => 'NISN wajib diisi!',
            'nisn.unique'                 => 'NISN sudah terdaftar!',
            'nik.unique'                  => 'NIK sudah terdaftar!',
            'nama_peserta_didik.required' => 'Nama lengkap wajib diisi!',
            'jenis_kelamin.required'      => 'Jenis kelamin wajib dipilih!',
            'alamat_tinggal.required'     => 'Alamat wajib diisi!',
            'no_kk.required'              => 'File Kartu Keluarga wajib diunggah!',
            'no_kk.file'                  => 'File Kartu Keluarga tidak valid!',
            'no_kk.mimes'                 => 'Format Kartu Keluarga harus JPG, JPEG, PNG, atau PDF!',
            'no_kk.max'                   => 'Ukuran Kartu Keluarga maksimal 2MB!',
            'foto_akta.required'          => 'File Akta Kelahiran wajib diunggah!',
            'foto_akta.file'              => 'File Akta Kelahiran tidak valid!',
            'foto_akta.mimes'             => 'Format Akta Kelahiran harus JPG, JPEG, PNG, atau PDF!',
            'foto_akta.max'               => 'Ukuran Akta Kelahiran maksimal 2MB!',
        ]);

        if ($request->hasFile('foto_siswa')) {
            $validated['foto_siswa'] = $request->file('foto_siswa')->store('foto_siswa', 'public');
        }

        if ($request->hasFile('no_kk')) {
            $validated['no_kk'] = $request->file('no_kk')->store('kartu_keluarga', 'public');
        }

        if ($request->hasFile('foto_akta')) {
            $validated['foto_akta'] = $request->file('foto_akta')->store('akta_kelahiran', 'public');
        }

        IdentitasSiswa::create($validated);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show(IdentitasSiswa $siswum)
    {
        $siswum->load('orangTuaWali', 'administrasi');
        return view('siswa.show', ['siswa' => $siswum]);
    }

    public function edit(IdentitasSiswa $siswum)
    {
        return view('siswa.edit', ['siswa' => $siswum]);
    }

    public function update(Request $request, IdentitasSiswa $siswum)
    {
        $validated = $request->validate([
            'nisn'               => 'required|string|max:15|unique:identitas_siswa,nisn,' . $siswum->id,
            'no_kk'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto_akta'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'nik'                => 'required|string|max:16|unique:identitas_siswa,nik,' . $siswum->id,
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
            'foto_siswa'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'no_kk.file'     => 'File Kartu Keluarga tidak valid!',
            'no_kk.mimes'    => 'Format Kartu Keluarga harus JPG, JPEG, PNG, atau PDF!',
            'no_kk.max'      => 'Ukuran Kartu Keluarga maksimal 2MB!',
            'foto_akta.file'     => 'File Akta Kelahiran tidak valid!',
            'foto_akta.mimes'    => 'Format Akta Kelahiran harus JPG, JPEG, PNG, atau PDF!',
            'foto_akta.max'      => 'Ukuran Akta Kelahiran maksimal 2MB!',
        ]);

        $data = $request->except(['foto_siswa', 'no_kk', 'foto_akta']);

        if ($request->hasFile('foto_siswa')) {
            if ($siswum->foto_siswa) {
                Storage::disk('public')->delete($siswum->foto_siswa);
            }
            $data['foto_siswa'] = $request->file('foto_siswa')->store('foto_siswa', 'public');
        }

        if ($request->hasFile('no_kk')) {
            if ($siswum->no_kk) {
                Storage::disk('public')->delete($siswum->no_kk);
            }
            $data['no_kk'] = $request->file('no_kk')->store('kartu_keluarga', 'public');
        }

        if ($request->hasFile('foto_akta')) {
            if ($siswum->foto_akta) {
                Storage::disk('public')->delete($siswum->foto_akta);
            }
            $data['foto_akta'] = $request->file('foto_akta')->store('akta_kelahiran', 'public');
        }

        $siswum->update($data);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(IdentitasSiswa $siswum)
    {
        if ($siswum->foto_siswa) {
            Storage::disk('public')->delete($siswum->foto_siswa);
        }
        $siswum->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }
}
