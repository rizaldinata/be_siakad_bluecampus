<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Admin;


class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen = Dosen::count();
        $totalAdmin = Admin::count();

        $mahasiswaAktif = Mahasiswa::where('status', 'aktif')->count();
        $mahasiswaNonAktif = Mahasiswa::where('status', 'non-aktif')->count();
        $mahasiswaCuti = Mahasiswa::where('status', 'cuti')->count();

        return view('admin.dashboard', compact(
            'totalMahasiswa', 'totalDosen', 'totalAdmin',
            'mahasiswaAktif', 'mahasiswaNonAktif', 'mahasiswaCuti'
        ));
    }
}