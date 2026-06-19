<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-amber-100 text-amber-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Security
                    / Audit</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Verifikasi Pembatalan Kasir</h1>
            <p class="text-sm text-zinc-500 mt-1">Tinjau dan validasi pemutihan data transaksi kasir.</p>
        </div>
    </div>

    @if(session()->has('message'))
        <div
            class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-sm text-emerald-700 font-medium shadow-sm flex items-center gap-2">
            ✨ {{ session('message') }}</div>
    @endif
    @if(session()->has('error'))
        <div
            class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl text-sm text-rose-700 font-medium shadow-sm flex items-center gap-2">
            ❌ {{ session('error') }}</div>
    @endif

    <div class="mb-6 bg-white border border-amber-200 p-5 rounded-2xl shadow-sm flex">
        <span class="text-xl mr-3">💡</span>
        <div>
            <strong class="font-black text-zinc-800 text-sm uppercase tracking-wider">Kebijakan Otorisasi
                Cabang:</strong>
            <p class="mt-1 text-xs text-zinc-600 font-medium leading-relaxed">Anda memiliki wewenang memvalidasi
                pemutihan data transaksi kasir jika selisih nilai berada di bawah <span
                    class="font-bold text-amber-600">Rp 200.000</span>. Jika nilai kerugian bernilai besar (≥
                Rp200.000), sistem otomatis meneruskannya ke Manajer / Owner.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Kasir & Nota</th>
                        <th class="px-6 py-4">Detail Barang</th>
                        <th class="px-6 py-4 text-center">Qty Awal vs Riil</th>
                        <th class="px-6 py-4 text-right">Nilai Kerugian</th>
                        <th class="px-6 py-4">Alasan Kasir</th>
                        <th class="px-6 py-4 text-center">Aksi Konfirmasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($corrections as $item)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-black text-zinc-900">{{ $item->user->name ?? 'Kasir Toko' }}</div>
                                <div class="text-[10px] font-bold text-zinc-400 mt-0.5 tracking-wider uppercase">INV:
                                    {{ $item->transaction->invoice_number ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-black text-zinc-800">{{ $item->product->name ?? '-' }}</div>
                                <div class="text-[10px] text-purple-600 font-bold mt-0.5 uppercase tracking-wider">
                                    Rp
                                    {{ number_format($item->financial_impact / max(1, $item->quantity_difference), 0, ',', '.') }}/pcs
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center font-mono">
                                <span class="text-zinc-400 font-semibold line-through">{{ $item->wrong_quantity }}</span>
                                <span class="text-zinc-300 mx-1">➔</span>
                                <span
                                    class="text-purple-700 font-black bg-purple-50 px-2 py-0.5 rounded">{{ $item->corrected_quantity }}</span>
                            </td>
                            <td class="px-6 py-4 text-right font-black font-mono text-rose-600">
                                Rp {{ number_format($item->financial_impact, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <p class="text-xs text-zinc-600 font-medium italic">"{{ $item->reason }}"</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex gap-2">
                                    <button wire:click="approve({{ $item->id }})"
                                        class="px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-[10px] font-black uppercase tracking-wider shadow-sm transition-all active:scale-95">Setujui</button>
                                    <button wire:click="reject({{ $item->id }})"
                                        class="px-3 py-2 bg-zinc-100 hover:bg-zinc-200 text-zinc-700 rounded-xl text-[10px] font-black uppercase tracking-wider shadow-sm transition-all active:scale-95">Tolak</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-sm font-medium text-zinc-400 italic">
                                Sempurna! Tidak ada pengajuan koreksi nota tertunda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($corrections->hasPages())
            <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50/50">{{ $corrections->links() }}</div>
        @endif
    </div>
</div>