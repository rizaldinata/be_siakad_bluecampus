<?php

namespace App\Http\Controllers\api\dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Frs;
use App\Models\FrsMahasiswa;

class DosenNilaiController extends Controller
{
    public function kelasList(Request $request)
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

        $query = Frs::with(['mataKuliah', 'paketFrs.kelas', 'paketFrs.tahunAjaran'])
            ->where('dosen_id', $dosen->id);

        if ($tahunAjaran) {
            $query->whereHas('paketFrs.tahunAjaran', function ($q) use ($tahunAjaran) {
                $q->where('nama_tahun_ajaran', $tahunAjaran);
            });
        }

        if ($semester) {
            $query->where(function ($q) use ($semester) {
                if ($semester === 'ganjil') {
                    $q->whereIn('semester', [1, 3, 5, 7]);
                } elseif ($semester === 'genap') {
                    $q->whereIn('semester', [2, 4, 6, 8]);
                }
            });
        }

        $kelasList = $query->get()
            ->unique(fn ($frs) => $frs->paketFrs->kelas_id . '-' . $frs->matkul_id)
            ->map(function ($frs) {
                $paket = $frs->paketFrs;
                $kelas = $paket->kelas ?? null;
                $matkul = $frs->mataKuliah ?? null;
                $tahunAjaran = $paket->tahunAjaran ?? null;

                return [
                    'kelas_id' => $kelas->id ?? null,
                    'nama_kelas' => $kelas->nama_kelas ?? '-',
                    'mata_kuliah' => $matkul->nama ?? '-',
                    'matkul_id' => $matkul->id ?? null,
                    'kode_matkul' => $matkul->kode_matkul ?? '-',
                    'semester' => $frs->semester,
                    'tahun_ajaran' => $tahunAjaran->nama_tahun_ajaran ?? '-',
                ];
            })
            ->values();

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar kelas berhasil diambil.',
            'data' => $kelasList
        ]);
    }

    public function mahasiswaList(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'matkul_id' => 'required|exists:mata_kuliahs,id',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:ganjil,genap'
        ]);

        $dosen = Auth::user()->dosen;
        if (!$dosen) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Akun ini tidak terhubung dengan data dosen.'
            ], 403);
        }

        $semesterList = $request->semester === 'ganjil' ? [1, 3, 5, 7] : [2, 4, 6, 8];

        $frsMahasiswa = FrsMahasiswa::with([
                'mahasiswa', 
                'frs.paketFrs.kelas',
                'frs.paketFrs.tahunAjaran'
            ])
            ->whereHas('frs', function ($q) use ($request, $dosen, $semesterList) {
                $q->where('dosen_id', $dosen->id)
                ->where('matkul_id', $request->matkul_id)
                ->whereIn('semester', $semesterList)
                ->whereHas('paketFrs', function ($q2) use ($request) {
                    $q2->where('kelas_id', $request->kelas_id)
                        ->whereHas('tahunAjaran', function ($q3) use ($request) {
                        $q3->where('nama_tahun_ajaran', $request->tahun_ajaran);
                    });
                });
            })
            ->where('status_disetujui', 'ya')
            ->get()
            ->map(function ($item) {
                return [
                    'frs_mahasiswa_id' => $item->id,
                    'mahasiswa_id' => $item->mahasiswa->id,
                    'nama_mahasiswa' => $item->mahasiswa->nama,
                    'nrp' => $item->mahasiswa->nrp,
                    'nilai_huruf' => $item->nilai_huruf ?? 'Belum dinilai'
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar mahasiswa berhasil diambil.',
            'data' => $frsMahasiswa
        ]);
    }

    public function detailMahasiswa(Request $request, $frs_mahasiswa_id)
    {
        $mahasiswa = FrsMahasiswa::with([
            'mahasiswa',
            'frs.mataKuliah',
            'nilai'
        ])->findOrFail($frs_mahasiswa_id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data mahasiswa berhasil diambil.',
            'data' => [
                'nama' => $mahasiswa->mahasiswa->nama,
                'nrp' => $mahasiswa->mahasiswa->nrp,
                'mata_kuliah' => $mahasiswa->frs->mataKuliah->nama,
                'kode_matkul' => $mahasiswa->frs->mataKuliah->kode_matkul,
                'nilai_huruf' => $mahasiswa->nilai->nilai_huruf ?? 'Belum dinilai',
                'nilai_angka' => $mahasiswa->nilai->nilai_angka ?? 'Belum dinilai',
            ]
        ]);
    }

    public function simpanNilai(Request $request, $frs_mahasiswa_id)
    {
        $request->validate([
            'nilai_angka' => 'required|numeric|min:0|max:100'
        ]);

        $frsMahasiswa = FrsMahasiswa::with('frs')->findOrFail($frs_mahasiswa_id);

        if ($frsMahasiswa->status_disetujui !== 'ya') {
            return response()->json([
                'status' => 'fail',
                'message' => 'FRS belum disetujui.'
            ], 422);
        }

        $dosen = Auth::user()->dosen;
        if (!$dosen || $frsMahasiswa->frs->dosen_id !== $dosen->id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Anda tidak memiliki akses untuk memberi nilai pada FRS ini.'
            ], 403);
        }

        $nilaiHuruf = $this->konversiHuruf($request->nilai_angka);

        $nilai = $frsMahasiswa->nilai()->updateOrCreate(
            ['frs_mahasiswa_id' => $frs_mahasiswa_id],
            [
                'nilai_angka' => $request->nilai_angka,
                'nilai_huruf' => $nilaiHuruf,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Nilai berhasil disimpan.',
            'data' => $nilai
        ]);
    }

    private function konversiHuruf($angka)
    {
        if ($angka >= 86 && $angka <= 100) return 'A';
        if ($angka >= 81 && $angka < 86) return 'A-';
        if ($angka >= 76 && $angka < 81) return 'AB';
        if ($angka >= 71 && $angka < 76) return 'B+';
        if ($angka >= 66 && $angka < 71) return 'B';
        if ($angka >= 61 && $angka < 66) return 'BC';
        if ($angka >= 56 && $angka < 61) return 'C';
        if ($angka >= 41 && $angka < 56) return 'D';
        return 'E';
    }
}