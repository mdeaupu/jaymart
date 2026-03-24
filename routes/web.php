<?php

use App\Livewire\Dashboard;
use App\Livewire\Produk;
use App\Livewire\Stok;
use App\Livewire\Transaksi;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', Dashboard::class);

Route::get('/produk', Produk::class);

Route::get('/transaksi', Transaksi::class);

Route::get('/stok', Stok::class);