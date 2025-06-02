<?php

namespace App\Http\Controllers\api\dosen;

use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\FrsMahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DosenFrsController extends Controller
{
    private function hitungSemesterAktif($tanggalMasuk, $tahunAjaran, $tipeSemester)
    {
        $tahunMasuk = (int) date('Y', strtotime($tanggalMasuk));
        $tahunAwalAjaran = (int) substr($tahunAjaran, 0, 4);
        $selisihTahun = $tahunAwalAjaran - $tahunMasuk;

        return ($selisihTahun * 2) + ($tipeSemester === 'genap' ? 2 : 1);
    }

    public function listKelas(Request $request)
    {
        $dosen = Auth::user()->dosen;
        if (!$dosen) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Akun ini tidak terhubung dengan data dosen.'
            ], 403);
        }

        $tahunAjaran = $request->input('tahun_ajaran');
        $tipeSemester = strtolower($request->input('semester'));

        $mahasiswas = Mahasiswa::where('dosen_wali_id', $dosen->id)->get();

        $semesterMap = [];
        foreach ($mahasiswas as $mhs) {
            $semesterMap[$mhs->id] = $this->hitungSemesterAktif($mhs->tanggal_masuk, $tahunAjaran, $tipeSemester);
        }

        $kelas = Kelas::whereHas('mahasiswas', function ($q) use ($dosen, $tahunAjaran, $semesterMap) {
            $q->where('dosen_wali_id', $dosen->id)
                ->whereHas('frsMahasiswa.frs', function ($q2) use ($semesterMap) {
                    $q2->whereIn('semester', array_unique(array_values($semesterMap)));
                })
                ->whereHas('frsMahasiswa.frs.paketFrs.tahunAjaran', function ($q3) use ($tahunAjaran) {
                    $q3->where('nama_tahun_ajaran', $tahunAjaran);
                });
        })
        ->withCount(['mahasiswas as jumlah_mahasiswa' => function ($q) use ($dosen) {
            $q->where('dosen_wali_id', $dosen->id);
        }])
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->id,
                'nama_kelas' => $item->nama_kelas,
                'jumlah_mahasiswa' => $item->jumlah_mahasiswa,
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar kelas bimbingan berhasil diambil.',
            'data' => $kelas,
        ]);
    }

    public function listMahasiswa(Request $request, $kelasId)
    {
        $dosen = Auth::user()->dosen;
        if (!$dosen) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Akun ini tidak terhubung dengan data dosen.'
            ], 403);
        }

        $tahunAjaran = $request->input('tahun_ajaran');
        $tipeSemester = strtolower($request->input('semester'));

        $mahasiswa = Mahasiswa::where('kelas_id', $kelasId)
            ->where('dosen_wali_id', $dosen->id)
            ->with(['kelas', 'frsMahasiswa.frs.paketFrs.tahunAjaran'])
            ->get()
            ->filter(function ($mhs) use ($tahunAjaran, $tipeSemester) {
                $semesterKe = $this->hitungSemesterAktif($mhs->tanggal_masuk, $tahunAjaran, $tipeSemester);

                return $mhs->frsMahasiswa->contains(function ($frsMhs) use ($tahunAjaran, $semesterKe) {
                    $frs = $frsMhs->frs;
                    return $frs &&
                        optional($frs->paketFrs->tahunAjaran)->nama_tahun_ajaran === $tahunAjaran &&
                        $frs->semester == $semesterKe;
                });
            })
            ->values(); // Reset indeks

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar mahasiswa berhasil diambil.',
            'data' => $mahasiswa->map(function ($mhs) {
                return [
                    'id' => $mhs->id,
                    'nama' => $mhs->nama,
                    'nrp' => $mhs->nrp,
                    'kelas' => $mhs->kelas->nama_kelas ?? '-',
                ];
            })
        ]);
    }

    public function listMahasiswaFrs(Request $request, $mahasiswaId)
    {
        $dosen = Auth::user()->dosen;
        $tahunAjaran = $request->input('tahun_ajaran');
        $tipeSemester = strtolower($request->input('semester'));

        $mahasiswa = Mahasiswa::with('kelas')->findOrFail($mahasiswaId);
        if ($mahasiswa->dosen_wali_id !== $dosen->id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Anda bukan dosen wali dari mahasiswa ini.'
            ], 403);
        }

        $semesterKe = $this->hitungSemesterAktif($mahasiswa->tanggal_masuk, $tahunAjaran, $tipeSemester);

        $frsList = FrsMahasiswa::with([
                'frs.mataKuliah',
                'frs.paketFrs.tahunAjaran',
                'frs.dosen'
            ])
            ->where('mahasiswa_id', $mahasiswaId)
            ->whereHas('frs.paketFrs.tahunAjaran', function ($q) use ($tahunAjaran) {
                $q->where('nama_tahun_ajaran', $tahunAjaran);
            })
            ->whereHas('frs', function ($q) use ($semesterKe) {
                $q->where('semester', $semesterKe);
            })
            ->get()
            ->map(function ($item) {
                $frs = $item->frs;
                $mataKuliah = $frs->mataKuliah;
                $dosen = $frs->dosen;

                return [
                    'id' => $item->id,
                    'mata_kuliah' => $mataKuliah->nama ?? '-',
                    'kode_matkul' => $mataKuliah->kode_matkul ?? '-',
                    'sks' => $mataKuliah->sks ?? 0,
                    'semester' => $frs->semester,
                    'tahun_ajaran' => $frs->paketFrs->tahunAjaran->nama_tahun_ajaran ?? '-',
                    'dosen' => $dosen->nama ?? '-',
                    'hari' => $frs->hari ?? '-',
                    'jam_mulai' => $frs->jam_mulai ?? '-',
                    'jam_selesai' => $frs->jam_selesai ?? '-',
                    'status_disetujui' => $item->status_disetujui,
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'Data FRS mahasiswa berhasil diambil.',
            'data' => $frsList,
        ]);
    }

    public function updatePersetujuanFrs(Request $request, $mahasiswaId)
    {
        $request->validate([
            'frs_mahasiswa_id' => 'required|exists:frs_mahasiswas,id',
            'status_disetujui' => 'required|in:ya,tidak',
        ]);

        $dosen = Auth::user()->dosen;
        $mahasiswa = Mahasiswa::findOrFail($mahasiswaId);

        if ($mahasiswa->dosen_wali_id !== $dosen->id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Anda bukan dosen wali dari mahasiswa ini.'
            ], 403);
        }

        $frsMahasiswa = FrsMahasiswa::where('id', $request->frs_mahasiswa_id)
            ->where('mahasiswa_id', $mahasiswaId)
            ->firstOrFail();

        $sudahAdaNilai = Nilai::where('frs_mahasiswa_id', $frsMahasiswa->id)->exists();
        if ($sudahAdaNilai) {
            return response()->json([
                'status' => 'fail',
                'message' => 'FRS ini sudah memiliki nilai dan tidak dapat diubah.'
            ], 400);
        }

        $frsMahasiswa->status_disetujui = $request->status_disetujui;
        $frsMahasiswa->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status persetujuan FRS berhasil diperbarui.',
        ]);
    }
}