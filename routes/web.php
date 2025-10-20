<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;


// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('login');
    Route::match(['get', 'post'], 'register', [AuthController::class, 'register'])->name('register');
    Route::match(['get', 'post'], 'forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::match(['get', 'post'], 'reset-password/{email}', [AuthController::class, 'resetPassword'])->name('resetPassword');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('absen', App\Http\Controllers\AbsenController::class);
    Route::resource('kegiatan', App\Http\Controllers\KegiatanController::class);
    Route::resource('mahasiswa', App\Http\Controllers\MahasiswaController::class);
    Route::resource('laporan', App\Http\Controllers\LaporanController::class)->parameters([
        'laporan' => 'laporan:id_laporan'
    ]);
    Route::resource('nilai_index', App\Http\Controllers\NilaiIndexController::class);
    Route::resource('sertifikat', App\Http\Controllers\SertifikatController::class);

    Route::delete('/laporan/{laporan}', [LaporanController::class, 'destroy'])->name('laporan.destroy');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::match(['get', 'post'], 'change-password', [AuthController::class, 'changePassword'])->name('change-password');

    // Admin-only routes

});

require __DIR__.'/profile.php';
