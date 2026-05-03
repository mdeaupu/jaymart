<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
        {{ __('Report') }}
    </h2>
</x-slot>

<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header & Filters Section -->
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8">
        <div class="h-11 flex items-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Pantau performa penjualan di seluruh cabang.
            </p>
        </div>
        <!-- Filter Group -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full xl:w-auto">
            <div class="w-full">
                <select wire:model.live="branchId"
                    class="block w-full px-4 py-2.5 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm transition">
                    <option value="">Semua Cabang</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full">
                <input type="date" wire:model.live="startDate"
                    class="[&::-webkit-calendar-picker-indicator]:dark:invert block w-full px-4 py-2.5 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm"
                    title="Tanggal Mulai">
            </div>
            <div class="w-full">
                <input type="date" wire:model.live="endDate"
                    class="[&::-webkit-calendar-picker-indicator]:dark:invert block w-full px-4 py-2.5 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm"
                    title="Tanggal Akhir">
            </div>
        </div>
    </div>
    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <x-stat-card title="Total Pendapatan" colorClass="border-green-500"
            iconBgClass="bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400">
            Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
        </x-stat-card>
        <x-stat-card title="Total Transaksi" colorClass="border-indigo-500"
            iconBgClass="bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
            {{ $stats['total_transactions'] }}
        </x-stat-card>
        <x-stat-card title="Rata-rata / Trx" colorClass="border-orange-500"
            iconBgClass="bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400"
            class="sm:col-span-2 lg:col-span-1">
            Rp {{ number_format($stats['avg_transaction'], 0, ',', '.') }}
        </x-stat-card>
    </div>
    <!-- Transactions Table -->
    <x-card class="overflow-hidden">
        <div class="overflow-x-auto">
            <x-table class="w-full">
                <x-slot name="header">
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Invoice</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Detail Cabang</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Kasir</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Total Tagihan</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Waktu</th>
                </x-slot>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap"><x-badge
                                    color="indigo">{{ $trx->invoice_number }}</x-badge></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800 dark:text-gray-100">
                                {{ $trx->branch->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-100">
                                {{ $trx->user->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-800 dark:text-gray-100">
                                Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-100">
                                {{ $trx->created_at->translatedFormat('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-500 italic">
                                Tidak ada transaksi ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-table>
        </div>
        <!-- Pagination Section -->
        @if($transactions->hasPages())
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                {{ $transactions->links() }}
            </div>
        @endif
    </x-card>
</div>