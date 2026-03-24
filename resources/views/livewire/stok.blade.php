@extends('layouts.app')

@section('content')

    <div class="mt-8">
        <x-card title="Kontrol Stok & Inventaris">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="p-4 bg-orange-50 border border-orange-100 rounded-lg flex items-center">
                    <div class="p-3 bg-orange-100 rounded-full mr-4 text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-orange-800 font-medium">8 Produk Stok Kritis</p>
                        <p class="text-xs text-orange-600 underline cursor-pointer">Lihat semua barang yang harus diorder
                        </p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama Produk</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Stok Saat Ini
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Terakhir Update
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-800">Indomie Goreng</td>
                            <td class="px-6 py-4 text-right font-bold text-gray-700">1.240 <small
                                    class="text-gray-400 font-normal">Pcs</small></td>
                            <td class="px-6 py-4"><span
                                    class="text-green-600 text-xs font-bold uppercase tracking-wider">Tersedia</span></td>
                            <td class="px-6 py-4 text-gray-500">10 Menit yang lalu</td>
                        </tr>
                        <tr class="bg-red-50">
                            <td class="px-6 py-4 font-medium text-red-800">Susu UHT Full Cream 1L</td>
                            <td class="px-6 py-4 text-right font-bold text-red-600">5 <small
                                    class="text-red-400 font-normal">Pcs</small></td>
                            <td class="px-6 py-4">
                                <span class="bg-red-600 text-white px-2 py-0.5 rounded text-[10px] font-bold">STOK
                                    RENDAH</span>
                            </td>
                            <td class="px-6 py-4 text-gray-500">1 jam yang lalu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>

@endsection