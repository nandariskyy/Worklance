<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HistoryController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

// Service / Profile
Route::get('/layanan/{id}', [ServiceController::class, 'show'])->name('layanan.show');

// Freelancer
Route::get('/mulai-freelancer', [FreelancerController::class, 'mulai'])->name('freelancer.mulai');
Route::get('/daftar-freelancer', [FreelancerController::class, 'daftar'])->name('freelancer.daftar');
Route::get('/kelola-jasa', [FreelancerController::class, 'kelola'])->name('freelancer.kelola');

// Booking
Route::get('/ringkasan-pesanan', [BookingController::class, 'ringkasan'])->name('booking.ringkasan');
Route::get('/pesanan', [BookingController::class, 'pesanan'])->name('booking.pesanan');

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pengguna', [AdminController::class, 'pengguna'])->name('pengguna');
    Route::get('/freelancer', [AdminController::class, 'freelancer'])->name('freelancer');
    Route::get('/booking', [AdminController::class, 'booking'])->name('booking');
    Route::get('/pengajuan', [AdminController::class, 'pengajuan'])->name('pengajuan');
    Route::get('/kelola', [AdminController::class, 'kelola'])->name('kelola');
});

// Riwayat
Route::get('/history', [HistoryController::class, 'index']);
