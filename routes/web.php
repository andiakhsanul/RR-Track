<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Protected Routes (Auth Required)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
