<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Stock Monitoring') }}
    </h2>
</x-slot>

<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header & Filter Section -->
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="h-11 flex items-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Pantau ketersediaan stok di seluruh cabang.
            </p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
            <!-- Search Input -->
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input wire:model.live="search" type="text" placeholder="Cari Produk..."
                    class="block w-full pl-10 pr-4 py-2.5 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm transition">
            </div>
            <!-- Branch Select -->
            <div class="w-full sm:w-56">
                <select wire:model.live="branch_id"
                    class="block w-full px-4 py-2.5 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm transition">
                    <option value="">Semua Cabang</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <!-- Inventory Table Card -->
    <x-card class="overflow-hidden">
        <div class="overflow-x-auto">
            <x-table class="w-full">
                <x-slot name="header">
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Produk</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Cabang</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Jumlah Stok</th>
                    <th
                        class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Status</th>
                </x-slot>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($stocks as $stock)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="text-sm font-medium text-gray-900 dark:text-white">{{ $stock->product->name }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge color="indigo">{{ $stock->branch->name }}</x-badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span
                                        class="text-sm font-bold {{ $stock->quantity <= $stock->low_stock_threshold ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-gray-100' }}">
                                        {{ number_format($stock->quantity, 0, ',', '.') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($stock->quantity <= $stock->low_stock_threshold)
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 rounded-full text-xs font-bold uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600 mr-2 animate-pulse"></span>
                                        Kritis
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded-full text-xs font-bold uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-600 mr-2"></span>
                                        Tersedia
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-table>
        </div>
        <!-- Pagination Section -->
        @if($stocks->hasPages())
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                {{ $stocks->links() }}
            </div>
        @endif
    </x-card>
</div>