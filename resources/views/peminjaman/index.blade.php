@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @switch(auth()->user()->role)
            @case('administrator')
            @case('petugas')
                <h2
                    class="d-flex justify-content-between align-items-center mb-4 fw-bold text-gradient animate__animated animate__lightSpeedInRight">
                    📋 Daftar Peminjaman Buku
                </h2>
            @break

            @case('visitor')
                <h2
                    class="d-flex justify-content-between align-items-center mb-4 fw-bold text-gradient animate__animated animate__lightSpeedInRight">
                    Riwayat Peminjaman Buku Saya
                </h2>
            @break
        @endswitch

        {{-- Filter Form --}}
        <form action="{{ route('peminjaman.index') }}" method="GET"
            class="mb-4 d-flex justify-content-between align-items-center flex-wrap animate__animated animate__zoomIn">
            <div class="input-group col-md-8 mb-2">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama atau Judul Buku"
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2 mb-2">
                <button type="submit" class="btn btn-success w-100">Cari</button>
            </div>
            <div class="form-group col-md-3 mb-2">
                <select name="status" class="form-select">
                    <option value="">Status</option>
                    <option value="borrowed" {{ request('status') === 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="waiting_approval" {{ request('status') === 'waiting_approval' ? 'selected' : '' }}>
                        Menunggu Persetujuan</option>
                    <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
            </div>
            <div class="form-group col-md-3 mb-2">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
        </form>

        @switch(auth()->user()->role)
            @case('administrator')
            @case('petugas')
                <div class="animate__animated animate__zoomIn mb-4 d-flex justify-content-between">
                    <a href="{{ route(auth()->user()->role == 'administrator' ? 'admin.index' : 'petugas.index') }}"
                        class="btn btn-primary shadow-sm mb-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ url('/laporan/peminjaman/pdf') }}" class="btn btn-danger shadow-sm mb-2">
                        <i class="fas fa-file-pdf"></i> Cetak Laporan
                    </a>
                </div>
            @break

            @case('visitor')
                <a href="{{ route('visitor.index') }}" class="btn btn-primary shadow-sm mb-2 animate__animated animate__zoomInLeft">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            @break
        @endswitch

        {{-- Tabel Peminjaman --}}
        <div class="table-responsive animate__animated animate__zoomInLeft" style="border-radius: 12px;">
            <table class="table table-bordered text-left custom-table align-middle table-striped">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Nama Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Gambar Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                        <th class="text-center">QR Code</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $statusMap = [
                            'borrowed' => ['warning', 'Dipinjam'],
                            'waiting_approval' => ['info', 'Menunggu Persetujuan'],
                            'waiting_return_approval' => ['primary', 'Menunggu Persetujuan Pengembalian'],
                            'returned' => ['success', 'Dikembalikan'],
                        ];
                    @endphp

                    @forelse ($peminjaman as $key => $pinjam)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ $pinjam->user->name ?? 'User Tidak Ditemukan' }}</td>
                            <td>{{ $pinjam->book->judul ?? 'Buku Tidak Ditemukan' }}</td>
                            <td class="text-center">
                                @if ($pinjam->book->gambar)
                                    <img src="{{ asset('storage/books/' . $pinjam->book->gambar) }}"
                                        alt="{{ $pinjam->book->judul }}" width="70" height="75"
                                        class="img-thumbnail">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $pinjam->tanggal_pinjam ?? '-' }}</td>
                            <td>{{ $pinjam->tanggal_kembali ?? '-' }}</td>
                            <td>
                                @php
                                    $badgeClass = $statusMap[$pinjam->status][0] ?? 'secondary';
                                    $badgeText = $statusMap[$pinjam->status][1] ?? 'Status Tidak Dikenal';
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ $badgeText }}</span>
                            </td>
                            <td>
                                @if (auth()->id() === $pinjam->id_user && $pinjam->status === 'borrowed')
                                    <form action="{{ route('ajukan.kembali', $pinjam->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning shadow-sm"
                                            title="Ajukan Pengembalian">
                                            Ajukan Kembali
                                        </button>
                                    </form>
                                @endif

                                @if (auth()->user()->role === 'petugas' && $pinjam->status === 'waiting_approval')
                                    <form action="{{ route('peminjaman.setujui', $pinjam->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success shadow-sm"
                                            title="Setujui Peminjaman">
                                            Setujui
                                        </button>
                                    </form>
                                @endif

                                @if (auth()->user()->role === 'administrator' && $pinjam->status === 'waiting_approval')
                                    <form action="{{ route('peminjaman.setujui', $pinjam->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success shadow-sm"
                                            title="Setujui Peminjaman">
                                            Setujui
                                        </button>
                                    </form>
                                @endif

                                @if (auth()->user()->role === 'petugas' && $pinjam->status === 'waiting_return_approval')
                                    <form action="{{ route('peminjaman.setujuiPengembalian', $pinjam->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary shadow-sm"
                                            title="Setujui Pengembalian">
                                            Setujui Pengembalian
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="text-center">
                                {!! QrCode::size(70)->generate(route('books.show', $pinjam->id_buku)) !!}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-muted text-center">📚 Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    @endsection
