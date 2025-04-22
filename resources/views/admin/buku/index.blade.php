@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__rollIn ">
            <h2 class="fw-bold text-gradient">
                📚 Daftar Buku
            </h2>
            @switch(auth()->user()->role)
                @case('administrator')
                    <a href="{{ route('admin.index') }}" class="btn btn-gradient-primary text-white">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                @break

                @case('petugas')
                    <a href="{{ route('petugas.index') }}" class="btn btn-gradient-primary text-white">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                @break
            @endswitch
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('buku.create') }}"
                class="btn btn-success shadow-sm btn-hover animate__animated animate__fadeInRight">
                <i class="fas fa-plus"></i> Tambah Buku
            </a>
        </div>

        <div class="table-responsive animate__animated animate__fadeInUp" style="border-radius: 12px">
            <table class="table table-striped table-bordered text-left align-middle custom-table">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($buku as $key => $book)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="text-center">
                                @if ($book->gambar)
                                    <img src="{{ asset('storage/books/' . $book->gambar) }}" alt="{{ $book->judul }}"
                                        width="50" height="75" class="img-thumbnail">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $book->judul }}</td>
                            <td>{{ $book->penulis }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $book->kategori }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $book->stok > 0 ? 'success' : 'danger' }}">
                                    {{ $book->stok > 0 ? $book->stok : 'Habis' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('buku.show', $book) }}"
                                        class="btn btn-info btn-sm shadow-sm btn-hover animate__animated animate__zoomIn">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('buku.edit', $book) }}"
                                        class="btn btn-warning btn-sm shadow-sm btn-hover animate__animated animate__zoomIn">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button
                                        class="btn btn-danger btn-sm shadow-sm btn-hover animate__animated animate__zoomIn"
                                        data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                                        data-id="{{ $book->id }}" data-title="{{ $book->judul }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog animate__animated animate__fadeIn">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus buku <strong id="bookTitle"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("confirmDeleteModal");
            modal.addEventListener("show.bs.modal", function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute("data-id");
                const title = button.getAttribute("data-title");
                modal.querySelector("#bookTitle").textContent = title;
                modal.querySelector("#deleteForm").action = "/buku/" + id;
            });
        });
    </script>
@endsection
<style>
    .btn-gradient-primary {
        background: linear-gradient(90deg, #007bff, #6610f2);
        color: #fff;
        border: none;
    }

    .btn-gradient-primary:hover {
        background: linear-gradient(90deg, #6610f2, #007bff);
        color: #fff;
    }
</style>
