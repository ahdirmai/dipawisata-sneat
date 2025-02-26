<?php

use App\Http\Controllers\Admin\Blog\CategoryController;
use App\Http\Controllers\Admin\Blog\PostController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\Dashboard\DashboardController as UserDashboardController;
use App\Livewire\Admin\Blog\Post\FormPost;
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


        // blog routes
        route::prefix('blog')->name('blog.')->group(function () {
            Route::prefix('category')->name('category.')->group(function () {
                Route::get('/', [CategoryController::class, 'index'])->name('index');
            });

            Route::prefix('post')->name('post.')->group(function () {
                Route::get('/', [PostController::class, 'index'])->name('index');
                Route::get('/create', [PostController::class, 'create'])->name('create');
                Route::post('/store', [PostController::class, 'store'])->name('store');

                Route::get('/edit/{post}', [PostController::class, 'edit'])->name('edit');
                Route::patch('/update/{post}', [PostController::class, 'update'])->name('update');

                Route::delete('/destroy/{post}', [PostController::class, 'destroy'])->name('destroy');

                Route::get('/show/{post}', [PostController::class, 'show'])->name('show');

                Route::Patch('/publish/{post}', [PostController::class, 'publish'])->name('togglePublish');
            });
        });
    });


    Route::prefix('user')->name('user.')->middleware('role:user')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard.index');
    });
});


require __DIR__ . '/auth.php';
