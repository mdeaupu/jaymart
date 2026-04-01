<?php

use App\Livewire\Dashboard\OwnerDashboard;
use App\Livewire\Inventory\StockAdjustmentIndex;
use App\Livewire\Inventory\StockAudit;
use App\Livewire\Inventory\StockMonitor;
use App\Livewire\Owner\BranchManagement;
use App\Livewire\Owner\MainTransactionReport;
use App\Livewire\Owner\UserManagement;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

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

    Route::get('/owner/monitoring', StockMonitor::class)->name('owner.monitoring');
    Route::get('/owner/audit', StockAudit::class)->name('owner.audit');
    Route::get('/owner/adjustments', StockAdjustmentIndex::class)->name('owner.adjustments');

    Route::get('/profile/owner', function () {
        return view('profile');
    })->name('owner.profile');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';