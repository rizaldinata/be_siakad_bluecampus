<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MahasiswaApiController;
use App\Http\Controllers\api\dosen\DosenNilaiController;
use App\Http\Controllers\api\dosen\DosenJadwalController;
use App\Http\Controllers\api\mahasiswa\MahasiswaFrsController;
use App\Http\Controllers\api\mahasiswa\MahasiswaNilaiController;
use App\Http\Controllers\api\mahasiswa\MahasiswaJadwalController;


Route::post('/login', [AuthController::class, 'apiLogin']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'apiLogout']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/mahasiswa/frs/tersedia', [MahasiswaFrsController::class, 'listFrsBelumDiambil']);
    Route::get('/mahasiswa/frs/diambil', [MahasiswaFrsController::class, 'listFrsSudahDiambil']);
    Route::post('/mahasiswa/frs/ambil', [MahasiswaFrsController::class, 'ambilFrs']);
    Route::get('/mahasiswa/nilai', [MahasiswaNilaiController::class, 'index']);
    Route::get('/mahasiswa/jadwal', [MahasiswaJadwalController::class, 'index']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dosen/nilai', [DosenNilaiController::class, 'kelasList']);
    Route::get('/dosen/nilai/mahasiswa', [DosenNilaiController::class, 'mahasiswaList']);
    Route::get('/dosen/nilai/mahasiswa/{id}', [DosenNilaiController::class, 'detailMahasiswa']);
    Route::post('/dosen/nilai/mahasiswa/{id}/simpan', [DosenNilaiController::class, 'simpanNilai']);
    Route::get('/dosen/jadwal', [DosenJadwalController::class, 'index']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/mahasiswa', [MahasiswaApiController::class, 'index']);
    Route::get('/mahasiswa/{id}', [MahasiswaApiController::class, 'show']);
});