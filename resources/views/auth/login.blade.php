@extends('layouts.app')

@section('content')
    <div class="min-vh-100 d-flex align-items-center justify-content-center position-relative border-0 rounded-4 overflow-hidden"
        style="background: url('{{ asset('asset/formLogin.jpg') }}') no-repeat center center / cover; margin-bottom:25px; border-radius:15px;">

        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0,0,0,0.5);"></div>

        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow border-0 rounded-4 overflow-hidden" style="border-radius:15px;">
                        <div class="text-center p-4 text-white" style="background: #4f46e5;">
                            <i class="fas fa-user-circle fa-3x mb-2"></i>
                            <h4 class="fw-bold mb-1">Masuk ke Akunmu</h4>
                            <p class="text-white-50 mb-0">Yuk, masuk dengan email dan password!</p>
                        </div>

                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Masukkan Email..." value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Masukkan Password..." required>
                                        <button type="button" class="input-group-text" id="togglePassword">
                                            <i class="fas fa-eye" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Login Button --}}
                                <div class="d-grid mb-3">
                                    <button id="loginBtn" class="btn btn-primary py-2" type="submit">
                                        Masuk
                                    </button>
                                </div>

                                {{-- Register Link --}}
                                <div class="text-center">
                                    <small class="text-muted">Belum punya akun? <a href="{{ route('register') }}"
                                            class="text-primary text-decoration-none">Daftar sekarang</a></small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#4f46e5'
                });
            </script>
        @endif

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#4f46e5'
                });
            </script>
        @endif
    @endsection
