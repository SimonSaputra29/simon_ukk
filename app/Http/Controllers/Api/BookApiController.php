<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    // Ambil semua buku
    public function index()
    {
        return response()->json(Book::all());
    }

    // Simpan buku baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'    => 'required|string|max:255',
            'penulis'  => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok'     => 'required|integer|min:0',
        ]);

        $book = Book::create($data);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data' => $book
        ], 201);
    }

    // Tampilkan detail buku
    public function show($id)
    {
        $book = Book::findOrFail($id);

        return response()->json($book);
    }

    // Update buku
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $data = $request->validate([
            'judul'    => 'required|string|max:255',
            'penulis'  => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok'     => 'required|integer|min:0',
        ]);

        $book->update($data);

        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'data' => $book
        ]);
    }

    // Hapus buku
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(['message' => 'Buku berhasil dihapus']);
    }
}
