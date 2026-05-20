<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
        {{ __('Pencatatan Barang Rusak') }}
    </h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <x-card class="p-8 border border-red-500">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-red-600 dark:text-red-400">Pencatatan Barang Rusak / Kadaluwarsa</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kurangi stok gudang karena kerusakan fisik atau
                    masa berlaku habis.</p>
            </div>

            <form wire:submit.prevent="save" class="space-y-6">
                <div>
                    <x-input-label for="product_id" value="Pilih Produk dari Stok" class="font-semibold" />
                    <select wire:model="product_id" id="product_id"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($stocks as $stock)
                            <option value="{{ $stock->product_id }}">
                                {{ $stock->product->name }} (Tersedia: {{ $stock->quantity }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="type" value="Jenis Pengurangan" class="font-semibold" />
                        <select wire:model="type" id="type"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                            <option value="expired">Kadaluwarsa (Expired)</option>
                            <option value="out">Rusak (Damaged)</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="quantity" value="Jumlah" class="font-semibold" />
                        <x-text-input id="quantity" wire:model="quantity" type="number"
                            class="mt-1 block w-full focus:ring-red-500 focus:border-red-500" placeholder="0" />
                        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="reason" value="Alasan / Deskripsi Kerusakan" class="font-semibold" />
                    <x-text-input id="reason" wire:model="reason" type="text"
                        class="mt-1 block w-full focus:ring-red-500 focus:border-red-500"
                        placeholder="Contoh: Kertas lembab atau tinta bocor" />
                    <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                </div>

                <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                    <button type="submit"
                        class="w-full flex justify-center items-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-md shadow-sm transition-all duration-200 uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Kurangi Stok Sekarang
                    </button>
                </div>
            </form>
        </x-card>
    </div>
</div>