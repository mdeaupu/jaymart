<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>

<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8">
        <div class="h-11 flex items-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Pantau performa seluruh cabang secara real-time.
            </p>
        </div>
    </div>
    <!-- Stats Grid: 1 col on mobile, 2 col on tablet, 3 col on desktop -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 lg:gap-6 mb-8">
        <x-stat-card title="Total Pendapatan Hari Ini" colorClass="border-green-500">
            Rp {{ number_format($income['daily'], 0, ',', '.') }}
        </x-stat-card>
        <x-stat-card title="Minggu Ini" colorClass="border-indigo-500">
            Rp {{ number_format($income['weekly'], 0, ',', '.') }}
        </x-stat-card>
        <x-stat-card title="Bulan Ini" colorClass="border-orange-500" class="sm:col-span-2 md:col-span-1">
            Rp {{ number_format($income['monthly'], 0, ',', '.') }}
        </x-stat-card>
    </div>
    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
        <!-- Chart Section -->
        <x-card class="p-4 sm:p-6" x-data="{...}">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-400 mb-6">
                Performa Penjualan Cabang
            </h3>
            <div class="relative w-full aspect-video md:h-64">
                <canvas x-ref="canvas"></canvas>
            </div>
        </x-card>
        <!-- Critical Stock Section -->
        <x-card class="p-4 sm:p-6">
            <h3 class="text-lg font-bold text-red-600 dark:text-red-400 flex items-center mb-6">
                Peringatan Stok Kritis
            </h3>
            <div class="overflow-x-auto">
                <x-table class="w-full">
                    <x-slot name="header">
                        <th
                            class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                            Produk
                        </th>
                        <th
                            class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                            Cabang
                        </th>
                        <th
                            class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                            Sisa</th>
                    </x-slot>
                    @forelse($criticalStocks as $stock)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $stock->product->name }}
                            </td>
                            <td class="px-4 py-4">
                                <x-badge color="gray">{{ $stock->branch->name }}</x-badge>
                            </td>
                            <td class="px-4 py-4 text-sm font-bold text-red-600 dark:text-red-400 text-right sm:text-left">
                                {{ $stock->quantity }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-2 py-8 text-center text-sm text-gray-500 italic">
                                Tidak ada stok kritis.
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            </div>
        </x-card>
    </div>
</div>