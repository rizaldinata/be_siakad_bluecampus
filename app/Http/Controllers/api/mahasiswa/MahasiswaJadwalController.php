<?php

namespace App\Http\Controllers\api\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FrsMahasiswa;

class MahasiswaJadwalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->mahasiswa) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Akun ini belum memiliki data mahasiswa terkait.'
            ], 403);
        }

        $mahasiswaId = $user->mahasiswa->id;

        // Filter tahun ajaran dan semester jika dikirim (optional)
        $tahunAjaran = $request->query('tahun_ajaran');
        $semester = $request->query('semester'); // ganjil / genap

        $frsMahasiswaQuery = FrsMahasiswa::with([
            'frs.jadwalKuliah',
            'frs.mataKuliah',
            'frs.dosen',
            'frs.paketFrs.tahunAjaran'
        ])
        ->where('mahasiswa_id', $mahasiswaId)
        ->where('status_disetujui', 'ya');

        if ($tahunAjaran) {
            $frsMahasiswaQuery->whereHas('frs.paketFrs.tahunAjaran', function ($q) use ($tahunAjaran) {
            $q->where('nama_tahun_ajaran', $tahunAjaran);
        });
        }

        if ($semester) {
            $frsMahasiswaQuery->whereHas('frs', function ($q) use ($semester) {
                if ($semester === 'ganjil') {
                    $q->whereIn('frs.semester', [1, 3, 5, 7]);
                } elseif ($semester === 'genap') {
                    $q->whereIn('frs.semester', [2, 4, 6, 8]);
                }
            });
        }

        $jadwal = $frsMahasiswaQuery->get()->map(function ($item) {
            return [
                'hari' => $item->frs->hari,
                'jam_mulai' => $item->frs->jam_mulai,
                'jam_selesai' => $item->frs->jam_selesai,
                'ruangan' => $item->frs->jadwalKuliah->ruangan ?? '-',
                'mata_kuliah' => $item->frs->mataKuliah->nama ?? '-',
                'kode_matkul' => $item->frs->mataKuliah->kode_matkul ?? '-',
                'sks' => $item->frs->mataKuliah->sks ?? 0,
                'dosen' => $item->frs->dosen->nama ?? '-',
                'kelas' => $item->frs->kelas ?? '-',
                'semester' => $item->frs->semester,
                'tahun_ajaran' => $item->frs->paketFrs->tahunAjaran->nama_tahun_ajaran ?? '-',
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil diambil',
            'data' => $jadwal->groupBy('hari')->toArray()
        ]);
    }
}