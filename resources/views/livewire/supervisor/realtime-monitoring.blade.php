<div wire:poll.3s>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Realtime Monitoring
        </h2>
    </x-slot>

    <div class="py-10 mx-auto sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">
            <p class="text-sm text-gray-800 dark:text-gray-400">
                Memantau transaksi kasir secara real-time.
            </p>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <x-stat-card title="Transaksi Hari Ini" colorClass="border-indigo-500"
                iconBgClass="bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400">
                {{ $todayCount }}
            </x-stat-card>

            <x-stat-card title="Pendapatan Hari Ini" colorClass="border-green-500"
                iconBgClass="bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400">
                Rp {{ number_format($todayRevenue, 0, ',', '.') }}
            </x-stat-card>

            <x-stat-card title="Transaksi Terakhir" colorClass="border-orange-500"
                iconBgClass="bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400">
                {{ $lastTransactionTime ?? '-' }}
            </x-stat-card>

        </div>

        {{-- TABLE --}}
        <x-card>
            <div class="p-6">

                <x-table>
                    <x-slot name="header">
                        <th class="px-6 py-3 text-sm font-semibold">Invoice</th>
                        <th class="px-6 py-3 text-sm font-semibold">Cabang</th>
                        <th class="px-6 py-3 text-sm font-semibold">Kasir</th>
                        <th class="px-6 py-3 text-sm font-semibold">Total</th>
                        <th class="px-6 py-3 text-sm font-semibold">Waktu</th>
                    </x-slot>

                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">

                            <td class="px-6 py-4">
                                <x-badge color="indigo">
                                    {{ $trx->invoice_number }}
                                </x-badge>
                            </td>

                            <td class="px-6 py-4 text-sm font-semibold">
                                {{ $trx->branch->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{ $trx->user->name ?? 'System' }}
                            </td>

                            <td class="px-6 py-4 font-bold">
                                Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{ $trx->created_at->format('H:i:s') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Tidak ada transaksi.
                            </td>
                        </tr>
                    @endforelse

                </x-table>

            </div>
        </x-card>

    </div>
</div>