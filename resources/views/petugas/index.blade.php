@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <h2 class="fw-bold text-center mb-4 text-gradient animate__animated animate__backInUp">🥷Halaman Petugas</h2>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3 animate__animated animate__zoomIn">
            <a href="{{ url('/peminjaman') }}" class="btn btn-outline-primary shadow-sm">
                <i class="fas fa-list"></i> Kelola Peminjaman
            </a>
            <a href="{{ route('buku.index') }}" class="btn btn-outline-primary shadow-sm">
                <i class="fas fa-book"></i> Kelola Buku
            </a>
        </div>

        <div class="table-responsive animate__animated animate__bounceIn">
            @php
                $warnaStatus = [
                    'borrowed' => 'warning',
                    'waiting_approval' => 'info',
                    'returned' => 'success',
                ];

                $teksStatus = [
                    'borrowed' => 'Dipinjam',
                    'waiting_approval' => 'Menunggu Persetujuan',
                    'returned' => 'Selesai',
                ];

                $peran = Auth::user()->role ?? 'user';
            @endphp

            <table class="table table-striped text-center align-middle custom-table">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Buku</th>
                        <th>Stok Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman as $key => $pinjam)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="fw-semibold">{{ $pinjam->user->name }}</td>
                            <td>{{ $pinjam->book->judul }}</td>
                            <td>
                                <span class="badge bg-{{ $pinjam->book->stok > 0 ? 'success' : 'danger' }}">
                                    {{ $pinjam->book->stok > 0 ? $pinjam->book->stok : 'Habis' }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $warnaStatus[$pinjam->status] ?? 'secondary' }}">
                                    {{ $teksStatus[$pinjam->status] ?? ucfirst($pinjam->status) }}
                                </span>
                            </td>
                            <td>
                                @if ($pinjam->status === 'borrowed')
                                    @if ($peran === 'petugas')
                                        <span class="text-muted">Dipinjam</span>
                                    @else
                                        <form action="{{ route('peminjaman.ajukan', $pinjam->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm shadow-sm">
                                                <i class="fas fa-paper-plane me-1"></i> Ajukan Pengembalian
                                            </button>
                                        </form>
                                    @endif
                                @elseif ($pinjam->status === 'waiting_approval')
                                    <span class="text-muted">Menunggu Konfirmasi</span>
                                @else
                                    <span class="text-muted">Sudah Kembali</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">Tidak ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
