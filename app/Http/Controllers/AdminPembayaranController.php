<?php

namespace App\Http\Controllers;

use App\Models\PembayaranPeserta;
use Illuminate\Http\Request;

class AdminPembayaranController extends Controller
{
    public function index()
    {
        // Get all transactions grouped by payment_code
        $pembayaranGroups = PembayaranPeserta::with(['identitasSiswa', 'administrasiItem'])
            ->latest()
            ->get()
            ->groupBy('payment_code');

        return view('pembayaran.index', compact('pembayaranGroups'));
    }

    public function konfirmasi($payment_code)
    {
        $payments = PembayaranPeserta::where('payment_code', $payment_code)->get();

        if ($payments->isEmpty()) {
            return back()->with('error', 'Transaksi tidak ditemukan!');
        }

        foreach ($payments as $payment) {
            $payment->update(['status' => 'lunas']);
        }

        // Sync student's overall status
        $siswa = $payments->first()->identitasSiswa;
        $siswa->syncOverallAdministrasiStatus();

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi Lunas!');
    }

    public function tolak($payment_code)
    {
        $payments = PembayaranPeserta::where('payment_code', $payment_code)->get();

        if ($payments->isEmpty()) {
            return back()->with('error', 'Transaksi tidak ditemukan!');
        }

        foreach ($payments as $payment) {
            $payment->update(['status' => 'ditolak']);
        }

        // Sync student's overall status
        $siswa = $payments->first()->identitasSiswa;
        $siswa->syncOverallAdministrasiStatus();

        return back()->with('success', 'Pembayaran berhasil ditolak!');
    }
}
