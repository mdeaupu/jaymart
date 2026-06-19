<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-blue-100 text-blue-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Supervisor
                    Panel</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Dashboard Pengawas</h1>
            <p class="text-sm text-zinc-500 mt-1">Pantauan real-time operasional gerai Jaymart hari ini.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <div
                class="bg-white shadow-sm px-4 py-2 rounded-xl border border-zinc-200 text-xs font-bold text-zinc-600 whitespace-nowrap flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Tanggal: <span class="text-zinc-900 font-bold">{{ now()->format('d M Y') }}</span>
            </div>
        </div>
    </div>

    @if(session()->has('success'))
        <div
            class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-sm text-emerald-700 font-medium shadow-sm flex items-center gap-2">
            ✨ {{ session('success') }}</div>
    @endif
    @if(session()->has('error'))
        <div
            class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl text-sm text-rose-700 font-medium shadow-sm flex items-center gap-2">
            ❌ {{ session('error') }}</div>
    @endif

    {{-- KARTU STATISTIK STRATEGIS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-8">
        {{-- OMZET HARI INI --}}
        <div
            class="bg-gradient-to-br from-zinc-900 to-zinc-800 p-6 rounded-2xl shadow-xl border border-zinc-700 flex flex-col justify-between text-white relative overflow-hidden">
            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Omzet Gerai Hari Ini</p>
                <h3 class="text-3xl font-black mt-2 tracking-tight">Rp
                    {{ number_format($totalSalesToday, 0, ',', '.') }}</h3>
            </div>
        </div>

        {{-- TOTAL TRANSAKSI --}}
        <div class="bg-white p-6 rounded-2xl border border-zinc-200 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Jumlah Struk Sukses</p>
                <h3 class="text-3xl font-black text-zinc-900 mt-2 tracking-tight">{{ $transactionCountToday }} Transaksi
                </h3>
            </div>
        </div>

        {{-- VOID PENDING --}}
        <div
            class="bg-white p-6 rounded-2xl border {{ $pendingVoidCount > 0 ? 'border-amber-200' : 'border-zinc-200' }} shadow-sm flex flex-col justify-between sm:col-span-2 lg:col-span-1">
            <div>
                <p
                    class="text-xs font-bold {{ $pendingVoidCount > 0 ? 'text-amber-500' : 'text-zinc-400' }} uppercase tracking-wider">
                    Butuh Approval Void</p>
                <h3
                    class="text-3xl font-black {{ $pendingVoidCount > 0 ? 'text-amber-600' : 'text-zinc-900' }} mt-2 tracking-tight">
                    {{ $pendingVoidCount }} Pengajuan
                </h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        {{-- KOLOM KIRI & TENGAH --}}
        <div class="xl:col-span-2 space-y-8">

            {{-- VOID APPROVAL --}}
            <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-zinc-100 bg-zinc-900 flex justify-between items-center text-white">
                    <div>
                        <h2 class="font-extrabold text-base">Persetujuan Void & Koreksi Kasir</h2>
                        <p class="text-xs text-zinc-400 mt-0.5">Tinjau dan proses pembatalan transaksi oleh kasir.</p>
                    </div>
                    <span
                        class="px-2.5 py-1 bg-amber-500 text-zinc-950 text-xs font-black rounded-full">{{ $pendingVoidCount }}
                        Pending</span>
                </div>

                <div class="divide-y divide-zinc-100 max-h-[400px] overflow-y-auto">
                    @forelse($pendingCorrections as $void)
                        <div
                            class="p-5 hover:bg-zinc-50 transition flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="space-y-1.5">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-sm font-bold text-zinc-900">{{ $void->transaction->invoice_number }}</span>
                                    <span
                                        class="px-2 py-0.5 bg-zinc-100 text-zinc-600 text-[10px] font-black rounded uppercase">Kasir:
                                        {{ $void->user->name }}</span>
                                </div>
                                <p class="text-xs text-zinc-600 font-medium">
                                    Produk: <span class="text-zinc-900 font-bold">{{ $void->product->name }}</span>
                                </p>
                                <div class="text-[11px] font-bold text-zinc-500">
                                    Koreksi Kuantitas:
                                    <span class="line-through text-zinc-400">{{ $void->wrong_quantity }} pcs</span> ➔
                                    <span class="text-purple-600">{{ $void->corrected_quantity }} pcs</span>
                                </div>
                                <div
                                    class="p-2 bg-amber-50 border border-amber-100 rounded-lg text-xs text-amber-800 italic font-mono mt-1">
                                    "{{ $void->reason }}"
                                </div>
                            </div>
                            <div class="flex gap-2 w-full md:w-auto justify-end">
                                <button wire:click="rejectVoid({{ $void->id }})"
                                    class="px-3 py-2 bg-white border border-zinc-300 text-rose-600 rounded-xl text-xs font-bold hover:bg-rose-50 transition">Tolak</button>
                                <button wire:click="approveVoid({{ $void->id }})"
                                    class="px-4 py-2 bg-purple-600 text-white rounded-xl text-xs font-bold hover:bg-purple-700 shadow-sm transition">Setujui
                                    Void</button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-zinc-400 text-sm font-medium">
                            ☕ Tidak ada antrean pembatalan/void saat ini. Operasional bersih.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- 5 TRANSAKSI TERAKHIR --}}
            <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-zinc-100">
                    <h2 class="font-extrabold text-zinc-800 text-sm uppercase tracking-wider">Log 5 Transaksi Terakhir
                    </h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                            <tr>
                                <th class="px-6 py-4">No. Invoice</th>
                                <th class="px-6 py-4">Waktu</th>
                                <th class="px-6 py-4">Kasir</th>
                                <th class="px-6 py-4">Shift</th>
                                <th class="px-6 py-4 text-right">Total Belanja</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100">
                            @foreach($recentTransactions as $trx)
                                <tr class="hover:bg-zinc-50 transition-colors">
                                    <td class="px-6 py-4 font-black text-zinc-900">{{ $trx->invoice_number }}</td>
                                    <td class="px-6 py-4 text-[10px] font-bold text-zinc-500 tracking-wider">
                                        {{ $trx->created_at->format('H:i:s') }} WIB</td>
                                    <td class="px-6 py-4 font-bold text-zinc-700">{{ $trx->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider {{ $trx->shift == 'Pagi' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $trx->shift }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-emerald-600">Rp
                                        {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN --}}
        <div class="space-y-6">
            {{-- LOW STOCK --}}
            <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-zinc-100 bg-rose-50/50">
                    <h2 class="font-extrabold text-rose-600 text-sm uppercase tracking-wider flex items-center gap-2">
                     🚨   Low Stock Alert</h2>
                </div>
                <div class="p-5 divide-y divide-zinc-100">
                    @forelse($lowStockProducts as $stock)
                        <div class="py-3 flex justify-between items-center first:pt-0 last:pb-0">
                            <div>
                                <h4 class="text-xs font-bold text-zinc-800">{{ $stock->product->name }}</h4>
                                <span class="text-[10px] font-bold text-zinc-400 uppercase">SKU:
                                    {{ $stock->product_id }}</span>
                            </div>
                            <span
                                class="px-2.5 py-1 bg-rose-100 text-rose-700 rounded-md text-[10px] font-black uppercase tracking-wider">
                                Sisa: {{ $stock->quantity }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-6 text-emerald-600 text-xs font-bold">
                            Semua stok aman berada di atas batas minimum.
                        </div>
                    @endforelse
                </div>
                <div class="p-4 bg-zinc-50 border-t border-zinc-100 text-center">
                    <a href="{{ route('supervisor.verify-opname') }}"
                        class="text-[11px] font-black uppercase tracking-wider text-purple-600 hover:text-purple-800 transition">Verifikasi
                        Opname ➔</a>
                </div>
            </div>

            {{-- QUICK ACCESS --}}
            <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm p-5 space-y-3">
                <h3 class="font-black text-zinc-800 text-sm uppercase tracking-wider mb-3">Akses Cepat Pengawasan</h3>
                <a href="{{ route('supervisor.verify-void') }}"
                    class="block p-3.5 bg-zinc-50 hover:bg-purple-50 hover:border-purple-200 rounded-xl border border-zinc-100 font-bold text-xs text-zinc-700 transition">📋
                    Log Riwayat Void Disetujui</a>
                <a href="{{ route('supervisor.opname-history') }}"
                    class="block p-3.5 bg-zinc-50 hover:bg-purple-50 hover:border-purple-200 rounded-xl border border-zinc-100 font-bold text-xs text-zinc-700 transition">🔄
                    Riwayat Penyesuaian Stok (Audit)</a>
            </div>
        </div>
    </div>
</div>