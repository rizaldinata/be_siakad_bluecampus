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
        $nilais = Nilai::with([
            'frsMahasiswa.mahasiswa',
            'frsMahasiswa.frs.mataKuliah',
            'frsMahasiswa.frs.dosen'
        ])->get();

        return view('admin.nilai.index', compact('nilais'));
    }      


    public function create()
    {
        $frsMahasiswas = FrsMahasiswa::with('mahasiswa', 'frs.mataKuliah')->get();
        return view('admin.nilai.create', compact('frsMahasiswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nilai_angka' => 'required|numeric|min:0|max:100',
            'frs_mahasiswa_id' => 'required|exists:frs_mahasiswas,id',
        ]);

        $nilaiHuruf = $this->konversiHuruf($request->nilai_angka);

        Nilai::create([
            'nilai_angka' => $request->nilai_angka,
            'nilai_huruf' => $nilaiHuruf,
            'frs_mahasiswa_id' => $request->frs_mahasiswa_id,
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