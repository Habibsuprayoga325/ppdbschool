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
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'catatan' => 'nullable|string|max:1000',
        ], [
            'items.required' => 'Pilih minimal satu item pembayaran!',
            'payment_proof.required' => 'Bukti pembayaran wajib diunggah!',
            'payment_proof.file' => 'Bukti pembayaran tidak valid!',
            'payment_proof.mimes' => 'Format bukti pembayaran harus JPG, JPEG, atau PNG!',
            'payment_proof.max' => 'Ukuran bukti pembayaran maksimal 2MB!',
        ]);

        foreach ($request->items as $itemId) {
            $hasActivePayment = $siswa->pembayaranPeserta()
                ->where('administrasi_item_id', $itemId)
                ->whereIn('status', ['menunggu_verifikasi', 'lunas'])
                ->exists();

            if ($hasActivePayment) {
                $item = \App\Models\AdministrasiItem::find($itemId);
                return back()->withErrors(['items' => 'Item "' . $item->nama . '" sudah memiliki transaksi aktif!']);
            }
        }

        $file = $request->file('payment_proof');

        try {
            $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $image = $manager->read($file);
            $webpData = $image->toWebp(75);

            $tempPath = tempnam(sys_get_temp_dir(), 'qris_') . '.webp';
            file_put_contents($tempPath, $webpData);

            $cleanNoPendaftaran = str_replace(['-', '/'], '_', $siswa->no_pendaftaran);
            $customFilename = "bukti_qris_PPDB_{$cleanNoPendaftaran}_" . time();

            $cloudinary = new \Cloudinary\Cloudinary([
                'cloud' => [
                    'cloud_name' => config('services.cloudinary.cloud_name'),
                    'api_key'    => config('services.cloudinary.api_key'),
                    'api_secret' => config('services.cloudinary.api_secret'),
                ]
            ]);

            $uploadResult = $cloudinary->uploadApi()->upload($tempPath, [
                'folder' => 'ppdb_qris_pembayaran',
                'public_id' => $customFilename,
            ]);

            $secureUrl = $uploadResult['secure_url'];

            @unlink($tempPath);
        } catch (\Exception $e) {
            return back()->withErrors(['payment_proof' => 'Gagal memproses dan mengunggah bukti pembayaran: ' . $e->getMessage()]);
        }

        $paymentCode = 'PAY-' . date('YmdHis') . '-' . mt_rand(1000, 9999);

        foreach ($request->items as $itemId) {
            \App\Models\PembayaranPeserta::create([
                'identitas_siswa_id' => $siswa->id,
                'administrasi_item_id' => $itemId,
                'payment_code' => $paymentCode,
                'payment_proof' => $secureUrl,
                'catatan' => $request->catatan,
                'status' => 'menunggu_verifikasi',
            ]);
        }

        $siswa->syncOverallAdministrasiStatus();

        return redirect()->route('peserta.dashboard')
            ->with('success', 'Bukti pembayaran berhasil dikompresi, dikonversi, dan diunggah ke Cloud Storage! Sedang menunggu verifikasi panitia.');
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
