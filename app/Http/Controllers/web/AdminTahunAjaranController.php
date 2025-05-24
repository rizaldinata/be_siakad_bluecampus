<?php

namespace App\Http\Controllers\web;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminTahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjarans = TahunAjaran::withCount([
            'frs as total_frs' => fn($q) => $q,
            'frs as frs_disetujui' => fn($q) => $q->whereHas('frsMahasiswas', fn($s) => $s->where('status_disetujui', 'ya')),
            'frs as frs_ditolak' => fn($q) => $q->whereHas('frsMahasiswas', fn($s) => $s->where('status_disetujui', 'tidak'))
        ])->orderBy('nama_tahun_ajaran', 'desc')->get();

        return view('admin.tahun_ajaran.index', compact('tahunAjarans'));
    }

    public function create()
    {
        return view('admin.tahun_ajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_awal' => 'required|integer|min:2000|max:2099',
        ]);

        $tahunAwal = (int) $request->tahun_awal;
        $tahunAkhir = $tahunAwal + 1;
        $tahunSekarang = now()->year;

        if ($tahunAwal >= $tahunSekarang) {
            return redirect()->back()->withErrors([
                'tahun_awal' => 'Tahun ajaran tidak boleh dimulai pada tahun sekarang atau setelahnya.',
            ])->withInput();
        }

        $tahunFormat = $tahunAwal . '/' . $tahunAkhir;

        TahunAjaran::create([
            'nama_tahun_ajaran' => $tahunFormat
        ]);

        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('admin.tahun_ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate([
            'tahun_awal' => 'required|integer|min:2000|max:2099',
        ]);

        $tahunAwal = (int) $request->tahun_awal;
        $tahunAkhir = $tahunAwal + 1;
        $tahunSekarang = now()->year;

        if ($tahunAwal >= $tahunSekarang) {
            return redirect()->back()->withErrors([
                'tahun_awal' => 'Tahun ajaran tidak boleh dimulai pada tahun sekarang atau setelahnya.',
            ])->withInput();
        }

        $tahunFormat = $tahunAwal . '/' . $tahunAkhir;

        $tahunAjaran->update([
            'nama_tahun_ajaran' => $tahunFormat
        ]);

        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();
        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}