<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
        {{ __('Blind Stock Opname') }}
    </h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <x-card class="p-8 border-t-4 border-amber-500">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Blind Stock Opname</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Hitung fisik barang di gudang dan masukkan
                        jumlahnya di bawah ini.</p>
                </div>
                <div
                    class="inline-flex items-center px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded-full text-[10px] font-bold uppercase tracking-wider border border-amber-200 dark:border-amber-800">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04kM12 21.355r" />
                    </svg>
                    Inventory Integrity Mode
                </div>
            </div>

            <form wire:submit.prevent="submit">
                <div class="overflow-hidden border border-gray-100 dark:border-gray-700 rounded-lg">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-800/50 text-gray-800 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider">Nama Produk</th>
                                <th class="px-6 py-4 font-semibold uppercase text-xs tracking-wider w-64 text-center">
                                    Jumlah Fisik Terhitung</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($stocks as $stock)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 dark:text-gray-100">{{ $stock->product->name }}
                                        </div>
                                        <div class="text-[10px] text-gray-500 uppercase mt-0.5">SKU:
                                            {{ $stock->product->sku ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center">
                                            <x-text-input wire:model="counts.{{ $stock->id }}" type="number"
                                                class="block w-32 text-center font-bold focus:ring-amber-500 focus:border-amber-500"
                                                placeholder="0" />
                                            <span
                                                class="ml-3 text-gray-400 dark:text-gray-500 text-[10px] font-bold uppercase">Unit</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic">
                                        Belum ada stok barang di cabang ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($stocks->isNotEmpty())
                    <div
                        class="mt-8 flex flex-col md:flex-row items-center justify-end gap-4 border-t border-gray-100 dark:border-gray-700 pt-8">
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 italic text-center md:text-right">
                            *Selisih akan otomatis diajukan ke Manager untuk sistem approval.
                        </p>
                        <x-primary-button onclick="return confirm('Apakah Anda yakin data hitungan sudah benar?')"
                            class="w-full md:w-auto justify-center bg-indigo-600 hover:bg-indigo-700 py-3 px-6 text-xs uppercase tracking-[0.2em]">
                            Kirim Hasil Opname
                        </x-primary-button>
                    </div>
                @endif
            </form>
        </x-card>
    </div>
</div>