<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\web\AdminFrsController;
use App\Http\Controllers\web\AdminDosenController;
use App\Http\Controllers\web\AdminKelasController;
use App\Http\Controllers\web\AdminNilaiController;
use App\Http\Controllers\web\AdminPaketFrsController;
use App\Http\Controllers\web\AdminDashboardController;
use App\Http\Controllers\web\AdminMahasiswaController;
use App\Http\Controllers\web\AdminMataKuliahController;
use App\Http\Controllers\web\AdminTahunAjaranController;
use App\Http\Controllers\web\AdminFrsMahasiswaController;
use App\Http\Controllers\web\AdminJadwalKuliahController;

Route::get('/login', [AuthController::class, 'showWebLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'webLogin'])->name('web.login');
Route::post('/logout', [AuthController::class, 'webLogout'])->name('web.logout');

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/mahasiswa', AdminMahasiswaController::class)->names('admin.mahasiswa');
    Route::resource('/dosen', AdminDosenController::class)->names('admin.dosen');
    Route::resource('/kelas', AdminKelasController::class, ['parameters' => ['kelas' => 'kelas']])->names('admin.kelas');
    Route::resource('/frs', AdminFrsController::class, ['parameters' => ['frs' => 'frs']])->names('admin.frs');
    Route::resource('/mata-kuliah', AdminMataKuliahController::class)->names('admin.mata-kuliah');
    Route::resource('/paket-frs', AdminPaketFrsController::class, ['parameters' => ['paket-frs' => 'paket-frs']])->names('admin.paket-frs');
    Route::resource('/jadwal-kuliah', AdminJadwalKuliahController::class)->names('admin.jadwal-kuliah');
    Route::resource('/nilai', AdminNilaiController::class)->names('admin.nilai');
    Route::resource('/frs-mahasiswa', AdminFrsMahasiswaController::class)->names('admin.frs-mahasiswa');
    Route::resource('/tahun-ajaran', AdminTahunAjaranController::class)->names('admin.tahun-ajaran');
});                 