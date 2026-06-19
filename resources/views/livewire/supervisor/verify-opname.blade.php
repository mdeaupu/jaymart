<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-blue-100 text-blue-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Inventory
                    Audit</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Verifikasi Lapangan Hasil Opname</h1>
            <p class="text-sm text-zinc-500 mt-1">Tinjau selisih stok gudang hasil pencatatan opname staf gerai.</p>
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

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Staff & Tanggal</th>
                        <th class="px-6 py-4">Detail Produk</th>
                        <th class="px-6 py-4 text-center">Komputer ➔ Fisik</th>
                        <th class="px-6 py-4 text-center">Selisih</th>
                        <th class="px-6 py-4 text-center">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($adjustments as $adj)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-black text-zinc-900">{{ $adj->user->name }}</div>
                                <div class="text-[10px] font-bold text-zinc-400 mt-0.5 uppercase tracking-wider">
                                    {{ $adj->created_at->format('d M, H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-black text-zinc-800">{{ $adj->product->name }}</div>
                                <div class="text-[10px] font-bold text-zinc-500 mt-0.5 tracking-wider">Rp
                                    {{ number_format($adj->product->sell_price, 0, ',', '.') }}</div>

                                @if(str_contains($adj->reason, '[EXPIRED]') || str_contains($adj->reason, '[OUT]'))
                                    <span
                                        class="inline-block mt-1.5 px-2 py-0.5 text-[9px] font-black tracking-wider uppercase rounded-md bg-amber-100 text-amber-800">⚠️
                                        Kerusakan Gudang</span>
                                    <div class="text-[11px] text-amber-700 font-medium italic mt-1">{{ $adj->reason }}</div>
                                @else
                                    <span
                                        class="inline-block mt-1.5 px-2 py-0.5 text-[9px] font-black tracking-wider uppercase rounded-md bg-blue-100 text-blue-800">📊
                                        Selisih Opname</span>
                                    <div class="text-[11px] text-zinc-500 italic mt-1">
                                        {{ $adj->reason ?? 'Tidak ada keterangan tambahan.' }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center font-mono text-zinc-500">
                                {{ $adj->old_quantity }} <span class="mx-2 text-zinc-300">➔</span> <span
                                    class="font-black text-zinc-900">{{ $adj->new_quantity }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="px-2.5 py-1 text-[10px] font-black rounded-md uppercase tracking-wider bg-rose-50 text-rose-700">
                                    {{ $adj->adjustment_amount }} pcs
                                </span>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="flex flex-col space-y-2.5 max-w-[200px] mx-auto">
                                    <button wire:click="verify({{ $adj->id }})"
                                        class="w-full py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-[10px] font-black uppercase tracking-wider shadow-sm transition-all active:scale-95">
                                        Verifikasi Data
                                    </button>
                                    <div class="border-t border-zinc-100 pt-2.5">
                                        <input type="text" wire:model="re_audit_reason.{{ $adj->id }}"
                                            placeholder="Alasan hitung ulang..."
                                            class="w-full text-xs rounded-xl border-zinc-200 py-1.5 px-3 mb-2 bg-zinc-50 focus:border-amber-500 focus:ring-amber-500 text-zinc-800 font-medium shadow-sm transition-all">
                                        <button wire:click="requestReAudit({{ $adj->id }})"
                                            class="w-full py-2 bg-amber-100 hover:bg-amber-200 text-amber-800 rounded-xl text-[10px] font-black uppercase tracking-wider shadow-sm transition-all active:scale-95">
                                            🔄 Minta Hitung Ulang
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-zinc-400 font-medium italic">Antrean bersih!
                                Tidak ada opname tertunda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>