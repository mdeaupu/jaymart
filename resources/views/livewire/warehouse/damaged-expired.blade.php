<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <h2 class="text-xl font-bold mb-6 text-red-600">Pencatatan Barang Rusak / Kadaluwarsa</h2>

            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <x-input-label value="Pilih Produk dari Stok" />
                    <select wire:model="product_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($stocks as $stock)
                            <option value="{{ $stock->product_id }}">{{ $stock->product->name }} (Tersedia:
                                {{ $stock->quantity }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label value="Jenis Pengurangan" />
                        <select wire:model="type"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500">
                            <option value="expired">Kadaluwarsa (Expired)</option>
                            <option value="out">Rusak (Damaged)</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label value="Jumlah" />
                        <x-text-input wire:model="quantity" type="number" class="mt-1 block w-full" />
                    </div>
                </div>

                <div>
                    <x-input-label value="Alasan / Deskripsi Kerusakan" />
                    <x-text-input wire:model="reason" type="text" class="mt-1 block w-full"
                        placeholder="Contoh: Kertas lembab atau tinta bocor" />
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Kurangi Stok Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>