<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\IdentitasSiswa;
use Illuminate\Http\Request;

class PesertaAuthController extends Controller
{
    public function showLoginForm()
    {
        if (session()->has('peserta_id')) {
            return redirect()->route('peserta.dashboard');
        }
        return view('auth.login_peserta');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'nisn'          => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
        ], [
            'nisn.required'          => 'Nomor NISN wajib diisi!',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi!',
            'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid!',
        ]);

        $peserta = IdentitasSiswa::where('nisn', $validated['nisn'])
            ->whereDate('tanggal_lahir', $validated['tanggal_lahir'])
            ->first();

        if ($peserta) {
            session([
                'peserta_id'   => $peserta->id,
                'peserta_nisn' => $peserta->nisn,
                'peserta_nama' => $peserta->nama_peserta_didik,
            ]);

            return redirect()->route('peserta.dashboard')
                ->with('success', 'Selamat datang kembali, ' . $peserta->nama_peserta_didik . '!');
        }

        return back()->withErrors([
            'nisn' => 'NISN atau Tanggal Lahir salah!',
        ])->withInput($request->only('nisn'));
    }

    public function logout(Request $request)
    {
        session()->forget(['peserta_id', 'peserta_nisn', 'peserta_nama']);
        return redirect()->route('public.index')->with('success', 'Anda telah berhasil keluar dari dashboard peserta.');
    }
}
