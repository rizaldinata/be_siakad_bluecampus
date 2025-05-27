<?php

namespace App\Http\Controllers\web;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminMahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::with(['user', 'kelas', 'dosenWali'])->findOrFail($id);

        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    public function create()
    {
        $statusList = $this->getEnumValues('mahasiswas', 'status');
        $jenisKelaminList = $this->getEnumValues('mahasiswas', 'jenis_kelamin');
        $kelasList = Kelas::all();
        $dosenList = Dosen::all();

        return view('admin.mahasiswa.create', compact('statusList', 'jenisKelaminList', 'kelasList', 'dosenList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nrp' => 'required|unique:mahasiswas,nrp',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:aktif,non-aktif,cuti',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'asal_sekolah' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'dosen_wali_id' => 'required|exists:dosens,id',
        ]);

        $tanggalMasuk = Carbon::parse($request->tanggal_masuk);
        $bulanMasuk = $tanggalMasuk->month;
        if ($bulanMasuk < 6 || $bulanMasuk > 12) {
            return back()->withErrors([
                'tanggal_masuk' => 'Tanggal masuk hanya diizinkan pada semester ganjil (bulan 6 sampai 12).'
            ])->withInput();
        }

        $sekarang = Carbon::now();
        $selisihBulan = $tanggalMasuk->diffInMonths($sekarang);
        $semester = min(ceil($selisihBulan / 6), 8); // max semester 8

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id' => $user->id,
            'nrp' => $request->nrp,
            'nama' => $request->nama,
            'semester' => $semester,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status' => $request->status,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'asal_sekolah' => $request->asal_sekolah,
            'kelas_id' => $request->kelas_id,
            'dosen_wali_id' => $request->dosen_wali_id,
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $statusList = $this->getEnumValues('mahasiswas', 'status');
        $jenisKelaminList = $this->getEnumValues('mahasiswas', 'jenis_kelamin');
        $kelasList = Kelas::all();
        $dosenList = Dosen::all();

        return view('admin.mahasiswa.edit', compact('mahasiswa', 'statusList', 'jenisKelaminList', 'kelasList', 'dosenList'));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $request->validate([
            'nrp' => 'required|unique:mahasiswas,nrp,' . $mahasiswa->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $mahasiswa->user->id,
            'password' => 'nullable|min:8',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:aktif,non-aktif,cuti',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'asal_sekolah' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'dosen_wali_id' => 'required|exists:dosens,id',
        ]);

        $tanggalMasuk = Carbon::parse($request->tanggal_masuk);
        $bulanMasuk = $tanggalMasuk->month;

        if ($bulanMasuk < 6 || $bulanMasuk > 12) {
            return back()->withErrors([
                'tanggal_masuk' => 'Tanggal masuk hanya diizinkan pada semester ganjil (bulan 6 sampai 12).'
            ])->withInput();
        }

        $sekarang = Carbon::now();
        $selisihBulan = $tanggalMasuk->diffInMonths($sekarang);
        $semester = min(max(ceil($selisihBulan / 6), 1), 8); // min 1, max 8

        $mahasiswa->user->update([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $mahasiswa->user->password,
        ]);

        // Update mahasiswa
        $mahasiswa->update([
            'nrp' => $request->nrp,
            'nama' => $request->nama,
            'semester' => $semester,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status' => $request->status,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'asal_sekolah' => $request->asal_sekolah,
            'kelas_id' => $request->kelas_id,
            'dosen_wali_id' => $request->dosen_wali_id,
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $mahasiswa->user()->delete();
        $mahasiswa->delete();

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
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