<?php

use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\Dashboard\DashboardController as UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    });


    Route::prefix('user')->name('user.')->middleware('role:user')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard.index');
    });
});


require __DIR__ . '/auth.php';
