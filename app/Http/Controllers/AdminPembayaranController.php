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

    public function midtransCallback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        
        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');
        $transactionStatus = $request->input('transaction_status');

        // Verify signature: SHA512(order_id + status_code + gross_amount + server_key)
        $localSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($localSignature !== $signatureKey) {
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        // Find pembayaran records under this payment_code (orderId)
        $payments = PembayaranPeserta::where('payment_code', $orderId)->get();

        if ($payments->isEmpty()) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $status = 'menunggu_konfirmasi';
        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $status = 'lunas';
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $status = 'ditolak';
        } elseif ($transactionStatus === 'pending') {
            $status = 'menunggu_konfirmasi';
        }

        foreach ($payments as $payment) {
            $payment->update([
                'status' => $status,
                'catatan' => 'Midtrans Status: ' . $transactionStatus . ' (' . date('Y-m-d H:i:s') . ')'
            ]);
        }

        // Sync student's overall status
        $siswa = $payments->first()->identitasSiswa;
        if ($siswa) {
            $siswa->syncOverallAdministrasiStatus();
        }

        return response()->json(['message' => 'Callback processed successfully']);
    }
}
