<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    <div
        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-zinc-200 text-zinc-800 text-xs font-extrabold rounded-md uppercase tracking-wider">
                    Rekap Operasional
                </span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Laporan Kasir</h1>
            <p class="text-sm text-zinc-500 mt-1">Pantau performa penjualan pada shift Anda.</p>
        </div>

        <select wire:model.live="shift"
            class="w-full sm:w-auto px-4 py-2.5 bg-white border border-zinc-200 rounded-xl text-sm font-bold shadow-sm focus:ring-2 focus:ring-zinc-900 cursor-pointer">
            <option value="Pagi">☀️ Shift Pagi</option>
            <option value="Siang">🌤️ Shift Siang</option>
            <option value="Malam">🌙 Shift Malam</option>
        </select>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6 mb-8">

        <div
            class="bg-gradient-to-br from-zinc-900 to-zinc-800 p-6 rounded-2xl shadow-xl border border-zinc-700 flex flex-col justify-between text-white">
            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Total Penjualan Shift</p>
                <h3 class="text-3xl font-black mt-2 tracking-tight">Rp {{ number_format($total, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-zinc-200 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Jumlah Transaksi Berhasil</p>
                <h3 class="text-3xl font-black text-zinc-900 mt-2 tracking-tight">{{ $count }} Struk</h3>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-zinc-100 bg-zinc-50">
            <h2 class="font-extrabold text-zinc-800 text-sm uppercase tracking-wider">Riwayat Transaksi</h2>
        </div>

        <div class="divide-y divide-zinc-100">
            @forelse($transactions as $trx)
                <div class="p-5 hover:bg-zinc-50 transition flex justify-between items-center gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-black text-zinc-900">{{ $trx->invoice_number }}</span>
                        </div>
                        <p class="text-[11px] font-bold text-zinc-500 mt-1 tracking-wider">
                            {{ $trx->created_at->format('d M Y H:i') }} WIB
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-black text-emerald-600">
                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-zinc-400 text-sm font-medium">
                    📭 Tidak ada riwayat transaksi pada shift ini.
                </div>
            @endforelse
        </div>
    </div>

</div>