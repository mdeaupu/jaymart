<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-blue-100 text-blue-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Inventory
                    Audit</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Riwayat Verifikasi Opname</h1>
            <p class="text-sm text-zinc-500 mt-1">Pantau status akhir dari penyesuaian stok yang telah diproses.</p>
        </div>
    </div>

    <div
        class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-between bg-white p-4 rounded-2xl border border-zinc-200 shadow-sm">
        <div class="w-full md:w-1/3">
            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Pencarian</label>
            <input type="text" wire:model.live="search" placeholder="Cari nama produk atau SKU..."
                class="w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl shadow-sm text-sm font-medium focus:ring-purple-500 focus:border-purple-500">
        </div>
        <div class="w-full md:w-1/4">
            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Filter Status</label>
            <select wire:model.live="statusFilter"
                class="w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl shadow-sm text-sm font-medium focus:ring-purple-500 focus:border-purple-500">
                <option value="">-- Semua Status --</option>
                <option value="approved">Disetujui (Selesai)</option>
                <option value="escalated">Dieskalasi ke Owner</option>
                <option value="rejected">Ditolak</option>
            </select>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Tanggal & Staff</th>
                        <th class="px-6 py-4">Detail Produk</th>
                        <th class="px-6 py-4 text-center">Komputer ➔ Fisik</th>
                        <th class="px-6 py-4 text-center">Selisih</th>
                        <th class="px-6 py-4">Catatan Audit</th>
                        <th class="px-6 py-4 text-center">Status Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($histories as $item)
                        @php
                            $statusStyle = match ($item->status) {
                                'pending' => 'bg-zinc-100 text-zinc-600',
                                'escalated' => 'bg-amber-100 text-amber-800',
                                'approved' => 'bg-emerald-100 text-emerald-800',
                                'rejected' => 'bg-rose-100 text-rose-800',
                                default => 'bg-zinc-100 text-zinc-600'
                            };
                            $statusLabel = match ($item->status) {
                                'pending' => 'Menunggu',
                                'escalated' => 'Dialihkan ke Owner',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                default => $item->status
                            };
                        @endphp
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-black text-zinc-900">{{ $item->created_at->format('d M Y H:i') }}</div>
                                <div class="text-[10px] font-bold text-zinc-400 mt-0.5 uppercase tracking-wider">Oleh:
                                    {{ $item->user->name ?? 'Staff Gudang' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-black text-zinc-800">{{ $item->product->name ?? 'Produk Terhapus' }}</div>
                                <div class="text-[10px] font-bold text-zinc-500 uppercase mt-0.5">
                                    {{ $item->product->sku ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-mono">
                                <span class="text-zinc-500">{{ $item->old_quantity }}</span>
                                <span class="mx-2 text-zinc-300">➔</span>
                                <span class="font-black text-zinc-900">{{ $item->new_quantity }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="px-2.5 py-1 text-[10px] font-black rounded-md uppercase tracking-wider bg-rose-50 text-rose-700">
                                    {{ $item->adjustment_amount }} pcs
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-zinc-600 max-w-xs break-words">
                                {{ $item->reason }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="inline-flex px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider {{ $statusStyle }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm font-medium text-zinc-400 italic">
                                Belum ada riwayat verifikasi opname di cabang ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($histories->hasPages())
            <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50/50">
                {{ $histories->links() }}
            </div>
        @endif
    </div>
</div>