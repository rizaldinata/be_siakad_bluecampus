<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminDosenController extends Controller
{
    public function index()
    {
        $dosen = Dosen::with('user')->get();
        return view('admin.dosen.index', compact('dosen'));
    }

    public function create()
    {
        $jenisKelaminList = $this->getEnumValues('mahasiswas', 'jenis_kelamin');
        return view('admin.dosen.create', compact('jenisKelaminList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'nama' => 'required|string',
            'nip' => 'required|unique:dosens,nip',
            'no_telp' => 'required|string',
            'alamat' => 'required|string',
            'gelar_depan' => 'nullable|string',
            'gelar_belakang' => 'nullable|string',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'program_studi' => 'required|string',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dosen',
        ]);

        Dosen::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'gelar_depan' => $request->gelar_depan,
            'gelar_belakang' => $request->gelar_belakang,
            'jenis_kelamin' => $request->jenis_kelamin,
            'program_studi' => $request->program_studi,
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil ditambahkan.');
    }

    public function show($id)
    {
        $dosen = Dosen::with('user')->findOrFail($id);
        return view('admin.dosen.show', compact('dosen'));
    }

    public function edit($id)
    {
        $dosen = Dosen::with('user')->findOrFail($id);
        $jenisKelaminList = $this->getEnumValues('mahasiswas', 'jenis_kelamin');

        return view('admin.dosen.edit', compact('dosen', 'jenisKelaminList'));
    }

    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);
        $user = $dosen->user;

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',

            'nama' => 'required|string',
            'nip' => 'required|unique:dosens,nip,' . $dosen->id,
            'no_telp' => 'required|string',
            'alamat' => 'required|string',
            'gelar_depan' => 'nullable|string',
            'gelar_belakang' => 'nullable|string',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'program_studi' => 'required|string',
        ]);

        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $dosen->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'gelar_depan' => $request->gelar_depan,
            'gelar_belakang' => $request->gelar_belakang,
            'jenis_kelamin' => $request->jenis_kelamin,
            'program_studi' => $request->program_studi,
        ]);

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil diupdate.');
    }

    public function destroy($id)
    {
        $dosen = Dosen::findOrFail($id);

        $dosen->user()->delete();
        $dosen->delete();

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil dihapus.');
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