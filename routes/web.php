<?php

use App\Http\Controllers\AnggaranSppdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SppdController;
use App\Http\Controllers\SptController;
use App\Http\Controllers\TujuanTugasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifikasiSppdController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/', fn () => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth', 'role'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // API endpoints for Select2
    Route::get('/api/pegawai/search', [PegawaiController::class, 'apiSearch'])->name('api.pegawai.search');
    Route::get('/api/pegawai/pejabat', [PegawaiController::class, 'apiPejabat'])->name('api.pegawai.pejabat');
    Route::get('/api/tujuan-tugas/search', [TujuanTugasController::class, 'apiSearch'])->name('api.tujuan-tugas.search');
    Route::get('/api/spt/{spt}/pengikut', [SppdController::class, 'getSptPengikut'])->name('api.spt.pengikut');

    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('tujuan-tugas', TujuanTugasController::class)->except(['show']);
    });

    // Admin & Pejabat
    Route::middleware('role:admin,pejabat')->group(function () {
        Route::resource('spt', SptController::class);
        Route::patch('/spt/{spt}/status', [SptController::class, 'updateStatus'])->name('spt.update-status');
    });

    // Admin, Pejabat & Pegawai
    Route::middleware('role:admin,pejabat,pegawai')->group(function () {
        Route::resource('sppd', SppdController::class);
        Route::patch('/sppd/{sppd}/ajukan', [SppdController::class, 'ajukanVerifikasi'])->name('sppd.ajukan');

        // Anggaran SPPD
        Route::get('/sppd/{sppd}/anggaran/create', [AnggaranSppdController::class, 'create'])->name('anggaran-sppd.create');
        Route::post('/sppd/{sppd}/anggaran', [AnggaranSppdController::class, 'store'])->name('anggaran-sppd.store');
        Route::get('/sppd/{sppd}/anggaran/edit', [AnggaranSppdController::class, 'edit'])->name('anggaran-sppd.edit');
        Route::put('/sppd/{sppd}/anggaran', [AnggaranSppdController::class, 'update'])->name('anggaran-sppd.update');
    });

    // Verifikator
    Route::middleware('role:admin,verifikator')->group(function () {
        Route::get('/verifikasi', [VerifikasiSppdController::class, 'index'])->name('verifikasi.index');
        Route::get('/verifikasi/{sppd}', [VerifikasiSppdController::class, 'show'])->name('verifikasi.show');
        Route::post('/verifikasi/{sppd}', [VerifikasiSppdController::class, 'verifikasi'])->name('verifikasi.store');
        Route::patch('/verifikasi/{sppd}/selesai', [VerifikasiSppdController::class, 'selesai'])->name('verifikasi.selesai');
    });

    // PDF - accessible by all authenticated users
    Route::get('/cetak/spt-rekap', [PdfController::class, 'cetakRekapSpt'])->name('cetak.spt.rekap');
    Route::get('/spt-cetak', [PdfController::class, 'cetakRekapSpt'])->name('spt.cetak');
    Route::get('/cetak/sppd-rekap', [PdfController::class, 'cetakRekapSppd'])->name('cetak.sppd.rekap');
    Route::get('/cetak/verifikasi-rekap', [PdfController::class, 'cetakRekapVerifikasi'])->name('cetak.verifikasi.rekap');
    Route::get('/cetak/spt/{spt}', [PdfController::class, 'cetakSpt'])->name('cetak.spt');
    Route::get('/cetak/sppd/{sppd}', [PdfController::class, 'cetakSppd'])->name('cetak.sppd');
    Route::get('/cetak/kuitansi/{sppd}', [PdfController::class, 'cetakKuitansi'])->name('cetak.kuitansi');
});
