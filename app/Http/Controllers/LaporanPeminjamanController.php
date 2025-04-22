<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Peminjaman;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LaporanPeminjamanController extends Controller
{
    public function generatePdf()
    {
        $peminjamans = Peminjaman::with(['user', 'book'])->get(); // Ambil data peminjaman

        // Generate QR code untuk setiap peminjaman
        foreach ($peminjamans as $peminjaman) {
            $peminjaman->qrCode = QrCode::format('png')->size(150)->generate(route('peminjaman.show', $peminjaman->id));
        }

        // Load view dan generate PDF
        $pdf = Pdf::loadView('laporan.peminjaman', compact('peminjamans'));

        return $pdf->download('laporan-peminjaman.pdf'); // Download PDF
    }
}
 