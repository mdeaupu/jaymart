<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-blue-100 text-blue-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Activity
                    Log</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Riwayat Pengajuan & Opname</h1>
            <p class="text-sm text-zinc-500 mt-1">Pantau status persetujuan perubahan stok yang telah diajukan.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Tanggal & Pelapor</th>
                        <th class="px-6 py-4">Produk Terkait</th>
                        <th class="px-6 py-4 text-center">Perubahan Kuantitas</th>
                        <th class="px-6 py-4">Alasan / Catatan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($histories as $item)
                        @php
                            $statusStyle = match ($item->status) {
                                'pending' => 'bg-zinc-100 text-zinc-600',
                                're_audit' => 'bg-rose-100 text-rose-800',
                                'escalated_to_manager' => 'bg-blue-100 text-blue-800',
                                'escalated_to_owner' => 'bg-amber-100 text-amber-800',
                                'approved' => 'bg-emerald-100 text-emerald-800',
                                'rejected' => 'bg-red-100 text-red-800',
                                default => 'bg-zinc-100 text-zinc-600'
                            };

                            $statusLabel = match ($item->status) {
                                'pending' => 'Menunggu SPV',
                                're_audit' => 'Hitung Ulang',
                                'escalated_to_manager' => 'Cek Manager',
                                'escalated_to_owner' => 'Otorisasi Owner',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                default => $item->status
                            };
                        @endphp
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-black text-zinc-900">{{ $item->created_at->format('d M Y H:i') }}</div>
                                <div class="text-[10px] font-bold text-zinc-400 mt-0.5 uppercase tracking-wider">Oleh:
                                    {{ $item->user->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-black text-zinc-800">{{ $item->product->name ?? 'Produk Terhapus' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-mono">
                                <span class="text-zinc-400">{{ $item->old_quantity }}</span>
                                <span class="text-zinc-300 mx-1">➔</span>
                                <span
                                    class="font-black text-purple-700 bg-purple-50 px-2 py-0.5 rounded">{{ $item->new_quantity }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-zinc-600 max-w-xs break-words">
                                {{ $item->reason }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider {{ $statusStyle }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-zinc-400 font-medium italic">Belum ada
                                riwayat penyesuaian barang di cabang ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>