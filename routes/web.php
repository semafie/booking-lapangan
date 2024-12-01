<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\jadwalController;
use App\Http\Controllers\lapanganController;
use App\Http\Controllers\Login_RegisterController;
use Illuminate\Support\Facades\Route;


Route::get('/', [Login_RegisterController::class, "show_login"])->name("login");
Route::get('/logout', [Login_RegisterController::class, "logout"]);
Route::post('/loginakun', [Login_RegisterController::class, "loginakun"])->name('loginakun');

Route::prefix('admin')->middleware("admin")->group(function () {
    Route::get('/dashboard', [adminController::class, 'show_dashboard'])->name('dashboard');
    Route::prefix('lapangan')->group(function () {
        Route::get('/', [adminController::class, 'show_lapangan'])->name('lapangan');
        Route::post('/tambah', [lapanganController::class, 'tambah'])->name('tambah_lapangan');
        Route::put('/{id}/edit', [lapanganController::class, 'edit'])->name('edit_lapangan');
        Route::delete('/{id}/delete', [lapanganController::class, 'delete'])->name('delete_lapangan');
    });
    Route::prefix('jadwal')->group(function () {
        Route::get('/{id}', [adminController::class, 'show_jadwal'])->name('jadwal');
        Route::post('/tambah', [jadwalController::class, 'tambah'])->name('tambah_jadwal');
        Route::put('/{id}/edit', [jadwalController::class, 'edit'])->name('edit_jadwal');
        Route::delete('/{id}/delete', [jadwalController::class, 'hapus'])->name('delete_jadwal');
    });
    Route::get('/transaksi', [adminController::class, 'show_transaksi'])->name('transaksi');
});
