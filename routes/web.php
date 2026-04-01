<?php


use App\Livewire\Owner\BranchManagement;
use App\Livewire\Owner\Dashboard;
use App\Livewire\Owner\MainTransactionReport;
use App\Livewire\Owner\StockAudit;
use App\Livewire\Owner\StockMonitor;
use App\Livewire\Owner\UserManagement;
use App\Livewire\Owner\StockAdjustmentIndex;
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

Route::middleware(['auth', 'verified', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/report', MainTransactionReport::class)->name('report.main');
        Route::view('/profile', 'profile')->name('profile');

        Route::get('/users', UserManagement::class)->name('users');
        Route::get('/branches', BranchManagement::class)->name('branches');

        Route::get('/monitoring', StockMonitor::class)->name('monitoring');
        Route::get('/audit', StockAudit::class)->name('audit');
        Route::get('/adjustments', StockAdjustmentIndex::class)->name('adjustments');
    });

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

require __DIR__ . '/auth.php';