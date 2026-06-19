<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen">
    <x-alert type="error" :message="session('error')" />
    <x-alert type="success" :message="session('message')" />

    {{-- EXECUTIVE HEADER --}}
    <div class="mb-8 border-b border-zinc-200 pb-6">
        <div class="flex items-center gap-2 mb-1">
            <span class="px-2.5 py-0.5 bg-amber-100 text-amber-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Stock Control</span>
        </div>
        <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Otorisasi Penyesuaian Stok</h1>
        <p class="text-sm text-zinc-500 mt-1">Evaluasi dan setujui perubahan stok manual yang diajukan oleh staf gerai.</p>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Asal Toko & Staff</th>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4 text-center">Kuantitas Lama ➔ Baru</th>
                        <th class="px-6 py-4 text-center">Selisih</th>
                        <th class="px-6 py-4">Alasan & Jejak Audit</th>
                        <th class="px-6 py-4 text-center">Otorisasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($adjustments as $adj)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-black text-zinc-900">{{ $adj->branch->name ?? 'Cabang Utama' }}</div>
                                <div class="text-xs font-medium text-zinc-500 mt-0.5">Oleh: {{ $adj->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 font-bold text-zinc-800">
                                {{ $adj->product->name }}
                                <div class="text-[11px] text-rose-600 mt-0.5">Potensi Loss: Rp {{ number_format(abs($adj->adjustment_amount) * ($adj->product->sell_price ?? 0), 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-mono text-zinc-500 font-semibold">
                                {{ $adj->old_quantity }} <span class="mx-2 text-zinc-300">➔</span> <span class="font-black text-zinc-900">{{ $adj->new_quantity }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-md bg-rose-50 text-rose-700">
                                    {{ $adj->adjustment_amount }} unit
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-zinc-600 max-w-xs break-words">
                                {{ $adj->reason }}
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex space-x-2 justify-center">
                                    <button wire:click="approveAdjustment({{ $adj->id }})" class="px-4 py-2 bg-zinc-900 text-white rounded-xl text-xs font-bold transition-all active:scale-95 shadow-sm hover:bg-zinc-800">
                                        Setujui
                                    </button>
                                    <button wire:click="rejectAdjustment({{ $adj->id }})" class="px-4 py-2 bg-rose-50 text-rose-700 rounded-xl text-xs font-bold transition-all active:scale-95 shadow-sm hover:bg-rose-100">
                                        Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-16 text-center text-sm font-medium text-emerald-600 bg-emerald-50/30 italic">✓ Sempurna! Tidak ada berkas kritis tertahan menunggu persetujuan Anda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>