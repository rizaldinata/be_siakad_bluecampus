<?php

namespace App\Http\Controllers\api\mahasiswa;

use App\Models\Frs;
use App\Models\PaketFrs;
use App\Models\FrsMahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MahasiswaFrsController extends Controller
{
    public function listFrsBelumDiambil(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return response()->json(['status' => 'fail', 'message' => 'Data mahasiswa tidak ditemukan.'], 403);
        }

        $frsYangSudahDiambil = FrsMahasiswa::where('mahasiswa_id', $mahasiswa->id)->pluck('frs_id');

        $frsTersedia = Frs::with(['mataKuliah', 'paketFrs.tahunAjaran'])
            ->whereHas('paketFrs', function ($q) use ($mahasiswa) {
                $q->where('kelas_id', $mahasiswa->kelas_id);
            })
            ->whereNotIn('id', $frsYangSudahDiambil)
            ->get()
            ->map(function ($frs) {
                return [
                    'id' => $frs->id,
                    'mata_kuliah' => $frs->mataKuliah->nama,
                    'kode_matkul' => $frs->mataKuliah->kode_matkul,
                    'semester' => $frs->semester,
                    'tahun_ajaran' => $frs->paketFrs->tahunAjaran->nama_tahun_ajaran,
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'FRS yang tersedia berhasil diambil.',
            'data' => $frsTersedia
        ]);
    }

    public function listFrsSudahDiambil()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        $frsTerambil = FrsMahasiswa::with(['frs.mataKuliah', 'frs.paketFrs.tahunAjaran'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->get()
            ->map(function ($frsMhs) {
                return [
                    'id' => $frsMhs->frs->id,
                    'mata_kuliah' => $frsMhs->frs->mataKuliah->nama,
                    'kode_matkul' => $frsMhs->frs->mataKuliah->kode_matkul,
                    'semester' => $frsMhs->frs->semester,
                    'tahun_ajaran' => $frsMhs->frs->paketFrs->tahunAjaran->nama_tahun_ajaran,
                    'status_disetujui' => $frsMhs->status_disetujui,
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'FRS yang sudah diambil berhasil diambil.',
            'data' => $frsTerambil
        ]);
    }

    public function ambilFrs(Request $request)
    {
        $request->validate([
            'frs_id' => 'required|exists:frs,id',
        ]);

        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        $sudahAmbil = FrsMahasiswa::where('mahasiswa_id', $mahasiswa->id)
            ->where('frs_id', $request->frs_id)
            ->exists();

        if ($sudahAmbil) {
            return response()->json(['status' => 'fail', 'message' => 'FRS ini sudah diambil.'], 409);
        }

        FrsMahasiswa::create([
            'mahasiswa_id' => $mahasiswa->id,
            'frs_id' => $request->frs_id,
            'status_disetujui' => 'menunggu',
            'catatan' => '-',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'FRS berhasil diambil.'
        ]);
    }
}