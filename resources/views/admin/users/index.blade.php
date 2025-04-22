@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__rollIn ">
            <h2 class="fw-bold text-gradient">
                👥 Daftar Pengguna
            </h2>
            <a href="{{ route('admin.index') }}" class="btn btn-gradient-primary shadow-sm">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('users.create') }}"
                class="btn btn-success shadow-sm btn-hover animate__animated animate__fadeInRight">
                <i class="fas fa-plus"></i> Tambah Pengguna
            </a>
        </div>


        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive animate__animated animate__jackInTheBox">
            <table class="table text-left custom-table table-striped ">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $key => $user)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="text-left">{{ $user->name }}</td>
                            <td class="text-left">{{ $user->email }}</td>
                            <td>
                                <span
                                    class="badge role-badge 
                                    {{ $user->role == 'administrator'
                                        ? 'bg-danger'
                                        : ($user->role == 'petugas'
                                            ? 'bg-warning'
                                            : 'bg-primary') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    @if ($user->role !== 'administrator')
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="btn btn-warning btn-sm shadow-sm btn-hover animate__animated animate__zoomIn">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button
                                            class="btn btn-danger btn-sm shadow-sm btn-hover animate__animated animate__zoomIn"
                                            data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                                            data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    @else
                                        <span class="text-muted small fst-italic">Aksi tidak tersedia</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">Belum ada pengguna terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah kamu yakin ingin menghapus pengguna <strong id="userName">ini</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("confirmDeleteModal");
            modal.addEventListener("show.bs.modal", function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute("data-id");
                const name = button.getAttribute("data-name");

                modal.querySelector("#userName").textContent = name;
                modal.querySelector("#deleteForm").action = `/users/${id}`;
            });
        });
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .custom-table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.05);
            transition: background-color 0.3s ease-in-out;
        }

        .role-badge {
            font-size: 0.85rem;
            padding: 0.4em 0.8em;
            border-radius: 20px;
        }

        .btn-edit {
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .btn-edit:hover {
            transform: scale(1.1);
        }

        .btn-gradient-primary {
            background: linear-gradient(90deg, #007bff, #6610f2);
            color: #fff;
            border: none;
        }

        .btn-gradient-primary:hover {
            background: linear-gradient(90deg, #6610f2, #007bff);
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
    </style>
@endsection
