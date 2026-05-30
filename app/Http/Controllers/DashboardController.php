<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\IdentitasSiswa;
use App\Models\Administrasi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_admin'    => User::where('hak', 'admin')->count(),
            'total_pegawai'  => User::where('hak', 'pegawai')->count(),
            'total_pendaftar_tahun_ini' => IdentitasSiswa::whereYear('created_at', date('Y'))->count(),
            'total_pendaftar' => IdentitasSiswa::count(),
            'total_lunas'    => Administrasi::where('status', 'Lunas')->count(),
            'total_belum_lunas' => Administrasi::where('status', 'Belum Lunas')->count(),
            'pendaftar_laki' => IdentitasSiswa::where('jenis_kelamin', 'Laki-Laki')->count(),
            'pendaftar_perempuan' => IdentitasSiswa::where('jenis_kelamin', 'Perempuan')->count(),
        ];

        $pendaftar_terbaru = IdentitasSiswa::with('orangTuaWali', 'administrasi')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact('stats', 'pendaftar_terbaru'));
    }
}
