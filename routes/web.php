<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminPembayaranController;

// =============================
// PUBLIC ROUTES (Tanpa Login)
// =============================
Route::get('/', [PublicController::class, 'index'])->name('public.index');
Route::get('/daftar-siswa', [PublicController::class, 'daftarSiswa'])->name('public.daftar-siswa');
Route::post('/daftar-siswa', [PublicController::class, 'storeSiswa'])->name('public.store-siswa');
Route::get('/daftar-ortu', [PublicController::class, 'daftarOrtu'])->name('public.daftar-ortu');
Route::post('/daftar-ortu', [PublicController::class, 'storeOrtu'])->name('public.store-ortu');
Route::post('/midtrans/callback', [AdminPembayaranController::class, 'midtransCallback'])->name('midtrans.callback');
Route::get('/syarat-ketentuan', [PublicController::class, 'syaratKetentuan'])->name('public.syarat-ketentuan');
Route::get('/kebijakan-pengembalian', [PublicController::class, 'kebijakanPengembalian'])->name('public.kebijakan-pengembalian');

// =============================
// AUTH ROUTES
// =============================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// =============================
// ADMIN PANEL ROUTES (Perlu Login)
// =============================
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Siswa
    Route::resource('siswa', SiswaController::class)->parameters([
        'siswa' => 'siswum'
    ]);

    // Data Orang Tua/Wali
    Route::resource('orangtua', OrangTuaController::class)->parameters([
        'orangtua' => 'orangtum'
    ]);

    // Administrasi
    Route::resource('administrasi', AdministrasiController::class);

    // Verifikasi Pembayaran
    Route::get('/pembayaran', [AdminPembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/{payment_code}/konfirmasi', [AdminPembayaranController::class, 'konfirmasi'])->name('pembayaran.konfirmasi');
    Route::post('/pembayaran/{payment_code}/tolak', [AdminPembayaranController::class, 'tolak'])->name('pembayaran.tolak');

    // Cetak Kartu
    Route::get('/cetak', [CetakController::class, 'index'])->name('cetak.index');
    Route::get('/cetak/{siswum}', [CetakController::class, 'kartu'])->name('cetak.kartu');

    // Manajemen User (Admin only)
    Route::resource('user', UserController::class)->middleware('admin');
});

// Redirect /dashboard ke /admin/dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('dashboard');

// =============================
// PARTICIPANT AUTH & DASHBOARD
// =============================
use App\Http\Controllers\Auth\PesertaAuthController;
use App\Http\Controllers\PesertaDashboardController;

Route::get('/peserta/login', [PesertaAuthController::class, 'showLoginForm'])->name('peserta.login');
Route::post('/peserta/login', [PesertaAuthController::class, 'login'])->name('peserta.login.post');
Route::post('/peserta/logout', [PesertaAuthController::class, 'logout'])->name('peserta.logout');

Route::middleware('peserta')->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/dashboard', [PesertaDashboardController::class, 'index'])->name('dashboard');
    Route::post('/siswa/update', [PesertaDashboardController::class, 'updateSiswa'])->name('siswa.update');
    Route::post('/orangtua/update', [PesertaDashboardController::class, 'updateOrangTua'])->name('orangtua.update');
    Route::get('/cetak', [PesertaDashboardController::class, 'cetakKartu'])->name('cetak');
    Route::post('/pembayaran', [PesertaDashboardController::class, 'storePembayaran'])->name('pembayaran.store');
    Route::post('/pembayaran/initiate', [PesertaDashboardController::class, 'initiatePembayaran'])->name('pembayaran.initiate');
    Route::post('/pembayaran/simulate-success', [PesertaDashboardController::class, 'simulatePaymentSuccess'])->name('pembayaran.simulate-success');
});
