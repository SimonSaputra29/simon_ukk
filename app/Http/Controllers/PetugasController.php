<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('user', 'book')->get();
        return view('petugas.index', compact('peminjaman') + [
            'title' => 'Petugas Dashboard'
        ]);
    }
}
