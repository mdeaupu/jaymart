@extends('layouts.app')

@section('content')

    <div class="grid grid-cols-3 gap-4">

        <x-card title="Total Penjualan">
            <p class="text-2xl font-bold">Rp 10.000.000</p>
        </x-card>

        <x-card title="Jumlah Produk">
            <p class="text-2xl font-bold">150</p>
        </x-card>

        <x-card title="Stok Menipis">
            <p class="text-2xl font-bold text-red-500">12</p>
        </x-card>

    </div>

@endsection