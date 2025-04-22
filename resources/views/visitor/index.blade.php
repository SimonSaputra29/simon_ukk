@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="display-6 fw-bold text-gradient mb-4 text-center animate__animated animate__rubberBand">🧒🏻 Halaman
            Peminjam
        </h2>

        {{-- Peminjaman --}}
        <div class="d-flex justify-content-between flex-wrap mb-3 animate__animated animate__tada">
            <a href="{{ route('peminjaman.index') }}" class="btn btn-primary shadow-sm mb-2">
                <i class="fas fa-list"></i> Riwayat Peminjaman Buku
            </a>
            <a href="{{ route('peminjaman.create') }}" class="btn btn-success shadow-sm mb-2">
                <i class="fas fa-plus-circle"></i> Pinjam Buku
            </a>
        </div>

        {{-- Notif --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="table-responsive animate__animated animate__zoomInLeft">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                    <th>Qr</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($buku as $key => $buku)
                    <tr class="table-light text-right">
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td class="text-center">
                            @if ($buku->gambar)
                                <img src="{{ asset('storage/books/' . $buku->gambar) }}" width="50" height="75">
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $buku->judul }}</td>
                        <td>{{ $buku->penulis }}</td>
                        <td>
                            <span class="badge bg-info text-dark">{{ $buku->kategori }}</span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $buku->stok > 0 ? 'success' : 'danger' }} p-2">
                                {{ $buku->stok > 0 ? $buku->stok : 'Habis' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('review.show', $buku->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </td>
                        <td class="text-center">
                            {!! QrCode::size(70)->generate(route('books.show', $buku->id)) !!}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            📚 Tidak ada buku yang tersedia
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
