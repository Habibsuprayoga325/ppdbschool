<?php

namespace App\Http\Controllers;

use App\Models\IdentitasSiswa;
use Illuminate\Http\Request;

class CetakController extends Controller
{
    public function index()
    {
        $siswa = IdentitasSiswa::with('orangTuaWali', 'administrasi')->latest()->get();
        return view('cetak.index', compact('siswa'));
    }

    public function kartu(IdentitasSiswa $siswum)
    {
        $siswum->load('orangTuaWali', 'administrasi');
        return view('cetak.kartu', ['siswa' => $siswum]);
    }
}
