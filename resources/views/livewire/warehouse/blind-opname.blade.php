<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Blind Stock Opname</h2>
                    <p class="text-sm text-gray-600">Hitung fisik barang di gudang dan masukkan jumlahnya di bawah ini.
                    </p>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">Inventory
                        Integrity Mode</span>
                </div>
            </div>

            <form wire:submit.prevent="submit">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 border-b">Nama Produk</th>
                                <th class="px-6 py-3 border-b w-64 text-center">Jumlah Fisik Terhitung</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stocks as $stock)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 border-b">
                                        <span class="font-medium text-gray-900">{{ $stock->product->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 border-b">
                                        <div class="flex items-center">
                                            <x-text-input wire:model="counts.{{ $stock->id }}" type="number"
                                                class="block w-full text-center" placeholder="Masukkan angka..." />
                                            <span class="ml-2 text-gray-500 text-xs text-nowrap">Pcs/Unit</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-10 text-center text-gray-500">Belum ada stok barang di
                                        cabang ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($stocks->isNotEmpty())
                    <div class="mt-6 flex items-center justify-end border-t pt-6">
                        <p class="text-xs text-gray-500 mr-4 italic">*Selisih akan otomatis diajukan ke Manager untuk
                            approval.</p>
                        <x-primary-button onclick="return confirm('Apakah Anda yakin data hitungan sudah benar?')">
                            Kirim Hasil Opname
                        </x-primary-button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>