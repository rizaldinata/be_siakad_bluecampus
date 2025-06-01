<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Helpers\FilterHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function apiLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!in_array($user->role, ['mahasiswa', 'dosen'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $token = $user->createToken('mobile-token')->plainTextToken;

        $filterOptions = null;

        if ($user->role === 'mahasiswa' && $user->mahasiswa) {
            $tanggalMasuk = $user->mahasiswa->tanggal_masuk;
            $filterOptions = [
                'tahun_ajaran' => FilterHelper::getTahunAjaranList($tanggalMasuk),
                'semester' => FilterHelper::getSemesterOptions($tanggalMasuk),
            ];
        }

        if ($user->role === 'dosen' && $user->dosen) {
            // Ambil semua tahun ajaran yang terkait dengan frs yang pernah dia ajar
            $tahunAjaranList = TahunAjaran::whereHas('paketFrs.frs', function ($q) use ($user) {
                $q->where('dosen_id', $user->dosen->id);
            })
            ->orderBy('nama_tahun_ajaran', 'desc')
            ->pluck('nama_tahun_ajaran');

            $filterOptions = [
                'tahun_ajaran' => $tahunAjaranList,
            ];
        }

        return response()->json([
            'token' => $token,
            'user' => $user->only(['id', 'email', 'role', 'created_at', 'updated_at']),
            'filter_options' => $filterOptions,
        ]);
    }

    public function showWebLoginForm()
    {
        return view('auth.login');
    }


    public function webLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password salah',
            ]);
        }

        $user = Auth::user();
        if ($user->role !== 'admin') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Admin hanya dapat mengakses halaman login web',
            ]);
        }

        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }

    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function webLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}