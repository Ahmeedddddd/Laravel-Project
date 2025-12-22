<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqPublicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsPublicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Support\Facades\Route;

// Public homepage (guest) + search (GET)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public news
Route::get('/news', [NewsPublicController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsPublicController::class, 'show'])->name('news.show');

// Public FAQ
Route::get('/faq', [FaqPublicController::class, 'index'])->name('faq.index');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Public profile view (anyone) - required URL structure:
Route::get('/users/{username}', [PublicProfileController::class, 'show'])->name('public.users.show');

// Backwards compatible Dutch URL (keep existing links working)
Route::get('/profiel/{username}', function (string $username) {
    return redirect()->route('public.users.show', ['username' => $username], 301);
})->name('profile.show');

// Authenticated routes for editing own profile
Route::middleware(['auth'])->group(function () {
    // RESTORE: /profile should be the full profile editor (avatar, bio, etc.)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [AccountController::class, 'destroy'])->name('profile.destroy');

    // Account settings (Breeze-compatible) moved to /account to avoid conflicts
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');

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

        // News CRUD
        Route::resource('news', AdminNewsController::class)->except(['show']);

        // Backwards-compatible endpoints (can be removed later)
        Route::patch('/users/{user}/make-admin', [AdminUserController::class, 'makeAdmin'])->name('users.make');
        Route::patch('/users/{user}/revoke-admin', [AdminUserController::class, 'revokeAdmin'])->name('users.revoke');
    });

require __DIR__.'/auth.php';
