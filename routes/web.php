<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuangController;
use App\Http\Middleware\UserStatus;
use App\Models\Ruang;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $ruang = Ruang::get();
    return view('welcome', compact("ruang"));
})->name('home');

Route::get('/ruang-detail/{id}', [PagesController::class, 'ruang_detail'])->name('ruang-detail');

Route::middleware([UserStatus::class . ':admin'])->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });

    Route::resource('/ruang', RuangController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
