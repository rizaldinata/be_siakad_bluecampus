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

        // Ambil dari query string
        $tahunAjaranName = $request->query('tahun_ajaran'); // contoh: "2023/2024"
        $semesterStr = $request->query('semester'); // "ganjil" / "genap"

        $semester = null;
        if ($semesterStr === 'ganjil') $semester = 1;
        elseif ($semesterStr === 'genap') $semester = 2;

        // Ambil id tahun ajaran dari nama_tahun_ajaran
        $tahunAjaranId = null;
        if ($tahunAjaranName) {
            $tahunAjaranId = \App\Models\TahunAjaran::where('nama_tahun_ajaran', $tahunAjaranName)->value('id');
        }

        $frsYangSudahDiambil = FrsMahasiswa::where('mahasiswa_id', $mahasiswa->id)->pluck('frs_id');

        $frsTersedia = Frs::with(['mataKuliah', 'paketFrs.tahunAjaran', 'dosen'])
            ->whereHas('paketFrs', function ($q) use ($mahasiswa, $tahunAjaranId) {
                $q->where('kelas_id', $mahasiswa->kelas_id);

                if ($tahunAjaranId) {
                    $q->where('tahun_ajaran_id', $tahunAjaranId);
                }
            })
            ->when($semester, function ($q) use ($semester) {
                $q->where('semester', $semester);
            })
            ->whereNotIn('id', $frsYangSudahDiambil)
            ->get()
            ->map(function ($frs) {
                return [
                    'id' => $frs->id,
                    'mata_kuliah' => $frs->mataKuliah->nama,
                    'kode_matkul' => $frs->mataKuliah->kode_matkul,
                    'sks' => $frs->mataKuliah->sks,
                    'semester' => $frs->semester,
                    'tahun_ajaran' => $frs->paketFrs->tahunAjaran->nama_tahun_ajaran,
                    'dosen' => $frs->dosen->nama,
                    'hari' => $frs->hari,
                    'jam_mulai' => $frs->jam_mulai,
                    'jam_selesai' => $frs->jam_selesai,
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'FRS yang tersedia berhasil difilter.',
            'data' => $frsTersedia
        ]);
    }

    public function listFrsSudahDiambil(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // Ambil dari query string
        $tahunAjaranName = $request->query('tahun_ajaran'); // contoh: "2023/2024"
        $semesterStr = $request->query('semester'); // "ganjil" / "genap"

        // Mapping semester ke angka
        $semester = null;
        if ($semesterStr === 'ganjil') $semester = 1;
        elseif ($semesterStr === 'genap') $semester = 2;

        // Ambil id tahun ajaran dari nama
        $tahunAjaranId = null;
        if ($tahunAjaranName) {
            $tahunAjaranId = \App\Models\TahunAjaran::where('nama_tahun_ajaran', $tahunAjaranName)->value('id');
        }

        $frsTerambil = FrsMahasiswa::with(['frs.mataKuliah', 'frs.paketFrs.tahunAjaran', 'frs.dosen'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->whereHas('frs.paketFrs', function ($q) use ($tahunAjaranId) {
                if ($tahunAjaranId) {
                    $q->where('tahun_ajaran_id', $tahunAjaranId);
                }
            })
            ->when($semester, function ($q) use ($semester) {
                $q->whereHas('frs', function ($subQ) use ($semester) {
                    $subQ->where('semester', $semester);
                });
            })
            ->get()
            ->map(function ($frsMhs) {
                $frs = $frsMhs->frs;

                return [
                    'id' => $frs->id,
                    'mata_kuliah' => $frs->mataKuliah->nama,
                    'kode_matkul' => $frs->mataKuliah->kode_matkul,
                    'sks' => $frs->mataKuliah->sks,
                    'semester' => $frs->semester,
                    'tahun_ajaran' => $frs->paketFrs->tahunAjaran->nama_tahun_ajaran,
                    'dosen' => $frs->dosen->nama,
                    'hari' => $frs->hari,
                    'jam_mulai' => $frs->jam_mulai,
                    'jam_selesai' => $frs->jam_selesai,
                    'status_disetujui' => $frsMhs->status_disetujui,
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'FRS yang sudah diambil berhasil difilter.',
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