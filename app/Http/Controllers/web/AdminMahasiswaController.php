<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminMahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim',
            'nama' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'status' => 'required|in:aktif,cuti,tidak aktif',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Buat user terlebih dahulu
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        // Buat data mahasiswa dan relasikan dengan user
        Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => $request->nim,
            'nama' => $request->nama,
            'prodi' => $request->prodi,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim,' . $mahasiswa->id,
            'nama' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'status' => 'required|in:aktif,cuti,tidak aktif',
        ]);

        $mahasiswa->update($request->only('nim', 'nama', 'prodi', 'status'));

        // Update juga nama user terkait (optional)
        if ($mahasiswa->user) {
            $mahasiswa->user->update([
                'name' => $request->nama
            ]);
        }

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
}