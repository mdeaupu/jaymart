<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">
    
    {{-- EXECUTIVE HEADER --}}
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 bg-blue-100 text-blue-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Procurement</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Pengajuan Pengadaan Stok</h1>
            <p class="text-sm text-zinc-500 mt-1">Input nota pengadaan barang dari supplier untuk diajukan kepada Owner.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-sm text-emerald-700 font-medium shadow-sm flex items-center gap-2">✨ {{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">
        {{-- CARD INFORMASI SUPPLIER --}}
        <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm p-6 sm:p-8">
            <h3 class="text-sm font-black text-zinc-800 uppercase tracking-wider mb-6 border-b border-zinc-100 pb-3">Informasi Faktur & Supplier</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Nomor PO</label>
                    <input type="text" wire:model="po_number" readonly class="w-full bg-zinc-100 border-zinc-200 text-zinc-500 rounded-xl font-mono font-bold shadow-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Supplier</label>
                    <select wire:model="supplier_id" class="w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold shadow-sm">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Tanggal Pembelian</label>
                    <input type="date" wire:model="purchase_date" class="w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold shadow-sm">
                    @error('purchase_date') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="border-t border-zinc-100 pt-6">
                <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Upload Gambar Nota Fisik</label>
                <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
                    <div class="w-full md:w-1/2">
                        <input type="file" wire:model="invoice_file" accept="image/*"
                            class="w-full text-sm text-zinc-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 cursor-pointer border border-dashed border-zinc-300 p-2 rounded-xl bg-zinc-50">
                        <p class="text-[10px] font-semibold text-zinc-400 mt-1 uppercase tracking-wider">Format: JPG, PNG. Maks 2MB.</p>
                        @error('invoice_file') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-center border border-zinc-200 rounded-xl p-2 min-w-[120px] min-h-[120px] bg-zinc-50">
                        <div wire:loading wire:target="invoice_file" class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider animate-pulse">Memuat...</div>
                        <div wire:loading.remove wire:target="invoice_file">
                            @if ($invoice_file)
                                <img src="{{ $invoice_file->temporaryUrl() }}" class="max-h-28 w-auto rounded-lg shadow-sm object-cover border border-zinc-200">
                            @else
                                <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">Belum ada nota</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD ITEM PRODUK --}}
        <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm p-6 sm:p-8">
            <div class="flex justify-between items-center mb-6 border-b border-zinc-100 pb-3">
                <h3 class="text-sm font-black text-zinc-800 uppercase tracking-wider">Item Pengadaan</h3>
                <button type="button" wire:click="addItem" class="inline-flex items-center px-4 py-2 bg-zinc-100 hover:bg-zinc-200 text-zinc-800 text-xs font-black uppercase tracking-wider rounded-xl shadow-sm transition-all active:scale-95">
                    + Tambah Item
                </button>
            </div>

            <div class="space-y-4">
                @foreach($items as $index => $item)
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end bg-zinc-50 p-4 rounded-xl border border-zinc-200" wire:key="item-{{ $index }}">
                        <div class="md:col-span-5">
                            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Produk</label>
                            <select wire:model="items.{{ $index }}.product_id" class="w-full bg-white border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold shadow-sm">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            @error("items.{$index}.product_id") <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Kuantitas</label>
                            <input type="number" wire:model="items.{{ $index }}.quantity_ordered" min="1" class="w-full bg-white border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-black text-center shadow-sm">
                            @error("items.{$index}.quantity_ordered") <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-4">
                            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Harga Satuan (Rp)</label>
                            <input type="number" wire:model="items.{{ $index }}.price_per_item" min="0" step="0.01" class="w-full bg-white border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-black shadow-sm">
                            @error("items.{$index}.price_per_item") <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-1 text-center">
                            @if(count($items) > 1)
                                <button type="button" wire:click="removeItem({{ $index }})" class="p-2.5 bg-white text-rose-600 hover:bg-rose-50 border border-zinc-200 rounded-xl transition-all shadow-sm">
                                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end pt-6 mt-6 border-t border-zinc-100">
                <button type="submit" wire:loading.attr="disabled" class="px-8 py-3.5 bg-purple-600 text-white rounded-xl text-sm font-black uppercase tracking-wider hover:bg-purple-700 shadow-sm transition-all active:scale-95 disabled:opacity-50">
                    Kirim Pengajuan
                </button>
            </div>
        </div>
    </form>
</div>