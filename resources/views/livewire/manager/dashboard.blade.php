<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">{{ __('Dashboard') }}</h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Ringkasan Operasional Hari Ini</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Pantau performa penjualan dan stok barang secara langsung.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-stat-card title="Total Omzet Hari Ini" colorClass="border-blue-500">
            Rp {{ number_format($totalOmzet, 0, ',', '.') }}
        </x-stat-card>
        <x-stat-card title="Transaksi Hari Ini" colorClass="border-green-500">
            {{ $totalTransactions }} Transaksi
        </x-stat-card>
        <x-stat-card title="Produk Stok Rendah" colorClass="border-red-500">
            {{ $lowStocks->count() }} SKU
        </x-stat-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <x-card class="p-6">
            <h3 class="text-lg font-bold text-red-600 dark:text-red-400 flex items-center mb-6">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                Peringatan Stok Menipis
            </h3>
            <x-table>
                <x-slot name="header">
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-400">Produk</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-800 dark:text-gray-400">Sisa</th>
                </x-slot>
                @foreach($lowStocks as $stock)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $stock->product->name }}</td>
                        <td class="px-6 py-4 text-sm text-right font-bold text-red-600 dark:text-red-400">
                            {{ $stock->quantity }}
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </x-card>

        <x-card class="p-6">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-6">5 Produk Terlaris (Hari Ini)</h3>
            <ul class="space-y-4">
                @foreach($bestSellers as $item)
                    <li class="flex justify-between items-center p-3 rounded-lg bg-gray-50 dark:bg-gray-800">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $item->product->name }}</span>
                        <x-badge color="indigo">{{ $item->total_sold }} Terjual</x-badge>
                    </li>
                @endforeach
            </ul>
        </x-card>
    </div>
</div>