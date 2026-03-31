<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">{{ __('Dashboard') }}</h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <div class="mb-2 py-2">
        <div class="h-11 flex items-center">
            <p class="text-sm text-gray-800 dark:text-gray-400">Pantau performa seluruh cabang secara real-time.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-stat-card title="Total Pendapatan Hari Ini" colorClass="border-green-500">Rp
            {{ number_format($income['daily'], 0, ',', '.') }}</x-stat-card>
        <x-stat-card title="Minggu Ini" colorClass="border-indigo-500">Rp
            {{ number_format($income['weekly'], 0, ',', '.') }}</x-stat-card>
        <x-stat-card title="Bulan Ini" colorClass="border-orange-500">Rp
            {{ number_format($income['monthly'], 0, ',', '.') }}</x-stat-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <x-card class="p-6" x-data="{...}">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-400 mb-6">Performa Penjualan Cabang</h3>
            <div class="relative h-64"><canvas x-ref="canvas"></canvas></div>
        </x-card>

        <x-card class="p-6">
            <h3 class="text-lg font-bold text-red-600 dark:text-red-400 flex items-center mb-6">Peringatan Stok Kritis
            </h3>
            <x-table>
                <x-slot name="header">
                    <th class="px-2 py-3 text-sm font-semibold text-gray-800 dark:text-gray-400 ">Produk</th>
                    <th class="px-2 py-3 text-sm font-semibold text-gray-800 dark:text-gray-400 ">Cabang</th>
                    <th class="px-2 py-3 text-sm font-semibold text-gray-800 dark:text-gray-400 ">Sisa</th>
                </x-slot>

                @forelse($criticalStocks as $stock)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-2 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ $stock->product->name }}
                        </td>
                        <td class="px-2 py-4"><x-badge color="gray">{{ $stock->branch->name }}</x-badge></td>
                        <td class="px-2 py-4 text-sm font-bold text-red-600 dark:text-red-400">
                            {{ $stock->quantity }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-2 py-8 text-center text-sm text-gray-500 italic">Tidak ada stok kritis.
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </x-card>
    </div>
</div>