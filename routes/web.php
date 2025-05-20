<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\web\AdminDashboardController;
use App\Http\Controllers\web\AdminMahasiswaController;

Route::get('/login', [AuthController::class, 'showWebLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'webLogin'])->name('web.login');
Route::post('/logout', [AuthController::class, 'webLogout'])->name('web.logout');

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/mahasiswa', [AdminMahasiswaController::class, 'index'])->name('admin.mahasiswa.index');
});                 