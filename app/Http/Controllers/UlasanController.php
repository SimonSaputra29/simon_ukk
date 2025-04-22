<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $bookId)
    {
        // Validasi input
        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Menyimpan ulasan
        Ulasan::create([
            'book_id' => $bookId,
            'user_id' => auth()->id(),
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        // Redirect kembali ke halaman detail buku
        return back()->with('success', 'Ulasan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ulasan $ulasan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ulasan $ulasan)
    {
        if (auth()->id() !== $ulasan->user_id) {
            abort(403); // Forbidden jika bukan pemilik
        }

        return view('visitor.review.edit', [
            'ulasan' => $ulasan,
            'title' => 'Edit Ulasan',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ulasan $ulasan)
    {

        // Validasi input
        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Update data ulasan
        $ulasan->update([
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        // Redirect ke halaman detail buku setelah berhasil update
        // return redirect()->route('buku.show', $ulasan->book_id)
        //     ->with('success', 'Ulasan berhasil diperbarui!');
        return redirect()->route('review.show', $ulasan->book_id)->with('success', 'Ulasan Berhasil Di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ulasan $ulasan)
    {

        // Hapus ulasan
        $ulasan->delete();

        // Redirect kembali setelah penghapusan
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
