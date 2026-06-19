<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen">

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span
                    class="px-2.5 py-0.5 bg-blue-100 text-blue-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Inventory</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Stock Monitoring</h1>
            <p class="text-sm text-zinc-500 mt-1">Pantau pergerakan dan ketersediaan fisik stok di seluruh cabang secara
                langsung.</p>
        </div>

        <div
            class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto bg-white p-2 rounded-2xl border border-zinc-200 shadow-sm">
            <input wire:model.live="search" type="text" placeholder="Cari Produk..."
                class="w-full sm:w-64 border-zinc-200 bg-zinc-50 rounded-xl text-sm font-semibold text-zinc-700 focus:border-purple-500 focus:ring-purple-500">
            <select wire:model.live="branch_id"
                class="w-full sm:w-48 border-zinc-200 bg-zinc-50 rounded-xl text-sm font-semibold text-zinc-700 focus:border-purple-500 focus:ring-purple-500">
                <option value="">Semua Cabang</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Cabang Lokasi</th>
                        <th class="px-6 py-4">Jumlah Stok Realtime</th>
                        <th class="px-6 py-4 text-center">Status Kesehatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach($stocks as $stock)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-black text-zinc-900">
                                {{ $stock->product->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2.5 py-1 bg-zinc-200 text-zinc-800 text-[10px] font-bold rounded-md uppercase">{{ $stock->branch->name }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="text-base font-black {{ $stock->quantity <= $stock->low_stock_threshold ? 'text-rose-600' : 'text-zinc-800' }}">
                                    {{ number_format($stock->quantity, 0, ',', '.') }} <span
                                        class="text-xs font-medium text-zinc-400">Unit</span>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($stock->quantity <= $stock->low_stock_threshold)
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 bg-rose-50 text-rose-700 rounded-md text-[10px] font-black uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600 mr-2 animate-pulse"></span> Kritis /
                                        Restock
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-md text-[10px] font-black uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 mr-2"></span> Aman
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($stocks->hasPages())
            <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50/50">{{ $stocks->links() }}</div>
        @endif
    </div>
</div>