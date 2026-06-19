<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-amber-100 text-amber-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Inventory
                    Control</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Ajukan Penyesuaian Stok</h1>
            <p class="text-sm text-zinc-500 mt-1">Formulir pengajuan perubahan stok insidental atau hasil opname cabang.
            </p>
        </div>
    </div>

    @if(session('error'))
        <div
            class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl text-sm text-rose-700 font-medium shadow-sm flex items-center gap-2">
            ❌ {{ session('error') }}</div>
    @endif
    @if(session('message'))
        <div
            class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-sm text-emerald-700 font-medium shadow-sm flex items-center gap-2">
            ✨ {{ session('message') }}</div>
    @endif

    <div class="max-w-4xl bg-white p-6 sm:p-8 rounded-2xl border border-zinc-200 shadow-sm">
        <form wire:submit.prevent="submitAdjustment" class="space-y-6">
            <div>
                <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Pilih Produk
                    Cabang</label>
                <select wire:model.live="product_id"
                    class="w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold shadow-sm transition-all py-3">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $prod)
                        <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Stok Sistem
                        Saat Ini</label>
                    <input type="text" value="{{ $current_stock }} Unit" disabled
                        class="w-full bg-zinc-100 border-zinc-200 text-zinc-500 rounded-xl py-3 text-center font-black shadow-sm cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Nilai
                        Perubahan (Bisa - / +)</label>
                    <input type="number" wire:model="adjustment_amount" placeholder="Contoh: -2 atau 5"
                        class="w-full bg-white border-zinc-200 text-zinc-800 rounded-xl py-3 text-center font-black shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Alasan &
                    Keterangan</label>
                <textarea wire:model="reason" rows="3" placeholder="Jelaskan alasan penyesuaian stok ini..."
                    class="w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl py-3 text-sm font-medium shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all"></textarea>
            </div>

            <div class="flex justify-end pt-6 border-t border-zinc-100">
                <button type="submit"
                    class="px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-sm font-black uppercase tracking-wider shadow-sm transition-all active:scale-95">
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>