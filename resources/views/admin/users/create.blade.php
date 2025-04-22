@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0 animate__animated animate__bounceIn">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">📖 Tambah Pengguna Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation"
                    novalidate>
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="text" name="name" id="name" class="form-control text-capitalize"
                            value="{{ old('name') }}" required placeholder="Masukkan nama Pengguna" minlength="3">
                        <label for="name">Nama</label>
                        <div class="invalid-feedback">Nama harus minimal 3 karakter.</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                            required placeholder="Masukkan email">
                        <label for="email">Email</label>
                        <div class="invalid-feedback">Format email tidak valid.</div>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role</option>
                            <option value="administrator" {{ old('role') == 'administrator' ? 'selected' : '' }}>
                                Administrator</option>
                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="visitor" {{ old('role') == 'visitor' ? 'selected' : '' }}>Visitor</option>
                        </select>
                        <div class="invalid-feedback">Silakan pilih role pengguna.</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password" id="password" class="form-control text-capitalize" required
                            minlength="6" placeholder="Masukan Password">
                        <label for="password">Masukan Password</label>
                        <div class="invalid-feedback">Password minimal 6 karakter.</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            required placeholder="Konfirmasi Password">
                        <label for="password_confirmation" class="form-label text-capitalize">Konfirmasi Password</label>
                        <div class="invalid-feedback">Konfirmasi password tidak sesuai.</div>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap">
                        <a href="{{ route('users.index') }}" class="btn btn-primary mb-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success mb-2 btn-hover">
                            <i class="fas fa-plus"></i> Tambah Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
