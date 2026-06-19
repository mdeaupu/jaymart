<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 bg-blue-100 text-blue-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Staff Gudang Panel</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Formulir Blind Stock Opname</h1>
            <p class="text-sm text-zinc-500 mt-1">Lakukan penghitungan fisik nyata tanpa melihat data sistem.</p>
        </div>
    </div>

    <div class="fixed top-5 right-5 z-[9999] max-w-sm space-y-3">
        @if(session()->has('message') || session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="flex items-center p-4 bg-emerald-600 text-white rounded-2xl shadow-xl border border-emerald-500 transform transition-all duration-300"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-[-20px]" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                <div class="mr-3 bg-emerald-700/50 p-2 rounded-xl">✨</div>
                <div class="flex-1">
                    <h4 class="font-black text-sm">Berhasil!</h4>
                    <p class="text-xs text-emerald-100 mt-0.5 font-medium">{{ session('message') ?? session('success') }}</p>
                </div>
                <button @click="show = false" class="ml-4 text-emerald-200 hover:text-white transition font-bold">✕</button>
            </div>
        @endif

        @if(session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                class="flex items-center p-4 bg-rose-600 text-white rounded-2xl shadow-xl border border-rose-500 transform transition-all duration-300"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-[-20px]" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                <div class="mr-3 bg-rose-700/50 p-2 rounded-xl">❌</div>
                <div class="flex-1">
                    <h4 class="font-black text-sm">Peringatan Sistem!</h4>
                    <p class="text-xs text-rose-100 mt-0.5 font-medium">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="ml-4 text-rose-200 hover:text-white transition font-bold">✕</button>
            </div>
        @endif
    </div>
    @php
        $reAuditLists = \App\Models\StockAdjustments::with('product')
            ->where('branch_id', auth()->user()->branch_id)
            ->where('status', 're_audit')
            ->get();
    @endphp

    @if($reAuditLists->isNotEmpty())
        <div class="mb-6 p-5 bg-rose-50 border-l-4 border-rose-500 rounded-r-2xl shadow-sm text-sm">
            <strong class="font-black text-rose-700 flex items-center mb-2 uppercase tracking-wider">🔄 Perintah Hitung Ulang (Re-Audit) Supervisor:</strong>
            <ul class="list-disc list-inside space-y-1.5 text-rose-600 font-medium text-xs">
                @foreach($reAuditLists as $ra)
                    <li>Barang <span class="font-bold text-rose-900">{{ $ra->product->name }}</span>: <span class="italic">"{{ $ra->reason }}"</span></li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-zinc-100 bg-zinc-900 text-white">
                <h2 class="font-extrabold text-sm uppercase tracking-wider">Daftar Produk Cabang</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                        <tr>
                            <th class="px-6 py-4">Nama Produk / SKU</th>
                            <th class="px-6 py-4 text-center w-1/3">Jumlah Fisik Nyata</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @forelse($stocks as $stock)
                            <tr class="hover:bg-zinc-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-zinc-900">{{ $stock->product->name }}</div>
                                    <div class="text-[10px] text-zinc-500 font-bold uppercase tracking-wider mt-0.5">SKU: {{ $stock->product->sku }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center">
                                        <input type="number" wire:model="counts.{{ $stock->id }}" min="0" placeholder="Belum dihitung"
                                            class="w-full max-w-[180px] px-4 py-2.5 bg-white border border-zinc-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition text-sm text-center font-black">
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-12 text-zinc-400 text-sm font-medium">
                                    Tidak ada produk terdaftar di cabang ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-5 bg-zinc-50 border-t border-zinc-100 flex justify-end">
                <button type="submit" wire:loading.attr="disabled"
                    class="px-6 py-3 bg-purple-600 text-white rounded-xl text-sm font-bold hover:bg-purple-700 shadow-sm transition disabled:opacity-50">
                    Kirim Hasil Opname
                </button>
            </div>
        </div>
    </form>
</div>