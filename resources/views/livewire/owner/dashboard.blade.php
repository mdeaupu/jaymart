<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen">
    
    {{-- EXECUTIVE HEADER --}}
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 bg-purple-100 text-purple-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Owner Control Center</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Sistem Konsolidasi Jaymart Group</h1>
            <p class="text-sm text-zinc-500">Pemantauan 5 Cabang Aktif, Audit Fraud Transaksi, dan Kontrol Inventori Terpusat.</p>
        </div>
        
        {{-- INTERAKSI OWNER: FILTER WAKTU JARAK JAUH --}}
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <select wire:model.live="filterPeriod" class="rounded-xl border-zinc-300 bg-white shadow-sm text-sm font-semibold text-zinc-700 focus:border-purple-500 focus:ring-purple-500">
                <option value="today">Hari Ini</option>
                <option value="week">Minggu Ini</option>
                <option value="month">Bulan Ini</option>
            </select>
            <div class="bg-white shadow-sm px-4 py-2 rounded-xl border border-zinc-200 text-xs font-bold text-zinc-600 whitespace-nowrap">
                🟢 Live Server Terkoneksi
            </div>
        </div>
    </div>

    {{-- KARTU STATISTIK AGREGAT KONSOLIDASI (3 KOLOM MAKIN POWERFUL) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 lg:gap-6 mb-8">
        {{-- REVENUE AGREGAT --}}
        <div class="bg-gradient-to-br from-zinc-900 to-zinc-800 p-6 rounded-2xl shadow-xl border border-zinc-700 flex flex-col justify-between text-white relative overflow-hidden group">
            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Total Omzet Konsolidasi (Semua Cabang)</p>
                <h3 class="text-3xl font-black mt-2 tracking-tight">Rp {{ number_format($totalRevenueAllBranch, 0, ',', '.') }}</h3>
            </div>
            <div class="text-[11px] text-zinc-400 mt-4">
                Pendapatan kotor akumulatif berjalan dari 5 kota berbeda.
            </div>
        </div>

        {{-- TOTAL VOLUME TRANSAKSI GROUP --}}
        <div class="bg-white p-6 rounded-2xl border border-zinc-200 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Akumulasi Dokumen Nota Belanja</p>
                <h3 class="text-3xl font-black text-zinc-900 mt-2 tracking-tight">{{ $totalTransactionsAllBranch }} Struk POS</h3>
            </div>
            <div class="text-xs text-emerald-600 font-bold mt-4">
                ✓ Seluruh transaksi terekam otomatis di MySQL Cloud.
            </div>
        </div>

        {{-- TOTAL LOSS DARI MANIPULASI/VOID (POIN KRUSIAL PAK JAYUSMAN) --}}
        <div class="bg-white p-6 rounded-2xl border border-rose-200 shadow-sm flex flex-col justify-between relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-rose-50 rounded-bl-full -z-0 opacity-50"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-rose-500 uppercase tracking-wider">Dampak Koreksi Struk / Potensi Kebocoran</p>
                <h3 class="text-3xl font-black text-rose-600 mt-2 tracking-tight">Rp {{ number_format($totalLossFromCorrections, 0, ',', '.') }}</h3>
            </div>
            <div class="text-xs text-rose-700 font-medium mt-4">
                ⚠ Total pengurangan nilai nota yang disetujui Supervisor/Manager.
            </div>
        </div>
    </div>

    {{-- KONTEN ANALISIS UTAMA --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        {{-- KOLOM KIRI & TENGAH: PERFORMA DAN TINGKAT RISIKO TIAP CABANG --}}
        <div class="xl:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-zinc-100 bg-zinc-900 flex justify-between items-center text-white">
                    <div>
                        <h2 class="font-extrabold text-base">Komparasi dan Matriks Pengawasan Cabang</h2>
                        <p class="text-xs text-zinc-400 mt-0.5">Analisis real-time pendapatan vs jumlah pembatalan item kasir</p>
                    </div>
                </div>

                <div class="p-6">
                    <div class="space-y-6">
                        @foreach($branchPerformances as $b)
                            <div class="p-4 bg-zinc-50 border border-zinc-200 rounded-xl">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-3">
                                    <div>
                                        <h4 class="text-base font-black text-zinc-800">{{ $b['name'] }}</h4>
                                        <p class="text-xs text-zinc-500">Omzet Terkumpul: <span class="font-bold text-zinc-900">Rp {{ number_format($b['revenue'], 0, ',', '.') }}</span></p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2.5 py-1 text-xs font-extrabold rounded-full {{ $b['fraud_risk_count'] > 5 ? 'bg-red-100 text-red-800' : 'bg-zinc-200 text-zinc-700' }}">
                                            {{ $b['fraud_risk_count'] }} Kasus Koreksi Struk
                                        </span>
                                        <p class="text-xs text-rose-600 font-semibold mt-1">Senilai: -Rp {{ number_format($b['fraud_risk_value'], 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                
                                {{-- Visual Progress Bar Komparatif Omzet --}}
                                @php 
                                    $percentage = $totalRevenueAllBranch > 0 ? ($b['revenue'] / $totalRevenueAllBranch) * 100 : 0;
                                @endphp
                                <div class="w-full bg-zinc-200 h-2 rounded-full overflow-hidden">
                                    <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="text-[10px] text-zinc-400 mt-1 text-right">Kontribusi Makro: {{ round($percentage, 1) }}% dari total grup</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- INVESTIGASI LOG RIWAYAT INTERVENSI PEGAWAI (MENCEGAH KETIDAKJUJURAN) --}}
            <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-zinc-100 bg-zinc-100">
                    <h3 class="font-extrabold text-zinc-800 text-sm uppercase tracking-wider">🕵️‍♂️ Log Audit Anti-Fraud (Multi-Cabang)</h3>
                    <p class="text-xs text-zinc-500 mt-0.5">Pantau otorisasi penghapusan barang atau void yang disetujui Manager/Supervisor lapangan.</p>
                </div>
                <div class="divide-y divide-zinc-200">
                    @forelse($recentAuditLogs as $log)
                        <div class="p-4 hover:bg-zinc-50/50 transition flex justify-between items-center text-xs">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-zinc-900">[{{ $log->branch->name ?? 'Cabang' }}]</span>
                                    <span class="px-2 py-0.5 text-[9px] font-bold rounded {{ $log->action === 'REJECT' ? 'bg-red-100 text-red-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ $log->action }}
                                    </span>
                                </div>
                                <p class="text-zinc-600 font-medium">{{ $log->description }}</p>
                                <p class="text-[10px] text-zinc-400">Oleh: <span class="font-semibold text-zinc-700">{{ $log->user->name ?? 'System' }}</span> | {{ $log->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-zinc-400">Belum ada aktivitas otorisasi berisiko hari ini.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: MONITORING INVENTORI 5 CABANG (CEK STOK KAPAN SAJA) --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm p-5">
                <div class="border-b border-zinc-100 pb-3 mb-4">
                    <h3 class="font-extrabold text-zinc-800 text-sm uppercase tracking-wider text-red-600 flex items-center gap-1">
                        🚨 Radar Stok Kritis (Multi-Cabang)
                    </h3>
                    <p class="text-[11px] text-zinc-400 mt-0.5">Memastikan pegawai gudang tidak memanipulasi hilangnya stok.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider">
                                <th class="p-2 font-bold">Produk</th>
                                <th class="p-2 font-bold">Cabang</th>
                                <th class="p-2 font-bold text-right">Sisa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100">
                            @forelse($criticalStocks as $stock)
                                <tr class="hover:bg-zinc-50 transition-colors">
                                    <td class="p-2 font-semibold text-zinc-950">{{ $stock->product->name }}</td>
                                    <td class="p-2 text-zinc-600"><span class="px-1.5 py-0.5 bg-zinc-200 text-zinc-700 rounded text-[10px] font-medium">{{ $stock->branch->name }}</span></td>
                                    <td class="p-2 text-right font-black text-red-600">{{ $stock->quantity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-zinc-400 italic">Seluruh cabang aman dari kehabisan stok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>