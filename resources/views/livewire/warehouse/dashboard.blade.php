<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 bg-indigo-100 text-indigo-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Logistik & Gudang</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Dashboard Gudang</h1>
            <p class="text-sm text-zinc-500 mt-1">Pantauan real-time inventaris dan sirkulasi logistik.</p>
        </div>
    </div>

    {{-- KARTU STATISTIK STRATEGIS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
        {{-- Total Jenis Barang --}}
        <div class="bg-gradient-to-br from-zinc-900 to-zinc-800 p-6 rounded-2xl shadow-xl border border-zinc-700 flex flex-col justify-between text-white relative overflow-hidden">
            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Total Jenis Barang</p>
                <h3 class="text-3xl font-black mt-2 tracking-tight">{{ $stats['total_items'] }} SKU</h3>
            </div>
        </div>

        {{-- Stok Menipis --}}
        <div class="bg-white p-6 rounded-2xl border {{ $stats['low_stock_count'] > 0 ? 'border-rose-200' : 'border-zinc-200' }} shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold {{ $stats['low_stock_count'] > 0 ? 'text-rose-500' : 'text-zinc-400' }} uppercase tracking-wider">Stok Menipis</p>
                <h3 class="text-3xl font-black {{ $stats['low_stock_count'] > 0 ? 'text-rose-600' : 'text-zinc-900' }} mt-2 tracking-tight">{{ $stats['low_stock_count'] }} Item</h3>
            </div>
        </div>

        {{-- Barang Masuk --}}
        <div class="bg-white p-6 rounded-2xl border border-zinc-200 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold text-emerald-500 uppercase tracking-wider">Masuk Hari Ini</p>
                <h3 class="text-3xl font-black text-emerald-600 mt-2 tracking-tight">+{{ $stats['incoming_today'] }} Pcs</h3>
            </div>
        </div>

        {{-- Menunggu Approval --}}
        <div class="bg-white p-6 rounded-2xl border {{ $stats['pending_adjustments'] > 0 ? 'border-amber-200' : 'border-zinc-200' }} shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold {{ $stats['pending_adjustments'] > 0 ? 'text-amber-500' : 'text-zinc-400' }} uppercase tracking-wider">Menunggu Approval</p>
                <h3 class="text-3xl font-black {{ $stats['pending_adjustments'] > 0 ? 'text-amber-600' : 'text-zinc-900' }} mt-2 tracking-tight">{{ $stats['pending_adjustments'] }} Ajuan</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        {{-- KOLOM KIRI & TENGAH --}}
        <div class="xl:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden flex flex-col h-full">
                <div class="p-5 border-b border-zinc-100 bg-zinc-900 flex justify-between items-center text-white">
                    <div>
                        <h2 class="font-extrabold text-base">Log Aktivitas Gudang Terbaru</h2>
                    </div>
                </div>

                <div class="divide-y divide-zinc-100 flex-1 overflow-y-auto max-h-[500px]">
                    @forelse($recentActivities as $log)
                        <div class="p-5 hover:bg-zinc-50 transition flex items-start gap-4">
                            <div class="mt-1">
                                <span class="w-10 h-10 rounded-full flex items-center justify-center shadow-sm 
                                    {{ $log->type == 'in' ? 'bg-emerald-100 text-emerald-600' : ($log->type == 'out' ? 'bg-indigo-100 text-indigo-600' : 'bg-rose-100 text-rose-600') }}">
                                    @if($log->type == 'in') ⬇️ @elseif($log->type == 'out') ⬆️ @else ⚠️ @endif
                                </span>
                            </div>
                            <div class="flex-1 space-y-1">
                                <div class="flex justify-between items-start">
                                    <p class="text-sm font-medium text-zinc-600">
                                        <span class="font-bold text-zinc-900">{{ $log->product->name }}</span> ({{ $log->amount }} unit)
                                    </p>
                                    <span class="text-[10px] font-bold text-zinc-400 tracking-wider uppercase">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider
                                        {{ $log->type == 'in' ? 'bg-emerald-100 text-emerald-800' : ($log->type == 'out' ? 'bg-indigo-100 text-indigo-800' : 'bg-rose-100 text-rose-800') }}">
                                        {{ $log->type }}
                                    </span>
                                    <p class="text-xs text-zinc-500 font-medium italic">"{{ $log->reason }}"</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-zinc-400 text-sm font-medium">
                            📭 Belum ada pergerakan stok saat ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN --}}
        <div class="space-y-6">
            {{-- LOW STOCK ALERT (Sesuai gaya panel supervisor) --}}
            <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden flex flex-col h-full">
                <div class="px-5 py-4 border-b border-zinc-100 bg-rose-50/50">
                    <h2 class="font-extrabold text-rose-600 text-sm uppercase tracking-wider flex items-center gap-2">
                     🚨   Stok Kritis</h2>
                </div>
                <div class="p-5 divide-y divide-zinc-100 flex-1">
                    @forelse($lowStockItems as $stock)
                        <div class="py-3 flex justify-between items-center first:pt-0 last:pb-0">
                            <div>
                                <h4 class="text-xs font-bold text-zinc-800">{{ $stock->product->name }}</h4>
                                <span class="text-[10px] font-bold text-zinc-400 uppercase">Batas: {{ $stock->low_stock_threshold }}</span>
                            </div>
                            <span class="px-2.5 py-1 bg-rose-100 text-rose-700 rounded-md text-[10px] font-black uppercase tracking-wider">
                                Sisa: {{ $stock->quantity }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-12 text-emerald-600 text-xs font-bold">
                            Semua stok aman berada di atas batas minimum.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>