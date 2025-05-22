<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class AdminMataKuliahController extends Controller
{
    public function index()
    {
        $mataKuliah = MataKuliah::all();
        return view('admin.mata_kuliah.index', compact('mataKuliah'));
    }

    public function create()
    {
        return view('admin.mata_kuliah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_matkul' => 'required|unique:mata_kuliahs,kode_matkul',
            'nama' => 'required|string|max:255',
            'jenis_matkul' => 'required|string|max:255',
            'sks' => 'required|numeric|min:1',
        ]);

        MataKuliah::create($validated);

        return redirect()->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function show($id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        return view('admin.mata_kuliah.show', compact('mataKuliah'));
    }

    public function edit($id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        return view('admin.mata_kuliah.edit', compact('mataKuliah'));
    }

    public function update(Request $request, $id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);

        $validated = $request->validate([
            'kode_matkul' => 'required|unique:mata_kuliahs,kode_matkul,' . $id,
            'nama' => 'required|string|max:255',
            'jenis_matkul' => 'required|string|max:255',
            'sks' => 'required|numeric|min:1',
        ]);

        $mataKuliah->update($validated);

        return redirect()->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        $mataKuliah->delete();

        return redirect()->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil dihapus.');
    }
}