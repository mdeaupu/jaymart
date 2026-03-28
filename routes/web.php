<?php

use App\Livewire\OwnerDashboard;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('dashboard', function () {
    if (auth()->user()->hasRole('owner')) {
        return redirect()->route('owner.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:owner'])->group(function () {
    Route::get('/dashboard/owner', OwnerDashboard::class)
        ->name('owner.dashboard');
    Route::get('/profile/owner', function () {
        return view('profile');
    })->name('owner.profile');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';