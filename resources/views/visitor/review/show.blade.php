@extends('layouts.app')

@section('content')
    <div class="container mt-4 animate__animated animate__jello">
        {{-- Detail Buku --}}
        <div class="card shadow-sm rounded-4 border-0 mb-4 ">
            <div class="card-header bg-gradient-primary text-white text-center rounded-top-4 mb-3">
                <h2 class="fw-bold">{{ $book->judul }}</h2>
            </div>
            <div class="text-center mb-4">
                @if ($book->gambar)
                    <img src="{{ asset('storage/books/' . $book->gambar) }}" alt="{{ $book->judul }} image"
                        class="img-fluid rounded" style="max-width: 300px;">
                @else
                    <img src="{{ asset('images/default-book.jpg') }}" alt="Default Book Image" class="img-fluid rounded"
                        style="max-width: 300px;">
                @endif
            </div>
            <div class="card-body">
                <p><strong>✍️ Penulis:</strong> {{ $book->penulis }}</p>
                <p><strong>🏷️ Kategori:</strong> {{ $book->kategori }}</p>
                <p><strong>📦 Stok:</strong>
                    <span class="badge bg-{{ $book->stok > 0 ? 'success' : 'danger' }}">
                        {{ $book->stok > 0 ? $book->stok : 'Habis' }}
                    </span>
                </p>
            </div>
        </div>

        {{-- Form Tambah Ulasan --}}
        <div class="card shadow-sm rounded-4 border-0 mb-4">
            <div class="card-header bg-secondary text-white text-center rounded-top-4">
                <h4>Masukan Ulasan Anda 📋</h4>
            </div>
            <div class="card-body">
                @auth
                    <form action="{{ route('review.ulasans.store', $book->id) }}" method="POST" class="mb-4">
                        @csrf

                        <div class="mb-3">
                            <label for="content" class="form-label">📝 Ulasan:</label>
                            <textarea name="content" id="content" class="form-control shadow-sm" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">⭐ Rating:</label>
                            <select name="rating" id="rating" class="form-select" required>
                                <option value="">Pilih rating</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} ⭐</option>
                                @endfor
                            </select>
                        </div>

                        <button type="submit" class="btn btn-gradient-success shadow-sm">
                            <i class="fas fa-paper-plane"></i> Kirim Ulasan
                        </button>
                    </form>
                @else
                    <p><a href="{{ route('login') }}" class="text-primary fw-bold">Login</a> untuk memberikan ulasan.</p>
                @endauth
            </div>
        </div>

        {{-- Daftar Ulasan --}}
        <div class="card shadow-sm rounded-4 border-0">
            <div class="card-header bg-info text-white text-center rounded-top-4">
                <h4>📢 Ulasan Pengguna</h4>
            </div>
            <div class="card-body">
                @forelse($book->ulasan as $review)
                    <div class="border rounded p-3 mb-3 shadow-sm position-relative">
                        <strong>{{ $review->user->name }}</strong>
                        <div class="text-warning">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </div>
                        <p class="mb-1 mt-2">{{ $review->content }}</p>
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>

                        @if (auth()->id() === $review->user_id)
                            <div class="mt-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('ulasans.edit', $review->id) }}" class="btn btn-sm btn-warning me-2">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                {{-- Form Hapus --}}
                                <form action="{{ route('ulasans.destroy', $review->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-muted text-center">Belum ada ulasan.</p>
                @endforelse
            </div>
        </div>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

            body {
                font-family: 'Poppins', sans-serif;
            }

            .bg-gradient-primary {
                background: linear-gradient(90deg, #007bff, #6610f2);
            }

            .btn-gradient-success {
                background: linear-gradient(90deg, #28a745, #218838);
                color: #fff;
                border: none;
            }

            .btn-gradient-success:hover {
                background: linear-gradient(90deg, #218838, #28a745);
                color: #fff;
            }

            .card-header {
                border-top-left-radius: 12px;
                border-top-right-radius: 12px;
            }

            .card {
                border-radius: 12px;
            }

            .btn {
                transition: all 0.3s ease-in-out;
            }

            .btn:hover {
                transform: scale(1.05);
            }

            .form-control,
            .form-select {
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .badge {
                font-size: 0.9rem;
                padding: 0.4em 0.6em;
                border-radius: 8px;
            }
        </style>
    @endsection
