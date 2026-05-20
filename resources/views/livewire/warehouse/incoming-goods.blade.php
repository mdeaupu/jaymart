<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
        {{ __('Input Barang Masuk') }}
    </h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <x-card class="p-8 border border-indigo-500">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Input Barang Masuk (Stok Baru)</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tambahkan stok produk ke gudang pusat.</p>
            </div>

            <form wire:submit.prevent="save" class="space-y-6">
                <div>
                    <x-input-label for="product_id" value="Pilih Produk" class="font-semibold" />
                    <select wire:model="product_id" id="product_id"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="supplier_id" value="Supplier (Opsional)" class="font-semibold" />
                    <select wire:model="supplier_id" id="supplier_id"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">-- Pilih Supplier --</option>
                        {{-- @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach --}}
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="quantity" value="Jumlah Masuk" class="font-semibold" />
                        <x-text-input id="quantity" wire:model="quantity" type="number" class="mt-1 block w-full"
                            placeholder="0" />
                        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="notes" value="Catatan Tambahan" class="font-semibold" />
                        <x-text-input id="notes" wire:model="notes" type="text" class="mt-1 block w-full"
                            placeholder="Contoh: No. Faktur Supplier" />
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                    <x-primary-button class="w-full justify-center py-3 text-xs uppercase tracking-[0.2em]">
                        Konfirmasi Stok Masuk
                    </x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</div>