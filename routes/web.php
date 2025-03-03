<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\Admin\AdminPelangganController;
use App\Http\Controllers\Admin\AdminProdukController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Admin\AdminTransaksiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StrukController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


// Halaman utama
Route::get('/', function () {
    return view('landingpage');
});

// Dashboard (hanya untuk user yang sudah login dan terverifikasi)
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Group middleware untuk route yang membutuhkan autentikasi
Route::middleware('auth')->group(function () {
    // Profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD untuk pelanggan, produk, dan penjualan (hanya bisa diakses setelah login)
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('penjualan', PenjualanController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::get('/struk/cetak/{id}', [StrukController::class, 'cetak'])->name('struk.cetak');






});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('pelanggan', AdminPelangganController::class);
    Route::resource('produk', AdminProdukController::class);
    Route::resource('transaksi', AdminTransaksiController::class);
});





// Autentikasi (login, register, dll.)
require __DIR__ . '/auth.php';
