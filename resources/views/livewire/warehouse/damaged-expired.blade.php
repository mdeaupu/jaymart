<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-rose-100 text-rose-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Manajemen
                    Inventori</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Barang Rusak & Expired</h1>
            <p class="text-sm text-zinc-500 mt-1">Ajukan pemutihan stok karena kerusakan fisik atau masa berlaku habis.
            </p>
        </div>
    </div>

    <div class="fixed top-5 right-5 z-[9999] max-w-sm space-y-3">
        @if(session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="flex items-center p-4 bg-emerald-600 text-white rounded-2xl shadow-xl border border-emerald-500 transform transition-all duration-300"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-[-20px]" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90">
                <div class="mr-3 bg-emerald-700/50 p-2 rounded-xl">✨</div>
                <div class="flex-1">
                    <h4 class="font-black text-sm">Berhasil Diajukan!</h4>
                    <p class="text-xs text-emerald-100 mt-0.5 font-medium">{{ session('message') }}</p>
                </div>
                <button @click="show = false" class="ml-4 text-emerald-200 hover:text-white transition font-bold">✕</button>
            </div>
        @endif

        @if(session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                class="flex items-center p-4 bg-rose-600 text-white rounded-2xl shadow-xl border border-rose-500 transform transition-all duration-300"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-[-20px]" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90">
                <div class="mr-3 bg-rose-700/50 p-2 rounded-xl">❌</div>
                <div class="flex-1">
                    <h4 class="font-black text-sm">Gagal!</h4>
                    <p class="text-xs text-rose-100 mt-0.5 font-medium">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="ml-4 text-rose-200 hover:text-white transition font-bold">✕</button>
            </div>
        @endif
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl border border-rose-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-rose-100 bg-rose-50 flex items-center gap-3">
                <span class="text-xl">⚠️</span>
                <div>
                    <h2 class="text-base font-extrabold text-rose-700 uppercase tracking-wider">Formulir Pemutihan Stok
                    </h2>
                </div>
            </div>

            <form wire:submit.prevent="save" class="p-6 space-y-6">
                <div>
                    <label for="product_id"
                        class="block text-xs font-bold text-zinc-600 uppercase tracking-wider mb-2">Pilih Produk dari
                        Stok</label>
                    <select wire:model="product_id" id="product_id"
                        class="w-full px-4 py-3 bg-white border border-zinc-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition text-sm font-medium">
                        <option value="">-- Silakan Pilih Produk --</option>
                        @foreach($stocks as $stock)
                            <option value="{{ $stock->product_id }}">
                                {{ $stock->product->name }} (Tersedia: {{ $stock->quantity }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id') <span
                    class="text-rose-500 text-xs font-bold mt-1.5 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="type"
                            class="block text-xs font-bold text-zinc-600 uppercase tracking-wider mb-2">Jenis
                            Pengurangan</label>
                        <select wire:model="type" id="type"
                            class="w-full px-4 py-3 bg-white border border-zinc-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition text-sm font-medium">
                            <option value="expired">Kadaluwarsa (Expired)</option>
                            <option value="out">Rusak (Damaged)</option>
                        </select>
                        @error('type') <span class="text-rose-500 text-xs font-bold mt-1.5 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="quantity"
                            class="block text-xs font-bold text-zinc-600 uppercase tracking-wider mb-2">Jumlah</label>
                        <input id="quantity" wire:model="quantity" type="number" placeholder="0"
                            class="w-full px-4 py-3 bg-white border border-zinc-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition text-sm font-black" />
                        @error('quantity') <span
                        class="text-rose-500 text-xs font-bold mt-1.5 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="reason"
                        class="block text-xs font-bold text-zinc-600 uppercase tracking-wider mb-2">Alasan / Deskripsi
                        Kerusakan</label>
                    <textarea id="reason" wire:model="reason" rows="3" placeholder="Contoh: Kertas kemasan lembab..."
                        class="w-full px-4 py-3 bg-white border border-zinc-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition text-sm font-medium resize-none"></textarea>
                    @error('reason') <span class="text-rose-500 text-xs font-bold mt-1.5 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-6 border-t border-zinc-100">
                    <button type="submit"
                        class="w-full py-3.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all duration-200 uppercase tracking-widest active:scale-[0.98]">
                        Kirim Ajuan Pemutihan Stok
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>