<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login or dashboard
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Protected Routes (Auth Required)
Route::middleware('auth')->group(function () {
    // Profile Routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Laporan Repeat Routes
    Route::prefix('laporan/repeat')->name('laporan.repeat.')->group(function () {
        Route::get('/', [LaporanController::class, 'indexRepeat'])->name('index');
        Route::get('/create', [LaporanController::class, 'createRepeat'])->name('create');
        Route::post('/', [LaporanController::class, 'storeRepeat'])->name('store');
        Route::get('/{laporan}', [LaporanController::class, 'showRepeat'])->name('show');
        Route::get('/{laporan}/edit', [LaporanController::class, 'editRepeat'])->name('edit');
        Route::put('/{laporan}', [LaporanController::class, 'updateRepeat'])->name('update');
        Route::delete('/{laporan}', [LaporanController::class, 'destroy'])->name('destroy');
    });

    // Laporan Reject Routes
    Route::prefix('laporan/reject')->name('laporan.reject.')->group(function () {
        Route::get('/', [LaporanController::class, 'indexReject'])->name('index');
        Route::get('/create', [LaporanController::class, 'createReject'])->name('create');
        Route::post('/', [LaporanController::class, 'storeReject'])->name('store');
        Route::get('/{laporan}', [LaporanController::class, 'showReject'])->name('show');
        Route::get('/{laporan}/edit', [LaporanController::class, 'editReject'])->name('edit');
        Route::put('/{laporan}', [LaporanController::class, 'updateReject'])->name('update');
        Route::delete('/{laporan}', [LaporanController::class, 'destroy'])->name('destroy');
    });
});

// Auth Routes (from Breeze)
require __DIR__.'/auth.php';
