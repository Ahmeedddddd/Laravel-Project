<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminFaqCategoryController;
use App\Http\Controllers\Admin\AdminFaqItemController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminContactMessageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqPublicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\NewsPublicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\User\MailboxController;
use Illuminate\Support\Facades\Route;

// Public homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public members (search)
Route::get('/members', [MembersController::class, 'index'])->name('members.index');

// Public news
Route::get('/news', [NewsPublicController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsPublicController::class, 'show'])->name('news.show');

// Public FAQ
Route::get('/faq', [FaqPublicController::class, 'index'])->name('faq.index');

// Public Contact
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Remove separate dashboard: homepage is the start page for everyone.
// Route::get('/dashboard', [DashboardController::class, 'index'])
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Public profile view (anyone) - required URL structure:
Route::get('/users/{username}', [PublicProfileController::class, 'show'])->name('public.users.show');

// Backwards compatible Dutch URL (keep existing links working)
Route::get('/profiel/{username}', function (string $username) {
    return redirect()->route('public.users.show', ['username' => $username], 301);
})->name('profile.show');

// Authenticated routes for editing own profile
Route::middleware(['auth'])->group(function () {
    // Auth-only user search (public profile results)
    Route::get('/users', [UserSearchController::class, 'index'])->name('users.search');
    Route::get('/users/suggest', [UserSearchController::class, 'suggest'])->name('users.suggest');

    // RESTORE: /profile should be the full profile editor (avatar, bio, etc.)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [AccountController::class, 'destroy'])->name('profile.destroy');

    // Account settings (Breeze-compatible) moved to /account to avoid conflicts
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');

    // User mailbox
    Route::get('/account/messages', [MailboxController::class, 'index'])->name('account.messages.index');
    Route::get('/account/messages/{message}', [MailboxController::class, 'show'])->name('account.messages.show');
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
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // News CRUD
        Route::resource('news', AdminNewsController::class)->except(['show']);

        // FAQ categories CRUD
        Route::resource('faq/categories', AdminFaqCategoryController::class)
            ->parameters(['categories' => 'category'])
            ->except(['show']);

        // FAQ items CRUD
        Route::resource('faq/items', AdminFaqItemController::class)
            ->parameters(['items' => 'item'])
            ->except(['show']);

        // Contact inbox (mailbox)
        Route::get('/contact', [AdminContactMessageController::class, 'index'])->name('contact.index');
        Route::get('/contact/{message}', [AdminContactMessageController::class, 'show'])->name('contact.show');
        Route::post('/contact/{message}/reply', [AdminContactMessageController::class, 'reply'])->name('contact.reply');

        // Backwards-compatible endpoints (can be removed later)
        Route::patch('/users/{user}/make-admin', [AdminUserController::class, 'makeAdmin'])->name('users.make');
        Route::patch('/users/{user}/revoke-admin', [AdminUserController::class, 'revokeAdmin'])->name('users.revoke');
    });

require __DIR__.'/auth.php';
