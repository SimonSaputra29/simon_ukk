<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    public function index()
    {
        return response()->json(Book::all(), 200);
    }

    public function show($id)
    {
        $book = Book::find($id);
        if ($book) {
            return response()->json($book, 200);
        }

        return response()->json(['message' => 'Book not found'], 404);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('public/books');
            $imageName = basename($imagePath);
        }

        $book = Book::create([
            'judul' => $data['judul'],
            'penulis' => $data['penulis'],
            'kategori' => $data['kategori'],
            'stok' => $data['stok'],
            'gambar' => $imageName ?? null,
        ]);

        return response()->json($book, 201);
    }

    public function update(Request $request, $id)
    {
        // Cari buku berdasarkan ID
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Validasi data yang diterima (field tidak perlu semua dikirimkan)
        $data = $request->validate([
            'judul' => 'nullable|string|max:255',  // Tidak wajib
            'penulis' => 'nullable|string|max:255', // Tidak wajib
            'kategori' => 'nullable|string|max:255', // Tidak wajib
            'stok' => 'nullable|integer|min:0', // Tidak wajib
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Gambar boleh kosong
        ]);

        // Proses gambar jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($book->gambar && file_exists(storage_path('app/public/books/' . $book->gambar))) {
                unlink(storage_path('app/public/books/' . $book->gambar));
            }

            // Simpan gambar baru
            $imagePath = $request->file('gambar')->store('public/books');
            $imageName = basename($imagePath);
        }

        // Update data buku (hanya update field yang ada di request)
        $book->update([
            'judul' => $data['judul'] ?? $book->judul,  // Jika tidak ada data baru, gunakan yang lama
            'penulis' => $data['penulis'] ?? $book->penulis,
            'kategori' => $data['kategori'] ?? $book->kategori,
            'stok' => $data['stok'] ?? $book->stok,
            'gambar' => $imageName ?? $book->gambar, // Gunakan gambar baru jika ada, jika tidak tetap gambar lama
        ]);

        return response()->json($book, 200);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        if ($book->gambar && file_exists(storage_path('app/public/books/' . $book->gambar))) {
            unlink(storage_path('app/public/books/' . $book->gambar));
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}
