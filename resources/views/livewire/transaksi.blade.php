@extends('layouts.app')

@section('content')

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-card title="Transaksi Terakhir">
            <ul class="divide-y divide-gray-100">
                <li class="py-3 flex justify-between items-center">
                    <div class="flex items-center">
                        <div
                            class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-indigo-600 font-bold">
                            #1</div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">TRX-99281</p>
                            <p class="text-xs text-gray-500">14:20 WIB • Tunai</p>
                        </div>
                    </div>
                    <div class="text-right font-semibold text-gray-800 text-sm">
                        Rp 150.000
                    </div>
                </li>
                <li class="py-3 flex justify-between items-center">
                    <div class="flex items-center">
                        <div
                            class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-indigo-600 font-bold">
                            #2</div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">TRX-99280</p>
                            <p class="text-xs text-gray-500">13:45 WIB • QRIS</p>
                        </div>
                    </div>
                    <div class="text-right font-semibold text-gray-800 text-sm">
                        Rp 45.500
                    </div>
                </li>
            </ul>
        </x-card>

        <x-card title="Kesehatan Stok per Kategori">
            <div class="space-y-4 pt-2">
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span>Sembako</span>
                        <span class="font-bold">85%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span>Elektronik</span>
                        <span class="font-bold">30%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: 30%"></div>
                    </div>
                </div>
            </div>
        </x-card>
    </div>

@endsection