<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
        {{ __('Catat Pembelian Stok (Procurement)') }}
    </h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <div class="mb-2 py-2">
        <div class="h-11 flex items-center">
            <p class="text-sm text-gray-800 dark:text-gray-400">Input pengadaan barang dari supplier untuk diajukan
                persetujuannya kepada Owner.</p>
        </div>
    </div>

    <x-card class="p-8">
        <form wire:submit.prevent="submit" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label
                        class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Supplier</label>
                    <select wire:model="supplier_id"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all py-3">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $s) <option value="{{ $s->id }}">{{ $s->name }}</option> @endforeach
                    </select>
                    @error('supplier_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label
                        class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Produk</label>
                    <select wire:model="product_id"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all py-3">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $p) <option value="{{ $p->id }}">{{ $p->name }}</option> @endforeach
                    </select>
                    @error('product_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <label
                        class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Jumlah
                        Masuk</label>
                    <input type="number" wire:model="quantity"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all py-3">
                    @error('quantity') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label
                        class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Total
                        Harga Beli</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500">Rp</span>
                        <input type="number" wire:model="total_price"
                            class="w-full pl-12 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all py-3">
                    </div>
                    @error('total_price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Tanggal
                            Beli</label>
                        <input type="date" wire:model="purchase_date"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-xl py-3">
                    </div>

                    <div>
                        <label
                            class="block text-sm font-bold text-red-600 dark:text-red-400 mb-2 uppercase tracking-wide">Tanggal
                            Kadaluarsa (Expired)</label>
                        <input type="date" wire:model="expired_at"
                            class="[&::-webkit-calendar-picker-indicator]:dark:invert w-full border-red-300 dark:border-red-900 dark:bg-gray-900 dark:text-gray-100 rounded-xl shadow-sm focus:ring-red-500 focus:border-red-500 transition-all py-3">
                        @error('expired_at') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div>
                <label
                    class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Invoice
                    / Nota (Bukti Foto)</label>
                <div
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-xl hover:border-indigo-500 transition-colors duration-200">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                            viewBox="0 0 48 48">
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 dark:text-gray-400">
                            <label
                                class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Upload file</span>
                                <input wire:model="invoice_file" type="file" class="sr-only">
                            </label>
                            <p class="pl-1 text-gray-500">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-400 italic">PNG, JPG up to 2MB</p>
                    </div>
                </div>
                @error('invoice_file') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end pt-6">
                <button type="submit"
                    class="inline-flex items-center px-8 py-3 bg-gray-600 border border-transparent rounded-xl font-bold text-sm text-white tracking-wide hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2 shadow-md active:scale-95 transition-all duration-200">
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </x-card>
</div>