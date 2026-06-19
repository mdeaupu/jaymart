<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-rose-100 text-rose-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Audit
                    / Action Required</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Review Eskalasi Opname</h1>
            <p class="text-sm text-zinc-500 mt-1">Tinjau dan setujui penyesuaian stok bernilai tinggi limpahan dari
                Supervisor.</p>
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
                        <th class="px-6 py-4">Asal Pencatat</th>
                        <th class="px-6 py-4">Produk Terkait</th>
                        <th class="px-6 py-4 text-center">Koreksi Kuantitas</th>
                        <th class="px-6 py-4">Catatan Laporan</th>
                        <th class="px-6 py-4 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($adjustments as $adj)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-black text-zinc-900">{{ $adj->user->name }}</div>
                                <div class="text-[10px] font-bold text-zinc-400 mt-0.5 uppercase tracking-wider">Tgl:
                                    {{ $adj->created_at->format('d M, H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-black text-zinc-800">{{ $adj->product->name }}</div>
                                <div class="text-[10px] text-rose-600 font-bold mt-0.5 uppercase tracking-wider">
                                    Potensi Loss: Rp
                                    {{ number_format(abs($adj->adjustment_amount) * ($adj->product->sell_price ?? 0), 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center font-mono font-black text-rose-600 bg-rose-50/30">
                                {{ $adj->adjustment_amount }} Pcs
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-zinc-600 max-w-xs break-words">
                                {{ $adj->reason }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex space-x-2 justify-center">
                                    <button wire:click="approve({{ $adj->id }})"
                                        class="px-4 py-2 bg-purple-600 text-white hover:bg-purple-700 rounded-xl font-black text-[11px] uppercase tracking-wider shadow-sm transition-all active:scale-95">Setujui</button>
                                    <button wire:click="reject({{ $adj->id }})"
                                        class="px-4 py-2 bg-zinc-100 text-zinc-700 hover:bg-rose-50 hover:text-rose-700 rounded-xl font-black text-[11px] uppercase tracking-wider shadow-sm transition-all active:scale-95">Tolak</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-sm font-medium text-zinc-400 italic">Tidak
                                ada limpahan eskalasi dari Supervisor saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>