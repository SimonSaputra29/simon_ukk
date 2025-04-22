@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0 animate__animated animate__flipInX">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">✏️ Edit Buku</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('buku.update', $buku) }}" method="POST" class="needs-validation" novalidate
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-floating mb-3">
                        <input type="file" name="gambar" id="gambar" class="form-control mb-3" required
                            placeholder="Masukkan gambar Buku" accept="image/*">
                        <label for="gambar">📖 Gambar</label>
                        @if ($buku->gambar)
                            <div class="mt-2">
                                <img src="{{ asset('storage/books/' . $buku->gambar) }}" alt="Current Image"
                                    class="img-fluid" style="max-width: 100px;">
                            </div>
                        @endif
                        <div class="invalid-feedback">Gambar tidak boleh kosong.</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="judul" id="judul" class="form-control"
                            value="{{ old('judul', $buku->judul) }}" required placeholder="Masukkan Judul Buku">
                        <label for="judul">📖 Judul</label>
                        <div class="invalid-feedback">Judul tidak boleh kosong.</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="penulis" id="penulis" class="form-control"
                            value="{{ old('penulis', $buku->penulis) }}" required placeholder="Masukkan Nama Penulis">
                        <label for="penulis">✍️ Penulis</label>
                        <div class="invalid-feedback">Nama penulis tidak boleh kosong.</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="kategori" id="kategori" class="form-control text-capitalize"
                            value="{{ old('kategori', $buku->kategori) }}" required placeholder="Masukkan Kategori Buku">
                        <label for="kategori">🏷️ Kategori</label>
                        <div class="invalid-feedback">Kategori tidak boleh kosong.</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" name="stok" id="stok" class="form-control"
                            value="{{ old('stok', $buku->stok) }}" min="0" required placeholder="Masukkan Stok Buku">
                        <label for="stok">📦 Stok</label>
                        <div class="invalid-feedback">Stok tidak boleh kosong dan minimal 0.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gradient-primary btn-hover text-white">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('buku.index') }}" class="btn btn-gradient-secondary btn-hover text-white">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    .text-gradient {
        background: linear-gradient(90deg, #007bff, #6610f2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
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

    .btn-gradient-secondary {
        background: linear-gradient(90deg, #6c757d, #343a40);
        color: #fff;
        border: none;
    }

    .btn-gradient-secondary:hover {
        background: linear-gradient(90deg, #343a40, #6c757d);
        color: #fff;
    }
</style>
