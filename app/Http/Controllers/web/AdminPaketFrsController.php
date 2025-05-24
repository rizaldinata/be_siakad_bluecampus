<?php

namespace App\Http\Controllers\web;

use App\Models\Kelas;
use App\Models\PaketFrs;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPaketFrsController extends Controller
{
    public function index()
    {
        $paketFrs = PaketFrs::with(['kelas', 'tahunAjaran'])->orderBy('nama_paket')->get();
        return view('admin.paket_frs.index', compact('paketFrs'));
    }

    public function show(PaketFrs $paketFrs)
    {
        $paketFrs->load(['kelas', 'tahunAjaran', 'frs.mataKuliah']);
        return view('admin.paket_frs.show', compact('paketFrs'));
    }

    public function create()
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $tahunAjaranList = TahunAjaran::orderBy('nama_tahun_ajaran', 'desc')->get();

        return view('admin.paket_frs.create', compact('kelasList', 'tahunAjaranList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        PaketFrs::create([
            'nama_paket' => $request->nama_paket,
            'kelas_id' => $request->kelas_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
        ]);

        return redirect()->route('admin.paket-frs.index')
            ->with('success', 'Paket FRS berhasil ditambahkan.');
    }

    public function edit(PaketFrs $paketFrs)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $tahunAjaranList = TahunAjaran::orderBy('nama_tahun_ajaran', 'desc')->get();

        return view('admin.paket_frs.edit', compact('paketFrs', 'kelasList', 'tahunAjaranList'));
    }

    public function update(Request $request, PaketFrs $paketFrs)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        $paketFrs->update([
            'nama_paket' => $request->nama_paket,
            'kelas_id' => $request->kelas_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
        ]);

        return redirect()->route('admin.paket-frs.index')
            ->with('success', 'Paket FRS berhasil diperbarui.');
    }

    public function destroy(PaketFrs $paketFrs)
    {
        $paketFrs->delete();
        return redirect()->route('admin.paket-frs.index')->with('success', 'Paket FRS berhasil dihapus.');
    }
}