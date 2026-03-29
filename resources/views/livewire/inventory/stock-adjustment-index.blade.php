<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Stock Approvals') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">

            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Persetujuan Penyesuaian Stok') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Tinjau dan setujui perubahan stok manual yang diajukan oleh pegawai.
                    </p>
                </div>
            </div>

            @if (session()->has('message'))
                <div
                    class="m-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-lg text-sm">
                    {{ session('message') }}
                </div>
            @endif

            <div class="overflow-x-auto p-6">
                <table class="w-full text-left">
                    <thead>
                        <tr
                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700">
                            <th class="px-2 py-3">Produk & Cabang</th>
                            <th class="px-2 py-3 text-center">Stok Lama</th>
                            <th class="px-2 py-3 text-center">Perubahan</th>
                            <th class="px-2 py-3">Alasan</th>
                            <th class="px-2 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($adjustments as $adj)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-2 py-4">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $adj->product->name }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $adj->branch->name }}</div>
                                </td>
                                <td class="px-2 py-4 text-center text-sm text-gray-600 dark:text-gray-400">
                                    {{ $adj->old_quantity }}
                                </td>
                                <td class="px-2 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $adj->adjustment_amount > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                        {{ $adj->adjustment_amount > 0 ? '+' : '' }}{{ $adj->adjustment_amount }}
                                    </span>
                                </td>
                                <td class="px-2 py-4 text-sm text-gray-600 dark:text-gray-400 italic">
                                    "{{ $adj->reason }}"
                                </td>
                                <td class="px-2 py-4 text-right">
                                    <button wire:click="approveAdjustment({{ $adj->id }})"
                                        wire:confirm="Setujui perubahan stok ini? Stok gudang akan langsung diperbarui."
                                        class="inline-flex items-center px-3 py-1.5 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-400 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Setujui
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-2 py-10 text-center text-sm text-gray-500 dark:text-gray-400 italic">
                                    Tidak ada permintaan penyesuaian yang perlu diproses.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700">
                {{ $adjustments->links() }}
            </div>
        </div>
    </div>
</div>