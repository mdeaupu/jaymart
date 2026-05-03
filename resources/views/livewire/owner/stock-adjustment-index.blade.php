<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Stock Adjustment') }}
    </h2>
</x-slot>

<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Alerts Section -->
    <x-alert type="error" :message="session('error')" />
    <x-alert type="success" :message="session('message')" />
    <!-- Header Section -->
    <div class="mb-8">
        <div class="h-11 flex items-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Tinjau dan setujui perubahan stok manual yang diajukan oleh pegawai.
            </p>
        </div>
    </div>
    <!-- Approval Table Card -->
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
                        Stok Lama</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Perubahan</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Alasan</th>
                    <th
                        class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Aksi</th>
                </x-slot>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($adjustments as $adj)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-800 dark:text-gray-100">{{ $adj->product->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge color="indigo">{{ $adj->branch->name }}</x-badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                {{ number_format($adj->old_quantity, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge :color="$adj->adjustment_amount > 0 ? 'green' : 'red'">
                                    {{ $adj->adjustment_amount > 0 ? '+' : '' }}{{ $adj->adjustment_amount }}
                                </x-badge>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 italic max-w-xs truncate">
                                "{{ $adj->reason }}"
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button wire:click="approveAdjustment({{ $adj->id }})"
                                        wire:confirm="Setujui perubahan stok ini?"
                                        class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-bold hover:bg-indigo-100 hover:text-indigo-800 transition-all duration-200 shadow-sm active:scale-95">
                                        Setujui
                                    </button>
                                    <button wire:click="rejectAdjustment({{ $adj->id }})"
                                        wire:confirm="Tolak permintaan penyesuaian stok ini?"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-bold hover:bg-red-100 hover:text-red-800 transition-all duration-200 shadow-sm active:scale-95">
                                        Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-sm text-gray-500 italic">
                                Tidak ada permintaan penyesuaian yang perlu diproses.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-table>
        </div>
        <!-- Pagination Section -->
        @if($adjustments->hasPages())
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                {{ $adjustments->links() }}
            </div>
        @endif
    </x-card>
</div>