<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen space-y-6">

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-2 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span
                    class="px-2.5 py-0.5 bg-rose-100 text-rose-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Security
                    & Compliance</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Unified System Audit Log</h1>
            <p class="text-sm text-zinc-500 mt-1">Pusat pengawasan aktivitas sistem, inventori, dan kasir seluruh cabang
                secara terpusat.</p>
        </div>
    </div>

    <div class="p-5 bg-white rounded-2xl border border-zinc-200 shadow-sm grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-wider mb-2">Cari
                Kronologi/Kasus</label>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kata kunci audit..."
                class="w-full text-sm px-4 py-2.5 bg-zinc-50 border-zinc-200 rounded-xl font-medium text-zinc-800 focus:ring-purple-500 focus:border-purple-500">
        </div>
        <div>
            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-wider mb-2">Lokasi
                Cabang</label>
            <select wire:model.live="filterBranch"
                class="w-full text-sm px-4 py-2.5 bg-zinc-50 border-zinc-200 rounded-xl font-semibold text-zinc-700 focus:ring-purple-500 focus:border-purple-500">
                <option value="">Semua Cabang / Gerai</option>
                @foreach($branches as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-wider mb-2">Kategori
                Tindakan</label>
            <select wire:model.live="filterAction"
                class="w-full text-sm px-4 py-2.5 bg-zinc-50 border-zinc-200 rounded-xl font-semibold text-zinc-700 focus:ring-purple-500 focus:border-purple-500">
                <option value="">Semua Jenis Kategori</option>
                @foreach($availableActions as $action)
                    <option value="{{ $action }}">{{ str_replace('_', ' ', $action) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Waktu Kejadian</th>
                        <th class="px-6 py-4">Cabang</th>
                        <th class="px-6 py-4">Aktor</th>
                        <th class="px-6 py-4">Kronologi Kegiatan</th>
                        <th class="px-6 py-4 text-center">Tingkat Risiko</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-zinc-600">
                                {{ $log->created_at->format('d M Y - H:i:s') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 bg-zinc-200 text-zinc-800 text-[10px] font-bold rounded-md uppercase">
                                    {{ $log->branch->name ?? 'Pusat' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-black text-zinc-900">{{ $log->user->name ?? 'System' }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-zinc-700 max-w-md break-words">
                                {{ $log->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if(in_array($log->action, ['REJECT', 'LOGIN_FAILED', 'DELETE']))
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-rose-100 text-rose-800">
                                        🚨 High Risk
                                    </span>
                                @elseif(in_array($log->action, ['FINANCIAL_RECONCILIATION', 'VOID_APPROVED', 'ADJUSTMENT']))
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-purple-100 text-purple-800">
                                        ⚠️ Audit Required
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-800">
                                        🟢 Routine
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-sm font-medium text-zinc-400 italic">Belum
                                ada aktivitas yang tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50/50">{{ $logs->links() }}</div>
        @endif
    </div>
</div>