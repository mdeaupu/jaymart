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
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Otorisasi Koreksi Skala Besar</h1>
            <p class="text-sm text-zinc-500 mt-1">Daftar salah input kasir dengan dampak kerugian &ge; Rp200.000.</p>
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

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-zinc-100 bg-zinc-900 text-white">
            <h3 class="font-extrabold text-base">Daftar Dokumen Penangguhan Transaksi Kasir</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Kasir Pelapor</th>
                        <th class="px-6 py-4">Item Terkait</th>
                        <th class="px-6 py-4 text-center">Selisih Kuantitas</th>
                        <th class="px-6 py-4 text-right">Dampak Finansial</th>
                        <th class="px-6 py-4">Akar Masalah</th>
                        <th class="px-6 py-4 text-center">Tindakan Keamanan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($corrections as $item)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-black text-zinc-900">{{ $item->user->name ?? 'Kasir' }}</div>
                                <div class="text-[10px] font-bold text-zinc-400 mt-0.5 uppercase">INV:
                                    {{ $item->transaction->invoice_number ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-black text-zinc-800">{{ $item->product->name ?? '-' }}</div>
                                <div class="text-[10px] text-rose-600 font-bold mt-0.5 uppercase tracking-wider">Risiko
                                    Tinggi</div>
                            </td>
                            <td class="px-6 py-4 text-center font-mono text-zinc-700">
                                <span class="line-through text-zinc-400">{{ $item->wrong_quantity }}</span>
                                <span class="text-zinc-300 mx-1">➔</span>
                                <span
                                    class="text-purple-700 font-black bg-purple-100 px-2 py-0.5 rounded-md">{{ $item->corrected_quantity }}
                                    Pcs</span>
                            </td>
                            <td class="px-6 py-4 text-right font-black font-mono text-rose-600">
                                Rp {{ number_format($item->financial_impact, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <div
                                    class="p-2 bg-amber-50 rounded-lg text-[11px] text-amber-900 font-medium italic border border-amber-100">
                                    {{ $item->reason }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col gap-2 justify-center">
                                    <button wire:click="approveByManager({{ $item->id }})"
                                        class="px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-[11px] font-black uppercase tracking-wider shadow-sm transition-all active:scale-95">
                                        Setuju (ACC)
                                    </button>
                                    <button wire:click="rejectByManager({{ $item->id }})"
                                        class="px-3 py-2 bg-zinc-100 hover:bg-rose-50 text-zinc-700 hover:text-rose-700 rounded-xl text-[11px] font-black uppercase tracking-wider shadow-sm transition-all active:scale-95">
                                        Tolak Berkas
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-sm text-zinc-400 font-medium italic">Bersih!
                                Tidak ada penangguhan berkas void bernilai tinggi.</td>
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