<?php

namespace App\Http\Controllers;

use App\Models\IdentitasSiswa;
use App\Models\OrangTuaWali;
use Illuminate\Http\Request;

class PesertaDashboardController extends Controller
{
    public function index()
    {
        $id = session('peserta_id');
        $siswa = IdentitasSiswa::with(['orangTuaWali', 'administrasi', 'pembayaranPeserta.administrasiItem'])->findOrFail($id);
        $items = \App\Models\AdministrasiItem::all();
        return view('peserta.dashboard', compact('siswa', 'items'));
    }

    public function storePembayaran(Request $request)
    {
        $id = session('peserta_id');
        $siswa = IdentitasSiswa::findOrFail($id);

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*' => 'required|exists:administrasi_items,id',
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'catatan' => 'nullable|string|max:1000',
        ], [
            'items.required' => 'Pilih minimal satu item pembayaran!',
            'bukti_bayar.required' => 'Bukti pembayaran wajib diunggah!',
            'bukti_bayar.file' => 'Bukti pembayaran tidak valid!',
            'bukti_bayar.mimes' => 'Format bukti pembayaran harus JPG, JPEG, PNG, atau PDF!',
            'bukti_bayar.max' => 'Ukuran bukti pembayaran maksimal 2MB!',
        ]);

        // Validate active payments
        foreach ($request->items as $itemId) {
            $hasActivePayment = $siswa->pembayaranPeserta()
                ->where('administrasi_item_id', $itemId)
                ->whereIn('status', ['menunggu_konfirmasi', 'lunas'])
                ->exists();

            if ($hasActivePayment) {
                $item = \App\Models\AdministrasiItem::find($itemId);
                return back()->withErrors(['items' => 'Item "' . $item->nama . '" sudah memiliki transaksi aktif!']);
            }
        }

        // Store file
        $file = $request->file('bukti_bayar');
        $path = $file->store('bukti_pembayaran', 'public');

        // Generate payment code
        $paymentCode = 'PAY-' . date('YmdHis') . '-' . mt_rand(1000, 9999);

        // Create payments
        foreach ($request->items as $itemId) {
            \App\Models\PembayaranPeserta::create([
                'identitas_siswa_id' => $siswa->id,
                'administrasi_item_id' => $itemId,
                'payment_code' => $paymentCode,
                'bukti_bayar' => $path,
                'catatan' => $request->catatan,
                'status' => 'menunggu_konfirmasi',
            ]);
        }

        // Sync student's overall status
        $siswa->syncOverallAdministrasiStatus();

        return redirect()->route('peserta.dashboard')
            ->with('success', 'Bukti pembayaran berhasil diunggah dan sedang menunggu konfirmasi panitia!');
    }

    public function updateSiswa(Request $request)
    {
        $id = session('peserta_id');
        $siswa = IdentitasSiswa::findOrFail($id);

        $validated = $request->validate([
            'nisn'               => 'required|string|max:15|unique:identitas_siswa,nisn,' . $id,
            'no_kk'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto_akta'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'nik'                => 'required|string|max:16|unique:identitas_siswa,nik,' . $id,
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
            'nisn.unique'    => 'NISN sudah terdaftar!',
            'nik.unique'     => 'NIK sudah terdaftar!',
            'nama_peserta_didik.required' => 'Nama lengkap siswa wajib diisi!',
            'jenis_kelamin.required'      => 'Jenis kelamin wajib dipilih!',
            'no_kk.file'     => 'File Kartu Keluarga tidak valid!',
            'no_kk.mimes'    => 'Format Kartu Keluarga harus JPG, JPEG, PNG, atau PDF!',
            'no_kk.max'      => 'Ukuran Kartu Keluarga maksimal 2MB!',
            'foto_akta.file'     => 'File Akta Kelahiran tidak valid!',
            'foto_akta.mimes'    => 'Format Akta Kelahiran harus JPG, JPEG, PNG, atau PDF!',
            'foto_akta.max'      => 'Ukuran Akta Kelahiran maksimal 2MB!',
        ]);

        $data = $request->except(['no_kk', 'foto_akta']);

        if ($request->hasFile('no_kk')) {
            if ($siswa->no_kk) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($siswa->no_kk);
            }
            $data['no_kk'] = $request->file('no_kk')->store('kartu_keluarga', 'public');
        }

        if ($request->hasFile('foto_akta')) {
            if ($siswa->foto_akta) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($siswa->foto_akta);
            }
            $data['foto_akta'] = $request->file('foto_akta')->store('akta_kelahiran', 'public');
        }

        $siswa->update($data);

        // Update session name if changed
        session(['peserta_nama' => $siswa->nama_peserta_didik]);

        return redirect()->route('peserta.dashboard')
            ->with('success', 'Data identitas Anda berhasil diperbarui!');
    }

    public function initiatePembayaran(Request $request, \App\Services\MidtransService $midtransService)
    {
        $id = session('peserta_id');
        $siswa = IdentitasSiswa::findOrFail($id);

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*' => 'required|exists:administrasi_items,id',
        ]);

        // Validate that none of the selected items are already lunas
        foreach ($request->items as $itemId) {
            $isLunas = $siswa->pembayaranPeserta()
                ->where('administrasi_item_id', $itemId)
                ->where('status', 'lunas')
                ->exists();

            if ($isLunas) {
                $item = \App\Models\AdministrasiItem::find($itemId);
                return response()->json(['error' => 'Item "' . $item->nama . '" sudah lunas!'], 422);
            }
        }

        // Clean up any old unpaid Midtrans transactions for the selected items to prevent duplicates
        $siswa->pembayaranPeserta()
            ->whereIn('administrasi_item_id', $request->items)
            ->where('status', 'menunggu_konfirmasi')
            ->whereNull('bukti_bayar')
            ->delete();

        // Calculate total nominal
        $items = \App\Models\AdministrasiItem::whereIn('id', $request->items)->get();
        $totalNominal = $items->sum('nominal');

        // Generate payment code
        $paymentCode = 'PAY-MID-' . date('YmdHis') . '-' . mt_rand(1000, 9999);

        // Build Midtrans Payload
        $transaction_details = [
            'order_id' => $paymentCode,
            'gross_amount' => $totalNominal,
        ];

        $item_details = [];
        foreach ($items as $item) {
            $item_details[] = [
                'id' => $item->id,
                'price' => $item->nominal,
                'quantity' => 1,
                'name' => substr($item->nama, 0, 50),
            ];
        }

        $customer_details = [
            'first_name' => $siswa->nama_peserta_didik,
            'email' => $siswa->nisn . '@ppdb-online.test',
            'phone' => $siswa->orangTuaWali?->telepon_ayah ?: '081234567890',
        ];

        $payload = [
            'transaction_details' => $transaction_details,
            'item_details' => $item_details,
            'customer_details' => $customer_details,
        ];

        $snapToken = null;
        $isSimulation = config('services.midtrans.simulation', true);

        if (!$isSimulation) {
            $snapToken = $midtransService->getSnapToken($payload);
        }

        if (!$snapToken) {
            // Fallback to simulation mode if API call fails or simulation is true
            $snapToken = 'DUMMY-TOKEN-' . $paymentCode;
            $isSimulation = true;
        }

        // Create pembayaran_peserta records
        foreach ($request->items as $itemId) {
            \App\Models\PembayaranPeserta::create([
                'identitas_siswa_id' => $siswa->id,
                'administrasi_item_id' => $itemId,
                'payment_code' => $paymentCode,
                'bukti_bayar' => null,
                'catatan' => $isSimulation ? 'Simulasi Pembayaran (Dummy Mode)' : 'Midtrans Snap Token: ' . $snapToken,
                'status' => 'menunggu_konfirmasi',
            ]);
        }

        return response()->json([
            'token' => $snapToken,
            'payment_code' => $paymentCode,
            'is_simulation' => $isSimulation
        ]);
    }

    public function simulatePaymentSuccess(Request $request)
    {
        $id = session('peserta_id');
        $siswa = IdentitasSiswa::findOrFail($id);

        $request->validate([
            'payment_code' => 'required|string',
        ]);

        $payments = \App\Models\PembayaranPeserta::where('identitas_siswa_id', $siswa->id)
            ->where('payment_code', $request->payment_code)
            ->get();

        if ($payments->isEmpty()) {
            return response()->json(['error' => 'Transaksi tidak ditemukan!'], 404);
        }

        foreach ($payments as $payment) {
            $payment->update([
                'status' => 'lunas',
                'catatan' => 'Lunas (Simulasi Mandiri oleh Peserta)',
            ]);
        }

        // Sync student's overall status
        $siswa->syncOverallAdministrasiStatus();

        return response()->json(['success' => true]);
    }

    public function updateOrangTua(Request $request)
    {
        $id = session('peserta_id');
        $siswa = IdentitasSiswa::findOrFail($id);

        $validated = $request->validate([
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

        $validated['identitas_siswa_id'] = $siswa->id;

        if ($siswa->orangTuaWali) {
            $siswa->orangTuaWali->update($validated);
        } else {
            OrangTuaWali::create($validated);
            $siswa->update(['status_ortu' => true]);
        }

        return redirect()->route('peserta.dashboard')
            ->with('success', 'Data orang tua / wali berhasil diperbarui!');
    }

    public function cetakKartu()
    {
        $id = session('peserta_id');
        $siswa = IdentitasSiswa::with('orangTuaWali', 'administrasi')->findOrFail($id);
        return view('cetak.kartu', compact('siswa'));
    }
}
