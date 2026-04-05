<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Stock Monitoring') }}</h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <div class="mb-2 py-2">
        <div class="h-11 items-center flex justify-between">
            <p class="text-sm text-gray-600 dark:text-gray-400">Pantau ketersediaan stok di seluruh cabang.</p>
            <div class="flex flex-col md:flex-row gap-3">
                <input wire:model.live="search" type="text" placeholder="Cari Produk..."
                    class="block w-full px-5 py-2.5 sm:w-48 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm text-sm">
                <select wire:model.live="branch_id"
                    class="block w-full px-5 py-2.5 sm:w-48 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm text-sm">
                    <option value="">Semua Cabang</option>
                    @foreach($branches as $branch) <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <x-card>
        <div class="p-6">
            <x-table>
                <x-slot name="header">
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400">Produk</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400">Cabang</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400">Jumlah Stok</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400 text-center">Status</th>
                </x-slot>

                @foreach($stocks as $stock)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $stock->product->name }}
                        </td>
                        <td class="px-6 py-4"><x-badge color="indigo">{{ $stock->branch->name }}</x-badge></td>
                        <td
                            class="px-6 py-4 text-sm font-bold {{ $stock->quantity <= $stock->low_stock_threshold ? 'text-red-600' : 'text-gray-900 dark:text-gray-100' }}">
                            {{ $stock->quantity }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($stock->quantity <= $stock->low_stock_threshold)
                                <span
                                    class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-sm font-semiboldtransition-colors duration-200 cursor-default">Kritis</span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-sm font-semibold transition-colors duration-200 cursor-default">Tersedia</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">{{ $stocks->links() }}</div>
    </x-card>
</div>