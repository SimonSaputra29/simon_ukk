@extends('layouts.app')

@section('content')
    <div class="min-vh-100 d-flex align-items-center justify-content-center border-0 rounded-4 overflow-hidden"
        style="background: url('{{ asset('asset/formLogin.jpg') }}') no-repeat center center; background-size: cover; filter: blur(0.3px); margin-bottom: 25px; border-radius:15px;">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0,0,0,0.5);"></div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow border-0 rounded-4 overflow-hidden mb-5" style="border-radius:15px;">
                        <div class="text-center p-4 text-white"
                            style="background: linear-gradient(135deg, #4f46e5, #3b82f6);">
                            <i class="fas fa-user-plus fa-3x mb-2"></i>
                            <h4 class="fw-bold mb-1">Buat Akun Baru</h4>
                            <p class="text-white-50 mb-0">Isi data untuk mendaftar</p>
                        </div>

                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                {{-- Nama --}}
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-user text-primary"></i>
                                        </span>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Nama lengkap..." value="{{ old('name') }}" required autofocus>
                                    </div>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-envelope text-primary"></i>
                                        </span>
                                        <input type="email" name="email" id="email" class="form-control"
                                            placeholder="Email aktif..." value="{{ old('email') }}" required>
                                    </div>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label">Kata sandi</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-lock text-primary"></i>
                                        </span>
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Buat password..." required>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Konfirmasi Password --}}
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Kata sandi</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-lock text-primary"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control" placeholder="Ulangi password..." required>
                                    </div>
                                </div>

                                {{-- Tombol Daftar --}}
                                <div class="d-grid mb-3">
                                    <button id="registerBtn" class="btn btn-primary py-2" type="submit">
                                        <span id="registerText">Daftar</span>
                                        <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none"
                                            role="status" aria-hidden="true"></span>
                                    </button>
                                </div>

                                {{-- Link ke Login --}}
                                <div class="text-center">
                                    <small class="text-muted">Sudah punya akun?
                                        <a href="{{ route('login') }}"
                                            class="text-decoration-none fw-semibold text-primary">Masuk sekarang</a>
                                    </small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    {{-- Validasi Kosong --}}
    <script>
        document.getElementById("registerBtn").addEventListener("click", function(event) {
            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();
            const confirmPassword = document.getElementById("password_confirmation").value.trim();

            if (!name || !email || !password || !confirmPassword) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Mohon isi semua kolom!',
                    confirmButtonColor: '#4f46e5'
                });
            } else if (password !== confirmPassword) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Password dan konfirmasi tidak cocok!',
                    confirmButtonColor: '#4f46e5'
                });
            } else {
                document.getElementById("registerText").classList.add("d-none");
                document.getElementById("loadingSpinner").classList.remove("d-none");
            }
        });
    </script>
@endsection
