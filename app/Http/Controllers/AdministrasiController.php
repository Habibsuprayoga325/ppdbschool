<?php

namespace App\Http\Controllers;

use App\Models\Administrasi;
use App\Models\IdentitasSiswa;
use Illuminate\Http\Request;

class AdministrasiController extends Controller
{
    public function index()
    {
        $administrasi = Administrasi::with('identitasSiswa')->latest()->get();
        return view('administrasi.index', compact('administrasi'));
    }

    public function create()
    {
        $siswa = IdentitasSiswa::whereDoesntHave('administrasi')->get();
        return view('administrasi.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'identitas_siswa_id' => 'required|exists:identitas_siswa,id|unique:administrasi,identitas_siswa_id',
            'harga'              => 'required|numeric|min:0',
            'status'             => 'required|in:Lunas,Belum Lunas',
            'keterangan'         => 'nullable|string',
        ], [
            'identitas_siswa_id.required' => 'Siswa wajib dipilih!',
            'identitas_siswa_id.unique'   => 'Data administrasi siswa ini sudah ada!',
            'harga.required'              => 'Nominal biaya wajib diisi!',
        ]);

        Administrasi::create($validated);

        return redirect()->route('admin.administrasi.index')->with('success', 'Data administrasi berhasil ditambahkan!');
    }

    public function edit(Administrasi $administrasi)
    {
        $administrasi->load('identitasSiswa');
        $siswa = IdentitasSiswa::all();
        return view('administrasi.edit', compact('administrasi', 'siswa'));
    }

    public function update(Request $request, Administrasi $administrasi)
    {
        $validated = $request->validate([
            'harga'      => 'required|numeric|min:0',
            'status'     => 'required|in:Lunas,Belum Lunas',
            'keterangan' => 'nullable|string',
        ]);

        $administrasi->update($validated);

        return redirect()->route('admin.administrasi.index')->with('success', 'Data administrasi berhasil diperbarui!');
    }

    public function destroy(Administrasi $administrasi)
    {
        $administrasi->delete();
        return redirect()->route('admin.administrasi.index')->with('success', 'Data administrasi berhasil dihapus!');
    }
}
