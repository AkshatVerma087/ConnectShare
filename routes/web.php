<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Show the landing page to guests, and send logged-in users to the dashboard.
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : view('welcome', [
            'resourceCount' => cache()->remember('stats.resources', now()->addDay(), fn () => \App\Models\Resource::count()),
            'userCount' => cache()->remember('stats.users', now()->addDay(), fn () => \App\Models\User::count()),
        ]);
});

Route::get('/welcome', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : view('welcome', [
            'resourceCount' => cache()->remember('stats.resources', now()->addDay(), fn () => \App\Models\Resource::count()),
            'userCount' => cache()->remember('stats.users', now()->addDay(), fn () => \App\Models\User::count()),
        ]);
});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Resource CRUD (create, store, edit, update, destroy)
    Route::resource('resources', ResourceController::class)
        ->except(['index', 'show']);

    // My Resources page
    Route::get('/my-resources', [ResourceController::class, 'myResources'])
        ->name('resources.my');

    // Profile routes from Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public routes
Route::resource('resources', ResourceController::class)
    ->only(['index', 'show']);

// Dashboard view
Route::get('/dashboard', function () {
    $baseQuery = \App\Models\Resource::where('user_id', Auth::id());

    return view('dashboard', [
        'activeListings' => (clone $baseQuery)->where('status', 'active')->count(),
        'pausedListings' => (clone $baseQuery)->where('status', 'paused')->count(),
        'totalListings' => (clone $baseQuery)->count(),
        'categoriesUsed' => (clone $baseQuery)->distinct('category_id')->count('category_id'),
        'lastUpdatedAt' => (clone $baseQuery)->orderByDesc('updated_at')->value('updated_at'),
        'recentResources' => (clone $baseQuery)->with('category')->orderByDesc('updated_at')->limit(5)->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// (debug route removed)

require __DIR__.'/auth.php';
