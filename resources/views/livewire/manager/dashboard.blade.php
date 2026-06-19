<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- HEADER UTAMA --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-purple-100 text-purple-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Eksekutif
                    Panel</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Dashboard Manager Cabang</h1>
            <p class="text-sm text-zinc-500 mt-1">Analisis performa bisnis, pengendalian kebocoran omzet, dan otorisasi
                finansial.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <div
                class="bg-white shadow-sm px-4 py-2 rounded-xl border border-zinc-200 text-xs font-bold text-zinc-600 whitespace-nowrap flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Mode Pengawasan Aktif: <span class="text-zinc-900 font-bold">{{ now()->format('d M Y') }}</span>
            </div>
        </div>
    </div>

    {{-- NOTIFIKASI ACTION --}}
    @if(session()->has('success'))
        <div
            class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-sm text-emerald-700 font-medium shadow-sm flex items-center gap-2">
            ✨ {{ session('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div
            class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl text-sm text-rose-700 font-medium shadow-sm flex items-center gap-2">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- KARTU STATISTIK STRATEGIS (3 KOLOM PREMIUM) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 lg:gap-6 mb-8">
        {{-- OMZET BERSIH --}}
        <div
            class="bg-gradient-to-br from-zinc-900 to-zinc-800 p-6 rounded-2xl shadow-xl border border-zinc-700 flex flex-col justify-between text-white relative overflow-hidden group">
            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Omzet Bersih Cabang</p>
                <h3 class="text-3xl font-black mt-2 tracking-tight">Rp {{ number_format($totalOmzet, 0, ',', '.') }}
                </h3>
            </div>
            <div class="text-[11px] text-zinc-400 mt-4 flex items-center gap-1">
                ↑ Pendapatan riil setelah dikurangi koreksi kasir yang valid.
            </div>
        </div>

        {{-- TOTAL TRANSAKSI --}}
        <div class="bg-white p-6 rounded-2xl border border-zinc-200 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Volume Transaksi Sukses</p>
                <h3 class="text-3xl font-black text-zinc-900 mt-2 tracking-tight">{{ $totalTransactions }} Struk Belanja
                </h3>
            </div>
            <div class="text-xs text-emerald-600 font-bold mt-4">
                ✓ Total traffic pelayanan POS hari ini.
            </div>
        </div>

        {{-- RETUR / KEBOCORAN DITANGGULANGI --}}
        <div
            class="bg-white p-6 rounded-2xl border border-rose-200 shadow-sm flex flex-col justify-between relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-rose-50 rounded-bl-full -z-0 opacity-50"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-rose-500 uppercase tracking-wider">Total Kebocoran / Koreksi Kasir</p>
                <h3 class="text-3xl font-black text-rose-600 mt-2 tracking-tight">Rp
                    {{ number_format($totalLeakedCorrection, 0, ',', '.') }}
                </h3>
            </div>
            <div class="text-xs text-rose-700 font-medium mt-4 flex items-center gap-1">
                ⚠ Nilai omzet yang hilang akibat pembatalan item kasir hari ini.
            </div>
        </div>
    </div>

    {{-- KONTEN UTAMA: KEPUTUSAN & ANALITIK --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        {{-- KOLOM KIRI & TENGAH: PENGATURAN OTORISASI BERKAS BESAR --}}
        <div class="xl:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-zinc-100 bg-zinc-900 flex justify-between items-center text-white">
                    <div>
                        <h2 class="font-extrabold text-base">Otorisasi Berkas Koreksi Skala Besar</h2>
                        <p class="text-xs text-zinc-400 mt-0.5">Memerlukan persetujuan tingkat Manager (Dampak Kerugian
                            &ge; Rp 200.000)</p>
                    </div>
                    <span
                        class="px-2.5 py-1 bg-amber-500 text-zinc-950 text-xs font-black rounded-full">{{ count($escalatedCorrections) }}
                        Antrean</span>
                </div>

                <div class="divide-y divide-zinc-100 max-h-[500px] overflow-y-auto">
                    @forelse($escalatedCorrections as $void)
                        <div
                            class="p-5 hover:bg-zinc-50 transition flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="space-y-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-zinc-900">Nota #{{ $void->transaction_id }}</span>
                                    <span
                                        class="px-2 py-0.5 bg-rose-100 text-rose-800 text-[10px] font-black rounded uppercase">Dampak:
                                        Rp {{ number_format($void->financial_impact, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-xs text-zinc-600 font-medium">
                                    Produk: <span
                                        class="text-zinc-900 font-bold">{{ $void->product->name ?? 'Produk Dihapus' }}</span>
                                    (<span class="text-red-500 font-semibold">{{ $void->wrong_quantity }} pcs</span> &rarr;
                                    <span class="text-emerald-600 font-bold">{{ $void->corrected_quantity }} pcs</span>)
                                </p>
                                <p class="text-[11px] text-zinc-400">
                                    Diajukan oleh Kasir: <span
                                        class="font-semibold text-zinc-700">{{ $void->user->name ?? '-' }}</span>
                                </p>
                                <div
                                    class="p-2 bg-amber-50/70 border border-amber-200 rounded-lg text-xs text-amber-800 italic font-mono">
                                    "{{ $void->reason }}"
                                </div>
                            </div>

                            {{-- TOMBOL AKSI OTORISASI LANGSUNG --}}
                            <div class="flex gap-2 w-full md:w-auto justify-end">
                                <button wire:click="rejectEscalated({{ $void->id }})"
                                    class="px-3 py-2 bg-white border border-zinc-300 text-rose-600 rounded-xl text-xs font-bold hover:bg-rose-50 transition">
                                    Tolak
                                </button>
                                <button wire:click="approveEscalated({{ $void->id }})"
                                    class="px-4 py-2 bg-purple-600 text-white rounded-xl text-xs font-bold hover:bg-purple-700 shadow-sm transition">
                                    Otorisasi Setuju
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-zinc-400 text-sm">
                            🎉 Bersih! Tidak ada antrean otorisasi keuangan kritis saat ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: STATISTIK PARETO & PRODUK KRITIS --}}
        <div class="space-y-6">
            {{-- 1. ANALISIS PRODUK TERLARIS (PARETO PERFORMANCE) --}}
            <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm p-5">
                <h3
                    class="font-extrabold text-zinc-800 text-sm uppercase tracking-wider mb-4 flex items-center gap-1.5">
                    🏆 5 Produk Unggulan Hari Ini
                </h3>
                <div class="space-y-3.5">
                    @forelse($bestSellers as $index => $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span
                                    class="w-6 h-6 flex items-center justify-center rounded-full bg-zinc-100 text-zinc-700 font-bold text-xs">
                                    {{ $index + 1 }}
                                </span>
                                <span
                                    class="text-xs font-bold text-zinc-700 truncate max-w-[140px]">{{ $item->product->name ?? 'Unknown' }}</span>
                            </div>
                            <span class="px-2 py-1 bg-purple-50 text-purple-700 font-bold text-xs rounded-lg">
                                {{ $item->total_sold }} Pcs Terjual
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-zinc-400 text-center py-4">Belum ada data penjualan masuk.</p>
                    @endforelse
                </div>
            </div>

            {{-- 2. ALERT STOK MENIPIS (CONTROL INVENTORI MANAGER) --}}
            <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm p-5">
                <div class="border-b border-zinc-100 pb-3 mb-4">
                    <h3
                        class="font-extrabold text-zinc-800 text-sm uppercase tracking-wider text-rose-600 flex items-center gap-1.5">
                        🚨 Warning Manajemen Stok Kritis
                    </h3>
                </div>
                <div class="space-y-3 max-h-[250px] overflow-y-auto">
                    @forelse($lowStocks as $stock)
                        <div class="p-3 bg-rose-50/50 border border-rose-100 rounded-xl flex justify-between items-center">
                            <div>
                                <h4 class="text-xs font-bold text-zinc-800">{{ $stock->product->name ?? 'Unknown' }}</h4>
                                <p class="text-[10px] text-zinc-400">Ambangan limit: {{ $stock->low_stock_threshold }} pcs
                                </p>
                            </div>
                            <span class="px-2.5 py-1 bg-rose-600 text-white text-xs font-black rounded-lg">
                                {{ $stock->quantity }} Pcs
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-emerald-600 text-xs font-semibold">
                            ✅ Seluruh stok aman di atas ambang batas minimum.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>