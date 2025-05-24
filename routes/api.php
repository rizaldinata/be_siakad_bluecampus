<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MahasiswaApiController;
use App\Http\Controllers\api\dosen\DosenJadwalController;
use App\Http\Controllers\api\mahasiswa\MahasiswaJadwalController;


Route::post('/login', [AuthController::class, 'apiLogin']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'apiLogout']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/mahasiswa/jadwal', [MahasiswaJadwalController::class, 'index']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dosen/jadwal', [DosenJadwalController::class, 'index']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/mahasiswa', [MahasiswaApiController::class, 'index']);
    Route::get('/mahasiswa/{id}', [MahasiswaApiController::class, 'show']);
});