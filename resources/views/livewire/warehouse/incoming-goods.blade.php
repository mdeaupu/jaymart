<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-6">Input Barang Masuk (Stok Baru)</h2>

            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <x-input-label value="Pilih Produk" />
                    <select wire:model="product_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label value="Supplier (Opsional)" />
                    <select wire:model="supplier_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                        <option value="">-- Pilih Supplier --</option>
                        {{-- @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach --}}
                    </select>
                </div>

                <div>
                    <x-input-label value="Jumlah Masuk" />
                    <x-text-input wire:model="quantity" type="number" class="mt-1 block w-full" placeholder="0" />
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                </div>

                <div>
                    <x-input-label value="Catatan Tambahan" />
                    <x-text-input wire:model="notes" type="text" class="mt-1 block w-full"
                        placeholder="Contoh: No. Faktur Supplier" />
                </div>

                <div class="pt-4">
                    <x-primary-button class="w-full justify-center">Konfirmasi Stok Masuk</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>