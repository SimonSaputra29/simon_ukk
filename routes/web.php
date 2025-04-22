<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LaporanPeminjamanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Admin
Route::middleware('auth', 'role:administrator')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/user', [UserController::class, 'index'])->name('users.index');
    Route::get('/admin/user/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/admin/user/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/admin/user/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/admin/user/create', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Petugas

Route::middleware('auth', 'role:petugas')->group(function () {
    Route::get('/petugas/dashboard', [PetugasController::class, 'index'])->name('petugas.index');
});

// Visitor
Route::middleware('auth', 'role:visitor')->group(function () {
    Route::get('/visitor/dashboard', [VisitorController::class, 'index'])->name('visitor.index');
    Route::post('/peminjaman/{id}/ajukan', [PeminjamanController::class, 'ajukanPengembalian'])->name('ajukan.kembali');
});

// Buku
Route::middleware('auth', 'role:administrator,petugas')->group(function () {
    Route::resource('/buku', BookController::class);
    Route::post('/peminjaman/{id}/setujui', [PeminjamanController::class, 'setujuiPeminjaman'])->name('peminjaman.setujui');
});

// Peminjaman
Route::middleware('auth', 'role:administrator,petugas,visitor')->group(function () {
    Route::resource('/peminjaman', PeminjamanController::class);
});

// Laporan
Route::middleware(['auth', 'role:administrator,petugas'])->group(function () {
    Route::get('/laporan/peminjaman/pdf', [LaporanPeminjamanController::class, 'generatePdf'])->name('laporan.peminjaman.pdf');
});

// Ulasan
Route::middleware(['auth'])->group(function () {
    // Menyimpan review buku
    Route::post('/review/{book}/reviews', [UlasanController::class, 'store'])
        ->name('review.ulasans.store');

    // Mengedit dan menghapus review
    Route::resource('ulasans', UlasanController::class)->except(['index', 'show']);
});

Route::get('/liatvisitor/{book}', [BookController::class, 'showVisitor'])->name('review.show');
