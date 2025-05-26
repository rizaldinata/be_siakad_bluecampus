<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\FilterHelper;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MahasiswaApiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return response()->json(['message' => 'Admin tidak diizinkan.'], 403);
        }

        if ($user->role === 'mahasiswa') {
            // Ambil data mahasiswa yang login beserta semua relasi penting
            $mahasiswa = Mahasiswa::with([
                'kelas',
                'dosenWali',
                'frsMahasiswa.frs.matkul',
                'frsMahasiswa.frs.dosen',
                'frsMahasiswa.nilai'
            ])->where('user_id', $user->id)->first();

            if (!$mahasiswa) {
                return response()->json(['message' => 'Data mahasiswa tidak ditemukan.'], 404);
            }

            return response()->json($mahasiswa);
        }

        if ($user->role === 'dosen') {
            // Dosen bisa melihat semua mahasiswa
            $mahasiswaList = Mahasiswa::with(['kelas', 'dosenWali'])->get();

            return response()->json($mahasiswaList);
        }

        return response()->json(['message' => 'Role tidak dikenali.'], 403);
    }

    public function show($id)
    {
        $user = Auth::user();

        $mahasiswa = Mahasiswa::with([
            'kelas',
            'dosenWali',
            'frsMahasiswa.frs.matkul',
            'frsMahasiswa.frs.dosen',
            'frsMahasiswa.nilai'
        ])->findOrFail($id);

        if ($user->role === 'mahasiswa' && $mahasiswa->user_id !== $user->id) {
            return response()->json(['message' => 'Tidak boleh melihat data mahasiswa lain.'], 403);
        }

        if ($user->role === 'admin') {
            return response()->json(['message' => 'Admin tidak diizinkan.'], 403);
        }

        return response()->json($mahasiswa);
    }
}