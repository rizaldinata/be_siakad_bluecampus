<?php

namespace App\Http\Controllers\api\dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Frs;

class DosenJadwalController extends Controller
{
    public function index(Request $request)
    {
        $dosen = Auth::user()->dosen;

        if (!$dosen) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Akun ini tidak terhubung dengan data dosen.'
            ], 403);
        }

        $tahunAjaran = $request->query('tahun_ajaran');
        $semester = $request->query('semester'); 

        $query = Frs::with(['mataKuliah', 'jadwalKuliah', 'paketFrs.tahunAjaran'])
            ->where('dosen_id', $dosen->id)
            ->whereHas('jadwalKuliah');

        if ($tahunAjaran) {
            $query->whereHas('paketFrs.tahunAjaran', function ($q) use ($tahunAjaran) {
                $q->where('nama_tahun_ajaran', $tahunAjaran);
            });
        }

        if ($semester) {
            if ($semester === 'ganjil') {
                $query->whereIn('semester', [1, 3, 5, 7]);
            } elseif ($semester === 'genap') {
                $query->whereIn('semester', [2, 4, 6, 8]);
            }
        }

        $jadwal = $query->get()
            ->unique(fn ($item) => $item->hari . $item->jam_mulai . $item->jam_selesai . $item->matkul_id)
            ->map(function ($item) {
                return [
                    'hari' => $item->hari,
                    'jam_mulai' => $item->jam_mulai,
                    'jam_selesai' => $item->jam_selesai,
                    'ruangan' => $item->jadwalKuliah->ruangan ?? '-',
                    'mata_kuliah' => $item->mataKuliah->nama ?? '-',
                    'kode_matkul' => $item->mataKuliah->kode_matkul ?? '-',
                    'sks' => $item->mataKuliah->sks ?? 0,
                    'kelas' => $item->kelas ?? '-',
                    'semester' => $item->semester,
                    'tahun_ajaran' => $item->paketFrs->tahunAjaran->nama_tahun_ajaran ?? '-',
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal dosen berhasil diambil.',
            'data' => $jadwal->groupBy('hari')->toArray()
        ]);
    }
}