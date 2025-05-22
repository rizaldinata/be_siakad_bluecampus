<?php

namespace App\Http\Controllers\web;

use App\Models\Kelas;
use App\Models\PaketFrs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPaketFrsController extends Controller
{
    public function index()
    {
        $paketFrs = PaketFrs::with('kelas')->get();
        return view('admin.paket_frs.index', compact('paketFrs'));
    }

    public function show($id)
    {
        $paketFrs = PaketFrs::with(['kelas', 'frs.mataKuliah'])->findOrFail($id);
        return view('admin.paket_frs.show', compact('paketFrs'));
    }

    public function create()
    {
        $kelasList = Kelas::all();
        return view('admin.paket_frs.create', compact('kelasList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        PaketFrs::create($validated);

        return redirect()->route('admin.paket-frs.index')->with('success', 'Paket FRS berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $paketFrs = PaketFrs::findOrFail($id);
        $kelasList = Kelas::all();
        return view('admin.paket_frs.edit', compact('paketFrs', 'kelasList'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $paketFrs = PaketFrs::findOrFail($id);
        $paketFrs->update($validated);

        return redirect()->route('admin.paket-frs.index')->with('success', 'Paket FRS berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $paketFrs = PaketFrs::findOrFail($id);
        $paketFrs->delete();

        return redirect()->route('admin.paket-frs.index')->with('success', 'Paket FRS berhasil dihapus.');
    }
}