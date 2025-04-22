<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'book']);

        // Hanya tampilkan peminjaman milik user jika role-nya visitor
        if (auth()->user()->role === 'visitor') {
            $query->where('id_user', auth()->id());
        }

        // Filter pencarian berdasarkan nama user atau judul buku
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', fn($sub) =>
                $sub->where('name', 'like', '%' . $request->search . '%'))
                    ->orWhereHas('book', fn($sub) =>
                    $sub->where('judul', 'like', '%' . $request->search . '%'));
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal pinjam
        if ($request->filled('date')) {
            $query->whereDate('tanggal_pinjam', $request->date);
        }

        // Sorting dengan kolom yang diperbolehkan
        $allowedSorts = ['id', 'tanggal_pinjam', 'tanggal_kembali', 'status'];
        $sort = in_array($request->get('sort'), $allowedSorts) ? $request->get('sort') : 'id';
        $direction = in_array($request->get('direction'), ['asc', 'desc']) ? $request->get('direction') : 'asc';

        $peminjaman = $query->orderBy($sort, $direction)->paginate(10);

        return view('peminjaman.index', [
            'peminjaman' => $peminjaman,
            'title' => 'Peminjaman',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::where('stok', '>', 0)->get();

        if ($books->isEmpty()) {
            return redirect()->route('buku.index')->with('error', 'Tidak Ada Buku');
        }

        return view('peminjaman.create', compact('books') + [
            'title' => 'Pinjam Buku'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_buku' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($validated['id_buku']);

        if ($book->stok <= 0) {
            return back()->with('error', 'Buku ini tidak tersedia.');
        }

        $status = auth()->user()->role === 'visitor' ? 'waiting_approval' : 'borrowed';

        // Validasi status
        $allowedStatuses = ['borrowed', 'waiting_approval', 'returned', 'waiting_return_approval'];
        if (!in_array($status, $allowedStatuses)) {
            return back()->withErrors(['status' => 'Status tidak valid.']);
        }

        // Buat record peminjaman
        $peminjaman = Peminjaman::create([
            'id_user' => auth()->id(),
            'id_buku' => $book->id,
            'tanggal_pinjam' => now(), // Simpan tanggal pengajuan, meskipun status waiting_approval
            'status' => $status,
        ]);

        // Kurangi stok buku hanya jika status langsung 'borrowed'
        if ($status === 'borrowed') {
            $book->decrement('stok');
        }

        $message = $status === 'waiting_approval'
            ? 'Peminjaman diajukan, menunggu persetujuan petugas.'
            : 'Peminjaman berhasil.';

        return redirect()->route('peminjaman.index')->with('success', $message);
    }

    public function setujuiPeminjaman($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'waiting_approval') {
            return back()->with('error', 'Peminjaman ini Tidak Membutuhkan persetujuan');
        }

        $peminjaman->update([
            'status'    => 'borrowed',
            'tanggal_pinjam'    => now(),
        ]);

        $peminjaman->book->decrement('stok');

        return back()->with('success', 'Peminjaman Di Setujui');
    }

    public function ajukanPengembalian($id)
    {
        $peminjaman = Peminjaman::find($id);

        if ($peminjaman && $peminjaman->status === 'borrowed') {
            $peminjaman->status = 'returned';
            $peminjaman->tanggal_kembali = now();
            $peminjaman->save();

            $peminjaman->book->increment('stok');

            return redirect()->route('peminjaman.index')->with('success', 'Buku Berhasil Di Kembalikan');
        }

        return redirect()->route('peminjaman.index')->with('error', 'Peminjam Tidak Ditemukan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }
}
