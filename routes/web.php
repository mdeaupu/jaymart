<?php

use App\Livewire\Dashboard\OwnerDashboard;
use App\Livewire\Owner\BranchManagement;
use App\Livewire\Owner\MainTransactionReport;
use App\Livewire\Owner\UserManagement;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('dashboard', function () {
    if (auth()->user()->hasRole('owner')) {
        return redirect()->route('owner.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:owner'])->group(function () {
    Route::get('/dashboard/owner', OwnerDashboard::class)->name('owner.dashboard');

    Route::get('/report/owner', MainTransactionReport::class)->name('owner.report.main');

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