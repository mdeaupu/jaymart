<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Stock Approvals') }}</h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <x-alert type="error" :message="session('error')" />
    <x-alert type="success" :message="session('message')" />
    <div class="mb-2 py-2">
        <div class="h-11 items-center flex justify-between">
            <p class="text-sm text-gray-600 dark:text-gray-400">Tinjau dan setujui perubahan stok manual yang
                diajukan oleh pegawai.</p>
        </div>
    </div>

    <x-card>
        <div class="p-6">
            <x-table>
                <x-slot name="header">
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400 dark:text-gray-400">
                        Produk</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400 dark:text-gray-400">
                        Cabang</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400 dark:text-gray-400">
                        Stok Lama</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400 dark:text-gray-400">
                        Perubahan</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400 dark:text-gray-400">
                        Alasan</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400 dark:text-gray-400 text-center">
                        Aksi</th>
                </x-slot>

                @forelse($adjustments as $adj)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-800 dark:text-gray-100">{{ $adj->product->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs text-gray-800 dark:text-gray-100">{{ $adj->branch->name }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-400">{{ $adj->old_quantity }}
                        </td>
                        <td class="px-6 py-4">
                            <x-badge :color="$adj->adjustment_amount > 0 ? 'green' : 'red'">
                                {{ $adj->adjustment_amount > 0 ? '+' : '' }}{{ $adj->adjustment_amount }}
                            </x-badge>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-400 italic">"{{ $adj->reason }}"</td>
                        <td class="px-6 py-4 text-center">
                            <button wire:click="approveAdjustment({{ $adj->id }})"
                                wire:confirm="Setujui perubahan stok ini?"
                                class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-semibold hover:bg-indigo-100 hover:text-indigo-800 transition-colors duration-200">
                                Setujui
                            </button>
                            <button wire:click="rejectAdjustment({{ $adj->id }})"
                                wire:confirm="Tolak permintaan penyesuaian stok ini?"
                                class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-sm font-semibold hover:bg-red-100 hover:text-red-800 transition-colors duration-200">
                                Tolak
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-2 py-10 text-center text-sm text-gray-400 italic">Tidak ada permintaan
                            penyesuaian yang perlu diproses.</td>
                    </tr>
                @endforelse
            </x-table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">{{ $adjustments->links() }}</div>
    </x-card>
</div>