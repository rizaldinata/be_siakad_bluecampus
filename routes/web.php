<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\web\AdminFrsController;
use App\Http\Controllers\web\AdminDosenController;
use App\Http\Controllers\web\AdminKelasController;
use App\Http\Controllers\web\AdminPaketFrsController;
use App\Http\Controllers\web\AdminDashboardController;
use App\Http\Controllers\web\AdminMahasiswaController;
use App\Http\Controllers\web\AdminMataKuliahController;

Route::get('/login', [AuthController::class, 'showWebLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'webLogin'])->name('web.login');
Route::post('/logout', [AuthController::class, 'webLogout'])->name('web.logout');

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // Route::get('/mahasiswa', [AdminMahasiswaController::class, 'index'])->name('admin.mahasiswa.index');
    Route::resource('/mahasiswa', AdminMahasiswaController::class)->names('admin.mahasiswa');
    Route::resource('/dosen', AdminDosenController::class)->names('admin.dosen');
    Route::resource('/kelas', AdminKelasController::class, ['parameters' => ['kelas' => 'kelas']])->names('admin.kelas');
    Route::resource('/frs', AdminFrsController::class, ['parameters' => ['frs' => 'frs']])->names('admin.frs');
    Route::resource('/mata-kuliah', AdminMataKuliahController::class)->names('admin.mata-kuliah');
    Route::resource('/paket-frs', AdminPaketFrsController::class)->names('admin.paket-frs');
});                 