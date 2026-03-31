<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">{{ __('Report') }}</h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <div class="mb-2 py-2">
        <div class="h-11 flex items-center">
            <p class="text-sm text-gray-800 dark:text-gray-400">Pantau performa penjualan di seluruh cabang.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-stat-card title="Total Pendapatan" colorClass="border-green-500"
            iconBgClass="bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400">
            Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
        </x-stat-card>

        <x-stat-card title="Total Transaksi" colorClass="border-indigo-500"
            iconBgClass="bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
            {{ $stats['total_transactions'] }} <span
                class="text-sm font-normal text-gray-800 dark:text-gray-400"></span>
        </x-stat-card>

        <x-stat-card title="Rata-rata / Trx" colorClass="border-orange-500"
            iconBgClass="bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400">
            Rp {{ number_format($stats['avg_transaction'], 0, ',', '.') }}
        </x-stat-card>
    </div>

    <x-card>
        <div class="p-6">
            <x-table>
                <x-slot name="header">
                    <th class="px-6 py-3 text-sm font-semibold text-gray-800 dark:text-gray-400  ">Invoice</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-800 dark:text-gray-400 ">Detail Cabang</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-800 dark:text-gray-400 ">Kasir</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-800 dark:text-gray-400 ">Total Tagihan</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-800 dark:text-gray-400 ">Waktu</th>
                </x-slot>

                @forelse($transactions as $trx)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                        <td class="px-6 py-4"><x-badge color="indigo">{{ $trx->invoice_number }}</x-badge></td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-800 dark:text-gray-100">
                            {{ $trx->branch->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-100">{{ $trx->user->name ?? 'System' }}
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-800 dark:text-gray-100">Rp
                            {{ number_format($trx->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-100">
                            {{ $trx->created_at->translatedFormat('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">Tidak ada transaksi ditemukan.</td>
                    </tr>
                @endforelse
            </x-table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">{{ $transactions->links() }}</div>
    </x-card>
</div>