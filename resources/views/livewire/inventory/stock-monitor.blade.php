<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Stock Monitoring') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
            <div
                class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Real-time Stock Opname</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Pantau ketersediaan stok di seluruh cabang.</p>
                </div>

                <div class="flex flex-col md:flex-row gap-3">
                    <input wire:model.live="search" type="text" placeholder="Cari Produk..."
                        class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:ring-indigo-500 shadow-sm text-sm">

                    <select wire:model.live="branch_id"
                        class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:ring-indigo-500 shadow-sm text-sm">
                        <option value="">Semua Cabang</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                Produk</th>
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest text-center">
                                Cabang</th>
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest text-center">
                                Jumlah Stok</th>
                            <th
                                class="px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest text-right">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($stocks as $stock)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $stock->product->name }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300">
                                        {{ $stock->branch->name }}
                                    </span>
                                </td>
                                <td
                                    class="px-6 py-4 text-center text-sm font-bold {{ $stock->quantity <= $stock->low_stock_threshold ? 'text-red-600' : 'text-gray-900 dark:text-gray-100' }}">
                                    {{ $stock->quantity }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($stock->quantity <= $stock->low_stock_threshold)
                                        <span class="inline-flex items-center text-xs font-bold text-red-600 dark:text-red-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            STOK KRITIS
                                        </span>
                                    @else
                                        <span class="text-xs font-medium text-green-600 dark:text-green-400">Tersedia</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-gray-100 dark:border-gray-700">
                {{ $stocks->links() }}
            </div>
        </div>
    </div>
</div>