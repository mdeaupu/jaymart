<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen">
    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span
                    class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Financial
                    Report</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Laporan Transaksi</h1>
            <p class="text-sm text-zinc-500 mt-1">Pantau performa penjualan dan kasir di seluruh cabang.</p>
        </div>

        <div
            class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full xl:w-auto bg-white p-2 rounded-2xl border border-zinc-200 shadow-sm">
            <select wire:model.live="branchId"
                class="border-zinc-200 bg-zinc-50 rounded-xl text-sm font-semibold text-zinc-700 focus:border-purple-500 focus:ring-purple-500">
                <option value="">Semua Cabang</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
            <input type="date" wire:model.live="startDate"
                class="border-zinc-200 bg-zinc-50 rounded-xl text-sm font-semibold text-zinc-700 focus:border-purple-500 focus:ring-purple-500">
            <input type="date" wire:model.live="endDate"
                class="border-zinc-200 bg-zinc-50 rounded-xl text-sm font-semibold text-zinc-700 focus:border-purple-500 focus:ring-purple-500">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-8">
        <div
            class="bg-gradient-to-br from-zinc-900 to-zinc-800 p-6 rounded-2xl shadow-xl border border-zinc-700 text-white">
            <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Total Pendapatan</p>
            <h3 class="text-3xl font-black mt-2 tracking-tight">Rp
                {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-zinc-200 shadow-sm">
            <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Total Transaksi</p>
            <h3 class="text-3xl font-black text-zinc-900 mt-2 tracking-tight">{{ $stats['total_transactions'] }} Struk
            </h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-zinc-200 shadow-sm sm:col-span-2 lg:col-span-1">
            <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Rata-rata / Trx</p>
            <h3 class="text-3xl font-black text-purple-600 mt-2 tracking-tight">Rp
                {{ number_format($stats['avg_transaction'], 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Invoice</th>
                        <th class="px-6 py-4">Detail Cabang</th>
                        <th class="px-6 py-4">Kasir</th>
                        <th class="px-6 py-4">Total Tagihan</th>
                        <th class="px-6 py-4">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2.5 py-1 bg-zinc-200 text-zinc-800 text-xs font-bold rounded-md">{{ $trx->invoice_number }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-black text-zinc-800">{{ $trx->branch->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-zinc-600">
                                {{ $trx->user->name ?? 'System' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-black text-emerald-600">Rp
                                {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-zinc-500 font-medium">
                                {{ $trx->created_at->translatedFormat('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-zinc-400 italic font-medium">Tidak ada
                                transaksi ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
            <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50/50">{{ $transactions->links() }}</div>
        @endif
    </div>
</div>