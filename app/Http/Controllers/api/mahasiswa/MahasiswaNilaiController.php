<?php

namespace App\Http\Controllers\api\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FrsMahasiswa;

class MahasiswaNilaiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Akun ini tidak terhubung dengan data mahasiswa.'
            ], 403);
        }

        $tahunAjaran = $request->query('tahun_ajaran');
        $semester = $request->query('semester'); // ganjil / genap

        $query = FrsMahasiswa::with([
            'frs.mataKuliah',
            'frs.paketFrs.tahunAjaran'
        ])
        ->where('mahasiswa_id', $mahasiswa->id)
        ->where('status_disetujui', 'ya');

        if ($tahunAjaran) {
            $query->whereHas('frs.paketFrs.tahunAjaran', function ($q) use ($tahunAjaran) {
                $q->where('nama_tahun_ajaran', $tahunAjaran);
            });
        }

        if ($semester) {
            $query->whereHas('frs', function ($q) use ($semester) {
                if ($semester === 'ganjil') {
                    $q->whereIn('semester', [1, 3, 5, 7]);
                } elseif ($semester === 'genap') {
                    $q->whereIn('semester', [2, 4, 6, 8]);
                }
            });
        }

        $nilai = $query->get()->map(function ($item) {
            return [
                'mata_kuliah' => $item->frs->mataKuliah->nama ?? '-',
                'kode_matkul' => $item->frs->mataKuliah->kode_matkul ?? '-',
                'nilai_huruf' => $item->nilai->nilai_huruf ?? 'Belum Dinilai',
                'semester' => $item->frs->semester,
                'tahun_ajaran' => $item->frs->paketFrs->tahunAjaran->nama_tahun_ajaran ?? '-',
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Data nilai berhasil diambil.',
            'data' => $nilai
        ]);
    }
}