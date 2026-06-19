<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">
    
    {{-- EXECUTIVE HEADER --}}
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Finance & Audit</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Financial Summary & Settlement</h1>
            <p class="text-sm text-zinc-500 mt-1">Rekonsiliasi uang laci kasir dan pencocokan omzet sistem.</p>
        </div>
        <div class="w-full sm:w-auto">
            <input type="date" wire:model.live="filterDate"
                class="px-4 py-2.5 block w-full sm:w-48 rounded-xl border-zinc-200 bg-white shadow-sm text-sm font-bold text-zinc-700 focus:border-purple-500 focus:ring-purple-500"
                title="Pilih Tanggal Audit">
        </div>
    </div>

    @if(session()->has('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-sm text-emerald-700 font-medium shadow-sm flex items-center gap-2">
            ✨ {{ session('success') }}
        </div>
    @endif

    {{-- KARTU STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6 mb-8">
        <div class="bg-gradient-to-br from-zinc-900 to-zinc-800 p-6 rounded-2xl shadow-xl border border-zinc-700 text-white relative overflow-hidden group">
            <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Total Omzet Penjualan (Sistem)</p>
            <h3 class="text-3xl font-black mt-2 tracking-tight">Rp {{ number_format($grandTotalDeposit, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-zinc-200 shadow-sm">
            <p class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Akumulasi Struk Terbit Hari Ini</p>
            <h3 class="text-3xl font-black text-zinc-900 mt-2 tracking-tight">{{ $grandTotalTransactions }} Transaksi</h3>
        </div>
    </div>

    {{-- TABEL REKONSILIASI --}}
    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-zinc-100 bg-zinc-900 text-white">
            <h2 class="font-extrabold text-base uppercase tracking-wider text-[11px]">Daftar Serah Terima Kas Kasir</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Kasir Pelaksana</th>
                        <th class="px-6 py-4">Volume Transaksi</th>
                        <th class="px-6 py-4">Omzet Penjualan</th>
                        <th class="px-6 py-4 text-center">Tindakan Kontrol</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($cashierSummaries as $summary)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-black text-zinc-900">{{ $summary->user->name ?? 'Kasir Tidak Terdaftar' }}</div>
                                <div class="text-[10px] font-bold text-zinc-400 mt-0.5 uppercase">ID: #{{ $summary->user_id }}</div>
                            </td>
                            <td class="px-6 py-4 font-bold text-zinc-700">
                                {{ $summary->transaction_count }} Invoice Selesai
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[10px] font-bold text-zinc-500 uppercase">Sistem:</div>
                                <div class="text-sm font-black text-zinc-800">Rp {{ number_format($summary->total_deposit, 0, ',', '.') }}</div>

                                @if($summary->status_verifikasi === 'verified')
                                    <div class="text-[10px] font-bold text-zinc-500 mt-2 uppercase">Fisik Laci:</div>
                                    <div class="text-sm font-black text-purple-600">Rp {{ number_format($summary->nominal_uang_fisik, 0, ',', '.') }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($summary->status_verifikasi === 'verified')
                                    @php $diff = $summary->nominal_uang_fisik - $summary->total_deposit; @endphp
                                    <div class="flex flex-col items-center justify-center gap-1.5">
                                        @if($diff == 0)
                                            <span class="px-2.5 py-1 text-[10px] font-black bg-emerald-100 text-emerald-800 rounded-md uppercase">🟢 MATCH (BALANCE)</span>
                                        @elseif($diff < 0)
                                            <span class="px-2.5 py-1 text-[10px] font-black bg-rose-100 text-rose-800 rounded-md uppercase" title="{{ $summary->catatan_manajer }}">⚠️ MINUS Rp {{ number_format(abs($diff), 0, ',', '.') }}</span>
                                            <span class="text-[9px] text-rose-600 font-bold uppercase">Kasir Wajib Ganti</span>
                                        @else
                                            <span class="px-2.5 py-1 text-[10px] font-black bg-purple-100 text-purple-800 rounded-md uppercase" title="{{ $summary->catatan_manajer }}">📈 LEBIH Rp {{ number_format($diff, 0, ',', '.') }}</span>
                                        @endif
                                        <button wire:click="openVerification({{ $summary->user_id }}, '{{ $summary->user->name }}', {{ $summary->total_deposit }})" class="text-[10px] font-bold text-zinc-400 hover:text-purple-600 underline mt-1 transition-colors">Edit Hasil Rekon</button>
                                    </div>
                                @else
                                    <button wire:click="openVerification({{ $summary->user_id }}, '{{ $summary->user->name }}', {{ $summary->total_deposit }})"
                                        class="inline-flex items-center px-4 py-2 bg-zinc-900 hover:bg-zinc-800 text-white rounded-xl text-xs font-bold shadow-sm transition-all active:scale-95">
                                        Cocokkan Kas Fisik
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-12 text-center text-zinc-400 font-medium italic">Tidak ditemukan aktivitas transaksi kasir pada tanggal ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL VERIFIKASI (DISESUAIKAN) --}}
    @if($showVerifyModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-zinc-900/60 transition-opacity backdrop-blur-sm" wire:click="$set('showVerifyModal', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-zinc-200">
                    <div class="px-6 py-4 bg-zinc-50 border-b border-zinc-200 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-black text-zinc-900">Verifikasi Kas</h3>
                            <p class="text-xs font-bold text-zinc-500 mt-0.5">Kasir: <span class="text-zinc-800">{{ $selectedCashierName }}</span></p>
                        </div>
                    </div>

                    <div class="p-6 space-y-5 bg-white">
                        <div class="p-4 bg-zinc-50 border border-zinc-200 rounded-xl flex justify-between items-center">
                            <span class="text-xs font-bold text-zinc-600 uppercase tracking-wider">Omzet Sistem (Aplikasi)</span>
                            <span class="text-lg font-black text-zinc-900">Rp {{ number_format($systemAmount, 0, ',', '.') }}</span>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Jumlah Uang Fisik Di Laci (Rp)</label>
                            <input type="number" wire:model.live="physicalAmount" 
                                class="w-full px-4 py-3 bg-zinc-50 rounded-xl border-zinc-200 focus:ring-purple-500 focus:border-purple-500 text-lg font-black text-zinc-900 shadow-sm transition-all">
                            @error('physicalAmount') <span class="text-xs font-bold text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-3 rounded-xl border border-zinc-200 text-sm font-medium bg-zinc-50">
                            @php $diff = $physicalAmount - $systemAmount; @endphp
                            @if($diff === 0)
                                <div class="text-emerald-700 font-bold text-center">🟢 MATCH (BALANCE)</div>
                            @elseif($diff < 0)
                                <div class="text-rose-700 font-bold text-center">⚠️ SELISIH KURANG: Rp {{ number_format(abs($diff), 0, ',', '.') }}</div>
                            @else
                                <div class="text-purple-700 font-bold text-center">📈 SELISIH LEBIH: Rp {{ number_format($diff, 0, ',', '.') }}</div>
                            @endif
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Catatan Keterangan Selisih</label>
                            <textarea wire:model="notes" rows="2" placeholder="Contoh: Selisih kurang karena salah kembalian..."
                                class="w-full text-sm font-medium px-4 py-3 bg-zinc-50 rounded-xl border-zinc-200 focus:ring-purple-500 focus:border-purple-500 shadow-sm transition-all"></textarea>
                            @error('notes') <span class="text-xs font-bold text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="bg-zinc-50 px-6 py-4 border-t border-zinc-200 flex flex-col-reverse sm:flex-row justify-end gap-2">
                        <button type="button" wire:click="$set('showVerifyModal', false)"
                            class="px-4 py-2.5 bg-zinc-100 text-zinc-700 rounded-xl text-xs font-bold hover:bg-zinc-200 transition-all shadow-sm">
                            Batal
                        </button>
                        <button type="button" wire:click="saveVerification"
                            class="px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-bold shadow-sm transition-all active:scale-95">
                            Simpan Rekonsiliasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>