<?php

namespace App\Http\Controllers\web;

use App\Models\Frs;
use App\Models\Dosen;
use App\Models\PaketFrs;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminFrsController extends Controller
{
    public function index()
    {
        $frsList = Frs::with(['paketFrs', 'mataKuliah', 'dosen'])->get();
        return view('admin.frs.index', compact('frsList'));
    }

    public function show($id)
    {
        $frs = Frs::with([
            'paketFrs',
            'mataKuliah',
            'dosen',
            'jadwalKuliah'
        ])->findOrFail($id);

        return view('admin.frs.show', compact('frs'));
    }

    public function create()
    {
        $hariList = $this->getEnumValues('frs', 'hari');
        $paketFrsList = PaketFrs::all();
        $matkulList = MataKuliah::all();
        $dosenList = Dosen::all();

        return view('admin.frs.create', compact('hariList', 'paketFrsList', 'matkulList', 'dosenList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'semester' => 'required|integer',
            'kelas' => 'required|string',
            'paket_frs_id' => 'required|exists:paket_frs,id',
            'matkul_id' => 'required|exists:mata_kuliahs,id',
            'dosen_id' => 'required|exists:dosens,id',
        ]);

        Frs::create($request->all());

        return redirect()->route('admin.frs.index')->with('success', 'Data FRS berhasil ditambahkan.');
    }

    public function edit(Frs $frs)
    {
        $hariList = $this->getEnumValues('frs', 'hari');
        $paketFrs = PaketFrs::all();
        $mataKuliahs = MataKuliah::all();
        $dosens = Dosen::all();

        return view('admin.frs.edit', compact(
            'frs', 'hariList', 'paketFrs', 'mataKuliahs', 'dosens',
        ));
    }

    public function update(Request $request, Frs $frs)
    {
        $request->validate([
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'semester' => 'required|integer',
            'kelas' => 'required|string',
            'paket_frs_id' => 'required|exists:paket_frs,id',
            'matkul_id' => 'required|exists:mata_kuliahs,id',
            'dosen_id' => 'required|exists:dosens,id',
        ]);

        $frs->update($request->all());

        return redirect()->route('admin.frs.index')->with('success', 'Data FRS berhasil diperbarui.');
    }

    public function destroy(Frs $frs)
    {
        $frs->delete();
        return redirect()->route('admin.frs.index')->with('success', 'Data FRS berhasil dihapus.');
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