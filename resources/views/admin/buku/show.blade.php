@extends('layouts.app')

@section('content')
    <div class="container mt-4 animate__animated animate__fadeInUp">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-gradient-primary text-white text-center">
                <h4 class="mb-0">📖 Detail Buku</h4>
            </div>
            <div class="card-body">

                <h3 class="fw-bold text-primary">{{ $buku->judul }}</h3>

                <div class="text-center mb-4">
                    @if ($buku->gambar)
                        <img src="{{ asset('storage/books/' . $buku->gambar) }}" alt="{{ $buku->judul }} image"
                            class="img-fluid rounded" style="max-width: 300px;">
                    @else
                        <img src="{{ asset('images/default-book.jpg') }}" alt="Default Book Image" class="img-fluid rounded"
                            style="max-width: 300px;">
                    @endif
                </div>
                <p>
                    <i class="fas fa-user text-secondary"></i>
                    <strong>Penulis:</strong> {{ $buku->penulis }}
                </p>

                <p>
                    <i class="fas fa-tags text-secondary"></i>
                    <strong>Kategori:</strong> {{ $buku->kategori }}
                </p>

                <p>
                    <i class="fas fa-box text-secondary"></i>
                    <strong>Stok:</strong>
                    <span class="badge bg-{{ $buku->stok > 0 ? 'success' : 'danger' }} ">
                        {{ $buku->stok > 0 ? $buku->stok : 'Habis' }}
                    </span>
                </p>

                @if (isset($qrCodeUrl))
                    <div class="mt-4 text-center">
                        <h5 class="text-secondary">Scan QR untuk akses sebagai pengunjung</h5>
                        <div class="d-inline-block p-2 bg-light rounded shadow-sm">
                            {!! QrCode::size(180)->generate($qrCodeUrl) !!}
                        </div>
                        <p class="mt-2 small text-muted">{{ $qrCodeUrl }}</p>
                    </div>
                @endif

                <!-- Buttons for Actions -->
                <div class="d-flex justify-content-between flex-wrap mt-4">
                    <a href="{{ route('buku.index') }}" class="btn btn-gradient-secondary mb-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('buku.edit', $buku) }}" class="btn btn-gradient-warning mb-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
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

        .btn-gradient-secondary {
            background: linear-gradient(90deg, #6c757d, #343a40);
            color: #fff;
            border: none;
        }

        .btn-gradient-secondary:hover {
            background: linear-gradient(90deg, #343a40, #6c757d);
            color: #fff;
        }

        .btn-gradient-warning {
            background: linear-gradient(90deg, #ffc107, #fd7e14);
            color: #fff;
            border: none;
        }

        .btn-gradient-warning:hover {
            background: linear-gradient(90deg, #fd7e14, #ffc107);
            color: #fff;
        }

        .card-header {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .card {
            border-radius: 12px;
        }

        .fw-bold {
            margin-bottom: 1rem;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.4em 0.6em;
            border-radius: 12px;
        }

        .text-center img {
            max-width: 300px;
        }
    </style>
@endsection
