<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Service / Profile
Route::get('/layanan/{id}', [ServiceController::class, 'show'])->name('layanan.show');

// Freelancer
Route::middleware('auth')->group(function () {
    Route::get('/mulai-freelancer', [FreelancerController::class, 'mulai'])->name('freelancer.mulai');
    Route::get('/daftar-freelancer', [FreelancerController::class, 'daftar'])->name('freelancer.daftar');
    Route::post('/daftar-freelancer', [FreelancerController::class, 'storePengajuan']);
    Route::get('/kelola-jasa', [FreelancerController::class, 'kelola'])->name('freelancer.kelola');
    Route::post('/kelola-jasa', [FreelancerController::class, 'storeLayanan']);
});

// Booking
Route::middleware('auth')->group(function () {
    Route::get('/ringkasan-pesanan', [BookingController::class, 'ringkasan'])->name('booking.ringkasan');
    Route::post('/ringkasan-pesanan', [BookingController::class, 'store']);
    Route::get('/pesanan', [BookingController::class, 'pesanan'])->name('booking.pesanan');
    Route::get('/riwayat-pesanan', [BookingController::class, 'riwayat'])->name('booking.riwayat');
    Route::post('/pesanan/ulasan', [BookingController::class, 'storeUlasan'])->name('booking.ulasan');
    Route::post('/pesanan/status', [BookingController::class, 'updateStatus'])->name('booking.status');

    // Pengaturan Akun
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
        Route::get('/informasi', [App\Http\Controllers\ProfileController::class, 'informasi'])->name('informasi');
        Route::post('/informasi', [App\Http\Controllers\ProfileController::class, 'updateInformasi']);
        
        Route::get('/kontak', [App\Http\Controllers\ProfileController::class, 'kontak'])->name('kontak');
        Route::post('/kontak', [App\Http\Controllers\ProfileController::class, 'updateKontak']);
        
        Route::get('/keamanan', [App\Http\Controllers\ProfileController::class, 'keamanan'])->name('keamanan');
        Route::post('/keamanan/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('keamanan.password');
        Route::post('/keamanan/hapus', [App\Http\Controllers\ProfileController::class, 'hapusAkun'])->name('keamanan.hapus');
    });
});

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin login using AuthController instead of AdminController to avoid duplicate logic
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'loginAdmin'])->name('login')->middleware('guest');
    
    // Protected admin routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Pengguna
        Route::get('/pengguna', [AdminController::class, 'pengguna'])->name('pengguna');
        Route::post('/pengguna', [AdminController::class, 'storePengguna'])->name('pengguna.store');
        Route::put('/pengguna/{id}', [AdminController::class, 'updatePengguna'])->name('pengguna.update');
        Route::delete('/pengguna/{id}', [AdminController::class, 'destroyPengguna'])->name('pengguna.destroy');
        
        // Freelancer
        Route::get('/freelancer', [AdminController::class, 'freelancer'])->name('freelancer');
        Route::post('/freelancer/{id}/revoke', [AdminController::class, 'revokeFreelancer'])->name('freelancer.revoke');
        
        // Booking
        Route::get('/booking', [AdminController::class, 'booking'])->name('booking');
        Route::delete('/booking/{id}', [AdminController::class, 'destroyBooking'])->name('booking.destroy');
        
        // Pengajuan
        Route::get('/pengajuan', [AdminController::class, 'pengajuan'])->name('pengajuan');
        Route::post('/pengajuan/verifikasi', [AdminController::class, 'verifikasiPengajuan'])->name('pengajuan.verifikasi');
        
        // Kelola Kategori & Jasa
        Route::get('/kelola', [AdminController::class, 'kelola'])->name('kelola');
        Route::post('/kelola/kategori', [AdminController::class, 'storeKategori'])->name('kelola.kategori');
        Route::put('/kelola/kategori/{id}', [AdminController::class, 'updateKategori'])->name('kelola.kategori.update');
        Route::delete('/kelola/kategori/{id}', [AdminController::class, 'destroyKategori'])->name('kelola.kategori.destroy');
        Route::post('/kelola/jasa', [AdminController::class, 'storeJasa'])->name('kelola.jasa');
        Route::put('/kelola/jasa/{id}', [AdminController::class, 'updateJasa'])->name('kelola.jasa.update');
        Route::delete('/kelola/jasa/{id}', [AdminController::class, 'destroyJasa'])->name('kelola.jasa.destroy');
    });
});
