<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (Auth::user()->role !== 'administrator') {
            return back()->with('error', 'Akses ditolak.');
        }

        $users = User::where('role', 'petugas')->get();
        return view('admin.index', compact('users') + [
            'title' => 'Dashboard Admin'
        ]);
    }
}
