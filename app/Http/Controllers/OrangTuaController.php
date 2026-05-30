<?php

namespace App\Http\Controllers;

use App\Models\OrangTuaWali;
use App\Models\IdentitasSiswa;
use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    public function index()
    {
        $orangTua = OrangTuaWali::with('identitasSiswa')->latest()->get();
        return view('orangtua.index', compact('orangTua'));
    }

    public function create()
    {
        $siswa = IdentitasSiswa::whereDoesntHave('orangTuaWali')->get();
        return view('orangtua.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'identitas_siswa_id'         => 'required|exists:identitas_siswa,id|unique:orang_tua_wali,identitas_siswa_id',
            'nama_ayah'                  => 'required|string|max:60',
            'status_ayah'                => 'required|string|max:20',
            'tgl_lahir_ayah'             => 'nullable|date',
            'telepon_ayah'               => 'nullable|string|max:20',
            'pendidikan_terakhir_ayah'   => 'nullable|string|max:30',
            'pekerjaan_ayah'             => 'nullable|string|max:50',
            'penghasilan_ayah'           => 'nullable|numeric',
            'alamat_ayah'                => 'nullable|string',
            'nama_ibu'                   => 'required|string|max:60',
            'status_ibu'                 => 'required|string|max:20',
            'tgl_lahir_ibu'              => 'nullable|date',
            'telepon_ibu'                => 'nullable|string|max:20',
            'pendidikan_terakhir_ibu'    => 'nullable|string|max:30',
            'pekerjaan_ibu'              => 'nullable|string|max:50',
            'penghasilan_ibu'            => 'nullable|numeric',
            'alamat_ibu'                 => 'nullable|string',
            'nama_wali'                  => 'nullable|string|max:60',
            'status_wali'                => 'nullable|string|max:20',
            'tgl_lahir_wali'             => 'nullable|date',
            'telepon_wali'               => 'nullable|string|max:20',
            'pendidikan_terakhir_wali'   => 'nullable|string|max:30',
            'pekerjaan_wali'             => 'nullable|string|max:50',
            'penghasilan_wali'           => 'nullable|numeric',
            'alamat_wali'                => 'nullable|string',
        ], [
            'identitas_siswa_id.required' => 'Siswa wajib dipilih!',
            'identitas_siswa_id.unique'   => 'Data orang tua siswa ini sudah ada!',
            'nama_ayah.required'          => 'Nama ayah wajib diisi!',
            'nama_ibu.required'           => 'Nama ibu wajib diisi!',
        ]);

        OrangTuaWali::create($validated);

        return redirect()->route('admin.orangtua.index')->with('success', 'Data orang tua/wali berhasil ditambahkan!');
    }

    public function show(OrangTuaWali $orangtum)
    {
        $orangtum->load('identitasSiswa');
        return view('orangtua.show', ['orangTua' => $orangtum]);
    }

    public function edit(OrangTuaWali $orangtum)
    {
        $siswa = IdentitasSiswa::all();
        return view('orangtua.edit', ['orangTua' => $orangtum, 'siswa' => $siswa]);
    }

    public function update(Request $request, OrangTuaWali $orangtum)
    {
        $validated = $request->validate([
            'identitas_siswa_id'         => 'required|exists:identitas_siswa,id',
            'nama_ayah'                  => 'required|string|max:60',
            'status_ayah'                => 'required|string|max:20',
            'tgl_lahir_ayah'             => 'nullable|date',
            'telepon_ayah'               => 'nullable|string|max:20',
            'pendidikan_terakhir_ayah'   => 'nullable|string|max:30',
            'pekerjaan_ayah'             => 'nullable|string|max:50',
            'penghasilan_ayah'           => 'nullable|numeric',
            'alamat_ayah'                => 'nullable|string',
            'nama_ibu'                   => 'required|string|max:60',
            'status_ibu'                 => 'required|string|max:20',
            'tgl_lahir_ibu'              => 'nullable|date',
            'telepon_ibu'                => 'nullable|string|max:20',
            'pendidikan_terakhir_ibu'    => 'nullable|string|max:30',
            'pekerjaan_ibu'              => 'nullable|string|max:50',
            'penghasilan_ibu'            => 'nullable|numeric',
            'alamat_ibu'                 => 'nullable|string',
            'nama_wali'                  => 'nullable|string|max:60',
            'status_wali'                => 'nullable|string|max:20',
            'tgl_lahir_wali'             => 'nullable|date',
            'telepon_wali'               => 'nullable|string|max:20',
            'pendidikan_terakhir_wali'   => 'nullable|string|max:30',
            'pekerjaan_wali'             => 'nullable|string|max:50',
            'penghasilan_wali'           => 'nullable|numeric',
            'alamat_wali'                => 'nullable|string',
        ]);

        $orangtum->update($validated);

        return redirect()->route('admin.orangtua.index')->with('success', 'Data orang tua/wali berhasil diperbarui!');
    }

    public function destroy(OrangTuaWali $orangtum)
    {
        $orangtum->delete();
        return redirect()->route('admin.orangtua.index')->with('success', 'Data orang tua/wali berhasil dihapus!');
    }
}
