<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\FilterHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

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

        // Tambahkan data filter jika role mahasiswa
        if ($user->role === 'mahasiswa' && $user->mahasiswa) {
            $tanggalMasuk = $user->mahasiswa->tanggal_masuk;
            $filterOptions = [
                'tahun_ajaran' => FilterHelper::getTahunAjaranList($tanggalMasuk),
                'semester' => FilterHelper::getSemesterOptions($tanggalMasuk),
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
                'email' => 'Email or password incorrect',
            ]);
        }

        $user = Auth::user();
        if ($user->role !== 'admin') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Access denied',
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