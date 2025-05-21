<?php

namespace App\Http\Controllers\web;

use App\Models\Dosen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDosenController extends Controller
{
    public function index()
    {
        $dosen = Dosen::all();
        return view('admin.dosen.index', compact('dosen'));
    }
}