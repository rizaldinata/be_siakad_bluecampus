<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class AdminMahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::all();

        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }
}