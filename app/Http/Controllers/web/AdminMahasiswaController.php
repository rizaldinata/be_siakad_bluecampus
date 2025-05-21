<?php

namespace App\Http\Controllers\web;

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
            'semester' => 'nullable|numeric|min:1',
            'status' => 'required|in:aktif,non-aktif,cuti',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'asal_sekolah' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'dosen_wali_id' => 'required|exists:dosens,id',
        ]);

        // Buat akun user untuk mahasiswa
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        // Simpan data mahasiswa
        Mahasiswa::create([
            'user_id' => $user->id,
            'nrp' => $request->nrp,
            'nama' => $request->nama,
            'semester' => $request->semester ?? 1,
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
            'semester' => 'nullable|numeric|min:1',
            'status' => 'required|in:aktif,cuti,non-aktif',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string',
            'asal_sekolah' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'dosen_wali_id' => 'required|exists:dosens,id',
            'email' => 'required|email|unique:users,email,' . $mahasiswa->user->id,
            'password' => 'nullable|min:8',
        ]);

        // Update user terkait
        if ($mahasiswa->user) {
            $mahasiswa->user->update([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => $request->filled('password')
                    ? Hash::make($request->password)
                    : $mahasiswa->user->password,
            ]);
        }

        // Update data mahasiswa
        $mahasiswa->update([
            'nrp' => $request->nrp,
            'nama' => $request->nama,
            'semester' => $request->semester,
            'status' => $request->status,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_masuk' => $request->tanggal_masuk,
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

        // Hapus user terkait juga jika ada
        if ($mahasiswa->user) {
            $mahasiswa->user->delete();
        }

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