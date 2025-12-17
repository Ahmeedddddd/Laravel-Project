<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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
    Route::get('/profiel', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profiel', [ProfileController::class, 'update'])->name('profile.update');
    // other profile-related authenticated routes (delete password/profile) can remain
});

require __DIR__.'/auth.php';
