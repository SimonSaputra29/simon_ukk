<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Book::all();
        return view('admin.buku.index', compact('buku') + [
            'title' =>  'Kelola Buku'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.buku.create', [
            'title' =>  'Tambah Buku'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' =>  'required|string|max:225',
            'penulis'   =>  'required|string|max:225',
            'kategori'  =>  'required|string|max:225',
            'stok'  =>  'required|integer|min:0',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('public/books');
            $imageName = basename($imagePath);
        }

        $buku = Book::create([
            'judul' => $data['judul'],
            'penulis' => $data['penulis'],
            'kategori' => $data['kategori'],
            'stok' => $data['stok'],
            'gambar' => $imageName ?? null,
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    // Ini buat admin
    public function show(Book $buku)
    {
        $buku = Book::findOrFail($buku->id);
        $qrCodeUrl = route('buku.show', $buku->id);

        return view('admin.buku.show', compact('buku', 'qrCodeUrl') + [
            'title' => 'Lihat Buku'
        ]);
    }

    // Ini Visitor
    public function showVisitor($id)
    {
        $book = Book::with('ulasan.user')->findOrFail($id);
        return view('visitor.review.show', compact('book') + [
            'title' => 'Daftar Buku'
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $buku)
    {
        return view('admin.buku.edit', compact('buku') + [
            'title' =>  'Edit Buku'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $buku)
    {
        $data = $request->validate([
            'judul' =>  'required|string|max:225',
            'penulis'   =>  'required|string|max:225',
            'kategori'  =>  'required|string|max:225',
            'stok'  =>  'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($buku->gambar && file_exists(storage_path('app/public/books/' . $buku->gambar))) {
                unlink(storage_path('app/public/books/' . $buku->gambar)); 
            }

            // Simpan gambar baru
            $imagePath = $request->file('gambar')->store('public/books');
            $imageName = basename($imagePath);
        }

        // Update data buku
        $buku->update([
            'judul' => $data['judul'],
            'penulis' => $data['penulis'],
            'kategori' => $data['kategori'],
            'stok' => $data['stok'],
            'gambar' => $imageName ?? $buku->gambar, // Jika tidak ada gambar baru, gunakan gambar lama
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $buku)
    {
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku Berhasil Di Hapus');
    }
}
