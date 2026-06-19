<div wire:poll.3s class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Live
                    Control</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Realtime Monitoring</h1>
            <p class="text-sm text-zinc-500 mt-1">Memantau transaksi kasir secara instan dan *real-time*.</p>
        </div>
        <div class="w-full sm:w-auto">
            <span
                class="px-4 py-2 bg-white border border-zinc-200 rounded-xl text-[10px] font-black text-zinc-500 uppercase tracking-wider shadow-sm flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span> Live Update: 3s
            </span>
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-zinc-200 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Transaksi Hari Ini</p>
                <h3 class="text-3xl font-black text-zinc-900 mt-2 tracking-tight">{{ $todayCount }}</h3>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-zinc-900 to-zinc-800 p-6 rounded-2xl shadow-xl border border-zinc-700 flex flex-col justify-between text-white relative">
            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Pendapatan Hari Ini</p>
                <h3 class="text-3xl font-black mt-2 tracking-tight">Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                </h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-zinc-200 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Waktu Transaksi Terakhir</p>
                <h3 class="text-3xl font-black text-zinc-900 mt-2 tracking-tight">{{ $lastTransactionTime ?? '-' }}</h3>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Invoice</th>
                        <th class="px-6 py-4">Cabang</th>
                        <th class="px-6 py-4">Kasir</th>
                        <th class="px-6 py-4">Total Belanja</th>
                        <th class="px-6 py-4">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2.5 py-1 bg-zinc-200 text-zinc-800 text-[10px] font-black rounded-md">{{ $trx->invoice_number }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs font-black text-zinc-800 uppercase tracking-wider">
                                {{ $trx->branch->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 font-bold text-zinc-700">
                                {{ $trx->user->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-4 font-black text-emerald-600">
                                Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-[10px] font-bold text-zinc-500 tracking-wider">
                                {{ $trx->created_at->format('H:i:s') }} WIB
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-zinc-400 font-medium italic">Belum ada
                                transaksi terekam saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>