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
    public function listKelas(Request $request)
    {
        $dosen = Auth::user()->dosen;

        if (!$dosen) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Akun ini tidak terhubung dengan data dosen.'
            ], 403);
        }

        // Ambil kelas yang memiliki mahasiswa yang dibimbing oleh dosen wali tersebut
        $kelas = Kelas::whereHas('mahasiswas', function ($query) use ($dosen) {
                $query->where('dosen_wali_id', $dosen->id);
            })
            ->withCount(['mahasiswas as jumlah_mahasiswa' => function ($query) use ($dosen) {
                $query->where('dosen_wali_id', $dosen->id);
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

        $mahasiswa = Mahasiswa::where('kelas_id', $kelasId)
            ->where('dosen_wali_id', $dosen->id)
            ->with('kelas')
            ->get();

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

    public function listMahasiswaFrs($mahasiswaId)
    {
        $dosen = Auth::user()->dosen;

        $mahasiswa = Mahasiswa::with('kelas')->findOrFail($mahasiswaId);

        if ($mahasiswa->dosen_wali_id !== $dosen->id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Anda bukan dosen wali dari mahasiswa ini.'
            ], 403);
        }

        $frsList = FrsMahasiswa::with(['frs.mataKuliah', 'frs.paketFrs.tahunAjaran'])
            ->where('mahasiswa_id', $mahasiswaId)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'mata_kuliah' => $item->frs->mataKuliah->nama ?? '-',
                    'kode_matkul' => $item->frs->mataKuliah->kode_matkul ?? '-',
                    'semester' => $item->frs->semester,
                    'tahun_ajaran' => $item->frs->paketFrs->tahunAjaran->nama_tahun_ajaran ?? '-',
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