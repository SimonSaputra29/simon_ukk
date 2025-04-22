@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0 animate__animated animate__bounceIn">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">📖 Tambah Buku Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation"
                    novalidate>
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="text" name="judul" id="judul" class="form-control text-capitalize"
                            value="{{ old('judul') }}" required placeholder="Masukkan judul buku">
                        <label for="judul">Judul Buku</label>
                        <div class="invalid-feedback">Judul harus minimal 3 karakter.</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="penulis" id="penulis" class="form-control text-capitalize"
                            value="{{ old('penulis') }}" required placeholder="Masukkan nama penulis"
                            pattern="[A-Za-z\s]{3,100}">
                        <label for="penulis">Penulis</label>
                        <div class="invalid-feedback">Nama penulis harus minimal 3 karakter.</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="kategori" id="kategori" class="form-control text-capitalize"
                            value="{{ old('kategori') }}" required placeholder="Masukkan kategori">
                        <label for="kategori">Kategori</label>
                        <div class="invalid-feedback">Kategori tidak boleh kosong.</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" name="stok" id="stok" class="form-control"
                            value="{{ old('stok', 1) }}" required min="1" placeholder="Masukkan stok">
                        <label for="stok">Stok</label>
                        <div class="invalid-feedback">Stok harus minimal 1.</div>
                    </div>

                    <!-- Input untuk Gambar Buku -->
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Buku</label>
                        <input type="file" name="gambar" id="gambar" class="form-control" required accept="image/*">
                        <div class="invalid-feedback">Pilih gambar buku yang valid.</div>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap">
                        <a href="{{ route('buku.index') }}" class="btn btn-primary mb-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success mb-2 btn-hover">
                            <i class="fas fa-plus"></i> Tambah Buku
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
