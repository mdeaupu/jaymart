<div wire:poll.10s class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 bg-rose-100 text-rose-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Forensics</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Audit Trail Aktivitas</h1>
            <p class="text-sm text-zinc-500 mt-1">Riwayat seluruh aktivitas operasional pegawai pada sistem internal cabang.</p>
        </div>
        <div class="w-full sm:w-auto">
            <span class="px-4 py-2 bg-white border border-zinc-200 rounded-xl text-[10px] font-black text-zinc-500 uppercase tracking-wider shadow-sm flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Auto-refresh: 10s
            </span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-zinc-100 bg-zinc-900 flex justify-between items-center text-white">
            <h3 class="text-sm font-bold uppercase tracking-wider">Log Rekam Jejak Sistem</h3>
            <span class="px-2.5 py-1 text-[10px] font-black rounded-md bg-zinc-800 text-zinc-300">
                Data Halaman: {{ $logs->count() }} Baris
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Waktu Rekam</th>
                        <th class="px-6 py-4">Pelaku (User)</th>
                        <th class="px-6 py-4 text-center">Tindakan</th>
                        <th class="px-6 py-4">Deskripsi Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-black text-zinc-900">{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-[10px] font-bold text-zinc-400 mt-0.5 tracking-wider">{{ $log->created_at->format('H:i:s') }} WIB</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-black text-zinc-800">{{ $log->user->name ?? 'System' }}</div>
                                <div class="text-[10px] font-bold text-purple-600 uppercase mt-0.5">
                                    📍 {{ $log->branch->name ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $action = strtolower($log->action);
                                    $badgeClass = match($action) {
                                        'approve', 'approved', 'create', 'insert' => 'bg-emerald-100 text-emerald-800',
                                        'reject', 'rejected', 'delete', 'void' => 'bg-rose-100 text-rose-800',
                                        'update', 'edit' => 'bg-amber-100 text-amber-800',
                                        default => 'bg-blue-100 text-blue-800'
                                    };
                                @endphp
                                <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-black tracking-wider uppercase {{ $badgeClass }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-zinc-700 max-w-md break-words">
                                {{ $log->description }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-16 text-zinc-400 italic text-sm font-medium">
                                📭 Antrean log bersih. Belum ada aktivitas terekam untuk cabang ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50/50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>