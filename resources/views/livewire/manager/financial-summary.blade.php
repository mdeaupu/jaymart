<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">{{ __('Financial Summary') }}</h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <x-card class="p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Rekapitulasi Keuangan & Setoran</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Validasi penerimaan kas dari masing-masing kasir.
                </p>
            </div>
            <input type="date" wire:model.live="filterDate"
                class="[&::-webkit-calendar-picker-indicator]:dark:invert border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <x-table>
            <x-slot name="header">
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-400">Nama Kasir</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-400">Jml Transaksi
                </th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-400">Total Setoran
                </th>
                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-800 dark:text-gray-400">Aksi</th>
            </x-slot>

            @forelse($cashierSummaries as $summary)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ $summary->user->name ?? 'Sistem/Tidak Diketahui' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                        {{ $summary->transaction_count }}
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-green-600 dark:text-green-400">
                        Rp {{ number_format($summary->total_deposit, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-indigo-600 hover:text-indigo-900 font-semibold text-sm">Validasi</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-2 py-10 text-center text-sm text-gray-500 italic">Tidak ada transaksi pada
                        tanggal ini.</td>
                </tr>
            @endforelse
        </x-table>
    </x-card>
</div>