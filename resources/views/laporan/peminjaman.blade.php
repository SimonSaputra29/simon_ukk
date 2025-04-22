<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Buku</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4f46e5;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
        }

        td {
            font-size: 14px;
            color: #555;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e6f7ff;
        }

        .qr-code {
            width: 50px;
            height: 50px;
        }
    </style>
</head>

<body>
    <h2>Laporan Peminjaman Buku</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>QR Code</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjamans as $key => $peminjaman)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $peminjaman->user->name }}</td>
                    <td>{{ $peminjaman->book->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                    <td>{{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') : 'Belum dikembalikan' }}
                    </td>
                    <td>
                        <span
                            style="color: {{ $peminjaman->status === 'borrowed' ? 'orange' : ($peminjaman->status === 'returned' ? 'green' : 'blue') }}">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </td>
                    <td>
                        <img src="data:image/png;base64,{{ base64_encode($peminjaman->qrCode) }}" class="qr-code"
                            alt="QR Code">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
