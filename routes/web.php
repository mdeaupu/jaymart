<?php

use App\Livewire\Manager\Dashboard as ManagerDashboard;
use App\Livewire\Manager\ExportCenter;
use App\Livewire\Manager\FinancialSummary;
use App\Livewire\Manager\StaffManagement;
use App\Livewire\Owner\BranchManagement;
use App\Livewire\Owner\Dashboard as OwnerDashboard;
use App\Livewire\Owner\Dashboard as SupervisorDashboard;
use App\Livewire\Owner\MainTransactionReport;
use App\Livewire\Owner\StockAudit;
use App\Livewire\Owner\StockMonitor;
use App\Livewire\Owner\UserManagement;
use App\Livewire\Owner\StockAdjustmentIndex;
use App\Livewire\Supervisor\RealtimeMonitoring;
use App\Livewire\Supervisor\VoidApproval;
use App\Livewire\Cashier\Dashboard as CashierDashboard;
use App\Livewire\Cashier\Pos;
use App\Models\Transactions;

use App\Livewire\Warehouse\BlindOpname;
use App\Livewire\Warehouse\DamagedExpired;
use App\Livewire\Warehouse\Dashboard as WarehosueDashboard;
use App\Livewire\Warehouse\IncomingGoods;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('owner'))
        return redirect()->route('owner.dashboard');
    if ($user->hasRole('manager'))
        return redirect()->route('manager.dashboard');
    if ($user->hasRole('supervisor'))
        return redirect()->route('supervisor.dashboard');
    if ($user->hasRole('cashier'))
        return redirect()->route('cashier.dashboard');
    if ($user->hasRole('warehouse'))
        return redirect()->route('warehouse.dashboard');
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {
        Route::get('/dashboard', OwnerDashboard::class)->name('dashboard');
        Route::get('/report', MainTransactionReport::class)->name('report.main');
        Route::get('/users', UserManagement::class)->name('users');
        Route::get('/branches', BranchManagement::class)->name('branches');
        Route::get('/monitoring', StockMonitor::class)->name('monitoring');
        Route::get('/audit', StockAudit::class)->name('audit');
        Route::get('/adjustments', StockAdjustmentIndex::class)->name('adjustments');
        Route::view('/profile', 'profile')->name('profile');
    });

Route::middleware(['auth', 'verified', 'role:manager'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {
        Route::get('/dashboard', ManagerDashboard::class)->name('dashboard');
        Route::get('/staff', StaffManagement::class)->name('staff');
        Route::get('/export', ExportCenter::class)->name('export');
        Route::get('/finance', FinancialSummary::class)->name('finance');
        Route::view('/profile', 'profile')->name('profile');
    });

Route::middleware(['auth', 'verified', 'role:supervisor'])
    ->prefix('supervisor')
    ->name('supervisor.')
    ->group(function () {
        Route::get('/dashboard', SupervisorDashboard::class)->name('dashboard');
        Route::get('/monitoring', RealtimeMonitoring::class)
            ->name('monitoring');
        Route::get('/void-approval', VoidApproval::class)->name('void');
    });


Route::middleware(['auth', 'verified', 'role:cashier'])
    ->prefix('cashier')
    ->name('cashier.')
    ->group(function () {

        Route::get('/dashboard', CashierDashboard::class)->name('dashboard'); 
        Route::get('/pos', Pos::class)->name('pos');

Route::get('/receipt/{transaction}', function (Transactions $transaction) {
    return view('livewire.cashier.receipt', compact('transaction'));
})->name('receipt');
});
    

Route::middleware(['auth', 'verified', 'role:warehouse'])
    ->prefix('warehouse')
    ->name('warehouse.')
    ->group(function () {
        Route::get('/dashboard', WarehosueDashboard::class)->name('dashboard');
        Route::get('/incoming', IncomingGoods::class)->name('incoming');
        Route::get('/opname', BlindOpname::class)->name('opname');
        Route::get('/damaged', DamagedExpired::class)->name('damaged');
    });

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

require __DIR__ . '/auth.php';