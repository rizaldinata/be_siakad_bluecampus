<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Admin;
use App\Models\Frs;
use App\Models\Kelas;
use App\Models\PaketFrs;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen = Dosen::count();
        $totalAdmin = Admin::count();

        $totalFrs = Frs::count();
        $totalKelas = Kelas::count();
        $totalPaketFrs = PaketFrs::count();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalDosen',
            'totalAdmin',
            'totalFrs',
            'totalKelas',
            'totalPaketFrs'
        ));
    }
}