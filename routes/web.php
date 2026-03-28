<?php

use App\Livewire\BranchManagement;
use App\Livewire\OwnerDashboard;
use App\Livewire\UserManagement;
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

    Route::get('/report/owner', \App\Livewire\Report\MainTransactionReport::class)
        ->name('owner.report.main');

    Route::middleware(['auth', 'role:owner'])->group(function () {
        Route::get('/owner/users', UserManagement::class)->name('owner.users');
    });

    Route::middleware(['auth', 'role:owner'])->group(function () {
        Route::get('/owner/branches', BranchManagement::class)->name('branches.index');
    });

    Route::get('/profile/owner', function () {
        return view('profile');
    })->name('owner.profile');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';