@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1 class="fw-bold animate__animated animate__fadeInDown">
                <i></i>🧑🏻‍💻 Admin Dashboard
            </h1>
            <p class="text-muted animate__animated animate__fadeInUp">Kelola sistem perpustakaan dengan mudah</p>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <div class="row g-4">
            <!-- 🔧 Manajemen Pengguna -->
            <div class="col-md-4">
                <div class="card custom-card animate__animated animate__zoomIn">
                    <div class="card-body text-center">
                        <i class="fas fa-users icon-card text-primary"></i>
                        <h5 class="fw-semibold">Manajemen Pengguna</h5>
                        <p class="text-muted small">Kelola akun pengguna.</p>
                        <a href="{{ route('users.index') }}" class="btn btn-gradient-primary shadow-sm">
                            <i class="fas fa-user-cog"></i> Kelola Pengguna
                        </a>
                    </div>
                </div>
            </div>

            <!-- 📚 Manajemen Buku -->
            <div class="col-md-4">
                <div class="card custom-card animate__animated animate__zoomIn animate__delay-1s">
                    <div class="card-body text-center">
                        <i class="fas fa-book icon-card text-success"></i>
                        <h5 class="fw-semibold">Manajemen Buku</h5>
                        <p class="text-muted small">Atur koleksi buku perpustakaan.</p>
                        <a href="{{ route('buku.index') }}" class="btn btn-gradient-success shadow-sm">
                            <i class="fas fa-book-open"></i> Kelola Buku
                        </a>
                    </div>
                </div>
            </div>

            <!-- 📖 Manajemen Peminjaman -->
            <div class="col-md-4">
                <div class="card custom-card animate__animated animate__zoomIn animate__delay-2s">
                    <div class="card-body text-center">
                        <i class="fas fa-hand-holding icon-card text-warning"></i>
                        <h5 class="fw-semibold">Manajemen Peminjaman</h5>
                        <p class="text-muted small">Pantau aktivitas peminjaman.</p>
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-gradient-warning shadow-sm">
                            <i class="fas fa-list-alt"></i> Kelola Peminjaman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .text-gradient {
            background: linear-gradient(90deg, #007bff, #6610f2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .custom-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            background: linear-gradient(145deg, #f0f0f0, #ffffff);
            transition: all 0.3s ease-in-out;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        /* .custom-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
            } */

        .icon-card {
            font-size: 3.5rem;
            margin-bottom: 15px;
            transition: transform 0.3s ease-in-out;
        }

        .custom-card:hover .icon-card {
            transform: scale(1.2);
        }

        .btn {
            font-weight: bold;
            border-radius: 12px;
            padding: 10px 20px;
            transition: all 0.3s ease-in-out;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        .btn-gradient-primary {
            background: linear-gradient(90deg, #007bff, #6610f2);
            color: #fff;
            border: none;
        }

        .btn-gradient-primary:hover {
            background: linear-gradient(90deg, #6610f2, #007bff);
        }

        .btn-gradient-success {
            background: linear-gradient(90deg, #28a745, #20c997);
            color: #fff;
            border: none;
        }

        .btn-gradient-success:hover {
            background: linear-gradient(90deg, #20c997, #28a745);
        }

        .btn-gradient-warning {
            background: linear-gradient(90deg, #ffc107, #fd7e14);
            color: #fff;
            border: none;
        }

        .btn-gradient-warning:hover {
            background: linear-gradient(90deg, #fd7e14, #ffc107);
        }
    </style>
@endsection
