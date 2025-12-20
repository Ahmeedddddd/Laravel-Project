<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Public profile view (anyone)
Route::get('/profiel/{username}', [ProfileController::class, 'show'])->name('profile.show');

// Authenticated routes for editing own profile
Route::middleware(['auth'])->group(function () {
    // Account settings (Breeze-compatible)
    Route::get('/profile', [AccountController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AccountController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [AccountController::class, 'destroy'])->name('profile.destroy');

    // Existing custom profile editor (Dutch URL)
    Route::get('/profiel', [ProfileController::class, 'edit']);
    Route::patch('/profiel', [ProfileController::class, 'update']);
});

// Admin routes
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');

        Route::patch('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggleAdmin');

        // Backwards-compatible endpoints (can be removed later)
        Route::patch('/users/{user}/make-admin', [AdminUserController::class, 'makeAdmin'])->name('users.make');
        Route::patch('/users/{user}/revoke-admin', [AdminUserController::class, 'revokeAdmin'])->name('users.revoke');
    });

require __DIR__.'/auth.php';
