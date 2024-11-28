<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\lapanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [adminController::class, 'show_dashboard'])->name('dashboard');
    Route::prefix('lapangan')->group(function () {
        Route::get('/', [adminController::class, 'show_lapangan'])->name('lapangan');
        Route::post('/tambah', [lapanganController::class, 'tambah'])->name('tambah_lapangan');
        Route::put('/{id}/edit', [lapanganController::class, 'edit'])->name('edit_lapangan');
        Route::delete('/{id}/delete', [lapanganController::class, 'delete'])->name('delete_lapangan');
    });

    Route::get('/jadwal', [adminController::class, 'show_jadwal'])->name('jadwal');
    Route::get('/transaksi', [adminController::class, 'show_transaksi'])->name('transaksi');
});
