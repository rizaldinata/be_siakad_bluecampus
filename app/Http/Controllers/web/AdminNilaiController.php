<?php

namespace App\Http\Controllers\web;

use App\Models\Nilai;
use App\Models\FrsMahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminNilaiController extends Controller
{
    public function index()
    {
        $frsDisetujuiDenganNilai = FrsMahasiswa::with(['mahasiswa', 'frs.mataKuliah', 'frs.dosen', 'nilai'])
            ->where('status_disetujui', 'ya')
            ->whereHas('nilai')
            ->get();

        $frsDisetujuiTanpaNilai = FrsMahasiswa::with(['mahasiswa', 'frs.mataKuliah', 'frs.dosen'])
            ->where('status_disetujui', 'ya')
            ->whereDoesntHave('nilai')
            ->get();

        return view('admin.nilai.index', compact('frsDisetujuiDenganNilai', 'frsDisetujuiTanpaNilai'));
    }

    public function create(Request $request)
    {
        $id = $request->query('frs_mahasiswa_id');

        $frsMahasiswa = FrsMahasiswa::with(['mahasiswa', 'frs.mataKuliah'])
            ->where('status_disetujui', 'ya')
            ->whereDoesntHave('nilai')
            ->findOrFail($id);

        return view('admin.nilai.create', compact('frsMahasiswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nilai_angka' => 'required|numeric|min:0|max:100',
            'frs_mahasiswa_id' => 'required|exists:frs_mahasiswas,id',
        ]);

        // Cek apakah data sudah punya nilai
        $frsMahasiswa = FrsMahasiswa::with('nilai')->findOrFail($request->frs_mahasiswa_id);

        if ($frsMahasiswa->status_disetujui !== 'ya') {
            return redirect()->back()->with('error', 'FRS belum disetujui. Tidak dapat menambahkan nilai.');
        }

        if ($frsMahasiswa->nilai) {
            return redirect()->route('admin.nilai.index')
                ->with('error', 'Nilai untuk mahasiswa ini sudah ada.');
        }

        $nilaiHuruf = $this->konversiHuruf($request->nilai_angka);

        $frsMahasiswa->nilai()->create([
            'nilai_angka' => $request->nilai_angka,
            'nilai_huruf' => $nilaiHuruf,
        ]);

        return redirect()->route('admin.nilai.index')
            ->with('success', 'Nilai berhasil ditambahkan.');
    }

    public function show($id)
    {
        $nilai = Nilai::with('frsMahasiswa.mahasiswa', 'frsMahasiswa.frs.mataKuliah')->findOrFail($id);
        return view('admin.nilai.show', compact('nilai'));
    }

    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);
        $frsMahasiswas = FrsMahasiswa::with('mahasiswa', 'frs.mataKuliah')->get();

        return view('admin.nilai.edit', compact('nilai', 'frsMahasiswas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai_angka' => 'required|numeric|min:0|max:100',
            'frs_mahasiswa_id' => 'required|exists:frs_mahasiswas,id',
        ]);

        $nilai = Nilai::findOrFail($id);

        $nilai->update([
            'nilai_angka' => $request->nilai_angka,
            'nilai_huruf' => $this->konversiHuruf($request->nilai_angka),
            'frs_mahasiswa_id' => $request->frs_mahasiswa_id,
        ]);

        return redirect()->route('admin.nilai.index')
            ->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        return redirect()->route('admin.nilai.index')
            ->with('success', 'Nilai berhasil dihapus.');
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