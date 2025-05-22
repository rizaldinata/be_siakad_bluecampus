<?php

namespace App\Http\Controllers\web;

use App\Models\Frs;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminJadwalKuliahController extends Controller
{
    public function index()
    {
        $jadwalKuliahs = JadwalKuliah::with([
            'frs.mataKuliah',
            'frs.dosen',
            'frs.paketFrs.kelas'
        ])->get();

        return view('admin.jadwal_kuliah.index', compact('jadwalKuliahs'));
    }

    public function create()
    {
        $frsList = Frs::all();
        return view('admin.jadwal_kuliah.create', compact('frsList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruangan' => 'required|string|max:255',
            'frs_id' => 'required|exists:frs,id',
        ]);

        JadwalKuliah::create($request->all());

        return redirect()->route('admin.jadwal-kuliah.index')
            ->with('success', 'Jadwal kuliah berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jadwal = JadwalKuliah::with('frs.mataKuliah', 'frs.dosen')->findOrFail($id);
        return view('admin.jadwal_kuliah.show', compact('jadwal'));
    }

    public function edit($id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);
        $frsList = Frs::all();

        return view('admin.jadwal_kuliah.edit', compact('jadwal', 'frsList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ruangan' => 'required|string|max:255',
            'frs_id' => 'required|exists:frs,id',
        ]);

        $jadwal = JadwalKuliah::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal-kuliah.index')
            ->with('success', 'Jadwal kuliah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal-kuliah.index')
            ->with('success', 'Jadwal kuliah berhasil dihapus.');
    }
}