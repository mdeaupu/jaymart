<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">{{ __('Financial Summary') }}</h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="mb-2 py-2">
            <div class="h-11 flex items-center">
                <p class="text-sm text-gray-800 dark:text-gray-400">Validasi penerimaan kas dari masing-masing
                    kasir.</p>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <div>
                <input type="date" wire:model.live="filterDate"
                    class="[&::-webkit-calendar-picker-indicator]:dark:invert px-5 py-2.5 block w-full sm:w-40 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm text-sm"
                    title="Tanggal Filter">
            </div>
        </div>
    </div>

    <x-card>
        <div class="p-6">
            <x-table>
                <x-slot name="header">
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-400">Nama Kasir
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-400">Jumlah
                        Transaksi
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-400">Total Setoran
                    </th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-800 dark:text-gray-400">Aksi</th>
                </x-slot>

                @forelse($cashierSummaries as $summary)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $summary->user->name ?? 'Sistem/Tidak Diketahui' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-800 dark:text-gray-100">
                                {{ $summary->transaction_count }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-green-600 dark:text-green-400">
                                Rp {{ number_format($summary->total_deposit, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button
                                class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-semibold hover:bg-indigo-100 hover:text-indigo-800 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Validasi
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">
                            Tidak ada transaksi pada tanggal ini.
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>
    </x-card>
</div>