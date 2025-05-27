<?php

namespace App\Http\Controllers\web;

use App\Models\Frs;
use App\Models\Mahasiswa;
use App\Models\FrsMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminFrsMahasiswaController extends Controller
{
    public function index()
    {
        $frsMahasiswas = FrsMahasiswa::with([
            'mahasiswa.dosenWali',
            'frs.mataKuliah'
        ])->get();

        return view('admin.frs_mahasiswa.index', compact('frsMahasiswas'));
    }

    public function create()
    {
        $statusList = $this->getEnumValues('frs_mahasiswas', 'status_disetujui');
        $mahasiswaList = Mahasiswa::with('kelas')->get();
        $frsList = Frs::with('mataKuliah')->get();
        return view('admin.frs_mahasiswa.create', compact('mahasiswaList', 'frsList', 'statusList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status_disetujui' => 'required|in:ya,tidak,menunggu',
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'frs_id' => 'required|exists:frs,id',
        ]);

        FrsMahasiswa::create($request->all());

        return redirect()->route('admin.frs-mahasiswa.index')
            ->with('success', 'FRS Mahasiswa berhasil ditambahkan.');
    }

    public function show($id)
    {
        $frsMahasiswa = FrsMahasiswa::with(['mahasiswa.kelas', 'mahasiswa.dosenWali', 'frs.mataKuliah', 'frs.dosen'])->findOrFail($id);
        return view('admin.frs_mahasiswa.show', compact('frsMahasiswa'));
    }

    public function edit($id)
    {
        $statusList = $this->getEnumValues('frs_mahasiswas', 'status_disetujui');
        $frsMahasiswa = FrsMahasiswa::findOrFail($id);
        $mahasiswaList = Mahasiswa::with('kelas')->get();
        $frsList = Frs::with('mataKuliah')->get();
        return view('admin.frs_mahasiswa.edit', compact('frsMahasiswa', 'mahasiswaList', 'frsList', 'statusList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_disetujui' => 'required|in:ya,tidak,menunggu',
        ]);

        $frsMahasiswa = FrsMahasiswa::findOrFail($id);

        $frsMahasiswa->update([
            'status_disetujui' => $request->status_disetujui,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.frs-mahasiswa.index')
            ->with('success', 'FRS Mahasiswa berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $frsMahasiswa = FrsMahasiswa::findOrFail($id);
        $frsMahasiswa->delete();

        return redirect()->route('admin.frs-mahasiswa.index')
            ->with('success', 'FRS Mahasiswa berhasil dihapus.');
    }

    private function getEnumValues($table, $column)
    {
        $type = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = '{$column}'")[0]->Type;

        preg_match('/enum\((.*)\)/', $type, $matches);

        return collect(explode(',', $matches[1]))->map(function ($value) {
            return trim($value, "'");
        });
    }
}