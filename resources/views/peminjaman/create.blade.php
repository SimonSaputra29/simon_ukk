@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="mx-auto" style="max-width: 600px;">
            <div class="card border-0 shadow rounded-4 animate__animated animate__tada">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h4 class="mb-0"><i class="bi bi-book"></i> Pinjam Buku</h4>
                </div>

                <div class="card-body p-4">

                    @if (session('error'))
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif

                    <form action="{{ route('peminjaman.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="id_buku" class="form-label fw-semibold">📚 Pilih Buku</label>
                            <select name="id_buku" id="id_buku" class="form-select" required>
                                <option value="" disabled selected>-- Pilih salah satu buku --</option>
                                @foreach ($books as $buku)
                                    <option value="{{ $buku->id }}">{{ $buku->judul }} (Stok: {{ $buku->stok }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Silakan pilih buku yang ingin dipinjam.</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('visitor.index') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle-fill"></i> Pinjam
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
