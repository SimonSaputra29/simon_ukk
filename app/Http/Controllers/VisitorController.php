<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitorController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            abort(403, 'Tidak Ada Akses');
        }

        if (Auth::user()->role !== 'visitor') {
            abort(403, 'Tidak Ada Akses');
        }

        $buku = Book::all();

        return view('visitor.index', compact('buku') + [
            'title' => 'Visitor Dashboard'
        ]);
    }
}
