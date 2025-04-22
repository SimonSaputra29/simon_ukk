@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0 animate__animated animate__flipInX">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">✏️ Edit Pengguna</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="form-floating mb-3">
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $user->name) }}" required placeholder="Masukkan Nama user">
                        <label for="name">Masukkan Nama</label>
                        <div class="invalid-feedback">name tidak boleh kosong.</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email', $user->email) }}" required placeholder="Masukkan Email">
                        <label for="email">Masukkan Email</label>
                        <div class="invalid-feedback">Email tidak boleh kosong.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Role:</label>
                        <select name="role" class="form-select" required>
                            <option value="visitor" {{ $user->role === 'visitor' ? 'selected' : '' }}>Visitor</option>
                            <option value="petugas" {{ $user->role === 'petugas' ? 'selected' : '' }}>Petugas</option>
                            </option>
                        </select>
                        @error('role')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password"
                            class="form-control"value="{{ old('password', $user->password) }}"
                            placeholder="Kosongkan jika tidak diganti">
                        <label class="form-label fw-semibold">Password Baru (opsional):</label>
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Ulangi password baru">
                        <label class="form-label fw-semibold">Konfirmasi Password:</label>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gradient-primary btn-hover text-white">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-gradient-secondary btn-hover text-white">
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
