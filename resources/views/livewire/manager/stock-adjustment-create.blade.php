<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
        {{ __('Ajukan Penyesuaian Stok') }}
    </h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <x-alert type="error" :message="session('error')" />
    <x-alert type="success" :message="session('message')" />

    <div class="mb-2 py-2">
        <div class="h-11 flex items-center">
            <p class="text-sm text-gray-800 dark:text-gray-400">Isi formulir di bawah ini untuk mengajukan perubahan
                stok manual (koreksi) kepada Owner.</p>
        </div>
    </div>

    <x-card class="p-8">
        <form wire:submit.prevent="submitAdjustment" class="space-y-6">
            <div>
                <label
                    class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Pilih
                    Produk</label>
                <select wire:model.live="product_id"
                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all py-3">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('product_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label
                        class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Jumlah
                        Penyesuaian</label>
                    <input type="number" wire:model="adjustment_amount"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all py-3"
                        placeholder="Contoh: -5 atau 10">
                    <p class="mt-2 text-xs text-gray-500 italic font-medium">Gunakan tanda minus (-) untuk mengurangi
                        stok (barang rusak/hilang).</p>
                    @error('adjustment_amount') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label
                        class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Alasan
                        Penyesuaian</label>
                    <input type="text" wire:model="reason"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all py-3"
                        placeholder="Misal: Barang rusak saat pengiriman">
                    @error('reason') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-100 dark:border-gray-800">
                <button type="submit"
                    class="inline-flex items-center px-8 py-3 bg-gray-600 border border-transparent rounded-xl font-bold text-sm text-white tracking-wide hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2 shadow-md active:scale-95 transition-all duration-200">
                    Ajukan Perubahan
                </button>
            </div>
        </form>
    </x-card>
</div>