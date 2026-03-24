@extends('layouts.app')

@section('content')

    <x-card title="Master Katalog Produk">
        <div class="flex justify-between items-center mb-4">
            <div class="relative w-64">
                <input type="text" placeholder="Cari produk..."
                    class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <button class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">+ Tambah Produk Baru</button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Harga Jual</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <tr>
                        <td class="px-6 py-4 font-mono text-gray-500 text-xs">BRG-001</td>
                        <td class="px-6 py-4 font-medium text-gray-800">Indomie Goreng</td>
                        <td class="px-6 py-4"><span class="bg-blue-50 text-blue-700 px-2 py-1 rounded">Sembako</span></td>
                        <td class="px-6 py-4">Rp 3.500</td>
                        <td class="px-6 py-4"><button class="text-blue-600 hover:underline">Edit</button></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 font-mono text-gray-500 text-xs">BRG-002</td>
                        <td class="px-6 py-4 font-medium text-gray-800">Susu UHT Full Cream 1L</td>
                        <td class="px-6 py-4"><span class="bg-blue-50 text-blue-700 px-2 py-1 rounded">Minuman</span></td>
                        <td class="px-6 py-4">Rp 18.000</td>
                        <td class="px-6 py-4"><button class="text-blue-600 hover:underline">Edit</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-card>

@endsection