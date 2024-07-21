<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\RuangController;
use App\Http\Middleware\UserStatus;
use App\Models\Ruang;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $ruang = Ruang::get();
    return view('welcome', compact("ruang"));
})->name('home');

Route::controller(PagesController::class)->group(function() {
    Route::get('/ruang-detail/{id}', 'ruang_detail')->name('ruang-detail');
});

Route::middleware([UserStatus::class . ':mahasiswa,dosen,umum'])->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::controller(ProsesController::class)->group(function() {
            Route::post('/simpan-reservasi', 'simpan_reservasi')->name('simpan-reservasi');
        });
    });
});

Route::middleware([UserStatus::class . ':admin'])->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        
        Route::resource('/ruang', RuangController::class);

        Route::resource('/reservasi', ReservasiController::class);
        Route::controller(ReservasiController::class)->group(function() {
            Route::get('/terima/{id}', 'terima')->name('terima');
            Route::get('/tolak/{id}', 'tolak')->name('tolak');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
