<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen">
    <x-alert type="error" :message="session('error')" />
    <x-alert type="success" :message="session('message')" />

    {{-- EXECUTIVE HEADER --}}
    <div class="mb-8 border-b border-zinc-200 pb-6">
        <div class="flex items-center gap-2 mb-1">
            <span class="px-2.5 py-0.5 bg-blue-100 text-blue-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Procurement</span>
        </div>
        <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Persetujuan Purchase Order (PO)</h1>
        <p class="text-sm text-zinc-500 mt-1">Tinjau dan setujui pengajuan nota belanja ke supplier dari Manager Toko.</p>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Tanggal & PO</th>
                        <th class="px-6 py-4">Cabang & Pemohon</th>
                        <th class="px-6 py-4">Supplier</th>
                        <th class="px-6 py-4">Total Estimasi</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($purchases as $purchase)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-black text-zinc-900">{{ $purchase->po_number }}</div>
                                <div class="text-xs font-medium text-zinc-500 mt-0.5">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-zinc-800">{{ $purchase->branch->name ?? '-' }}</div>
                                <div class="text-xs font-medium text-zinc-500 mt-0.5">Oleh: {{ $purchase->user->name ?? 'Manager' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-700">
                                {{ $purchase->supplier->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-emerald-600">
                                Rp {{ number_format($purchase->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="viewDetail({{ $purchase->id }})"
                                        class="px-3 py-1.5 bg-zinc-100 text-zinc-700 rounded-lg text-xs font-bold hover:bg-zinc-200 transition-all shadow-sm">
                                        👁️ Cek Nota
                                    </button>
                                    <button wire:click="approvePurchase({{ $purchase->id }})" wire:confirm="Setujui pengadaan stok ini?"
                                        class="px-3 py-1.5 bg-zinc-900 text-white rounded-lg text-xs font-bold hover:bg-zinc-800 transition-all shadow-sm active:scale-95">
                                        Setujui
                                    </button>
                                    <button wire:click="rejectPurchase({{ $purchase->id }})" wire:confirm="Tolak pembelian stok ini?"
                                        class="px-3 py-1.5 bg-rose-50 text-rose-700 rounded-lg text-xs font-bold hover:bg-rose-100 transition-all shadow-sm active:scale-95">
                                        Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-16 text-center text-sm font-medium text-zinc-500 italic">Tidak ada pengajuan pembelian yang perlu diproses.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($purchases->hasPages())
            <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50/50">{{ $purchases->links() }}</div>
        @endif
    </div>

    {{-- MODAL DETAIL NOTA REFACTOR --}}
    @if($showDetailModal && $selectedPurchase)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-zinc-900/60 transition-opacity backdrop-blur-sm" wire:click="closeDetailModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-zinc-200">
                    <div class="px-6 py-4 bg-zinc-50 border-b border-zinc-200 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-black text-zinc-900">Detail Dokumen Pengadaan</h3>
                            <p class="text-xs font-bold text-zinc-500 mt-0.5">PO: <span class="text-zinc-800">{{ $selectedPurchase->po_number }}</span></p>
                        </div>
                        <button type="button" wire:click="closeDetailModal" class="text-zinc-400 hover:text-zinc-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L12 12M12 12l12 12M12 12L6 6m6 6l6-6" /></svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-2 gap-4 text-xs bg-zinc-50 border border-zinc-200 p-4 rounded-xl">
                            <div><span class="text-zinc-500 block font-medium">Pemohon / Cabang:</span><span class="font-bold text-zinc-900">{{ $selectedPurchase->user->name ?? '-' }} ({{ $selectedPurchase->branch->name ?? '-' }})</span></div>
                            <div><span class="text-zinc-500 block font-medium">Supplier:</span><span class="font-bold text-zinc-900">{{ $selectedPurchase->supplier->name ?? '-' }}</span></div>
                            <div><span class="text-zinc-500 block font-medium">Tanggal Pengajuan:</span><span class="font-bold text-zinc-900">{{ \Carbon\Carbon::parse($selectedPurchase->purchase_date)->format('d F Y') }}</span></div>
                            <div><span class="text-zinc-500 block font-medium">Status Validasi:</span><span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-amber-100 text-amber-800 uppercase inline-block mt-0.5">{{ $selectedPurchase->status }}</span></div>
                        </div>

                        <div>
                            <h4 class="text-xs font-black text-zinc-800 uppercase tracking-wider mb-2">Rincian Produk</h4>
                            <div class="border border-zinc-200 rounded-xl overflow-hidden text-sm">
                                <table class="w-full text-left">
                                    <thead class="bg-zinc-100 text-[10px] font-bold text-zinc-600 uppercase">
                                        <tr>
                                            <th class="px-4 py-2.5">Produk</th>
                                            <th class="px-4 py-2.5 text-center">Qty</th>
                                            <th class="px-4 py-2.5 text-right">Harga Satuan</th>
                                            <th class="px-4 py-2.5 text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-100">
                                        @foreach($selectedPurchase->details as $item)
                                            <tr>
                                                <td class="px-4 py-3 font-bold text-zinc-800">{{ $item->product->name ?? 'Unknown' }}</td>
                                                <td class="px-4 py-3 text-center font-bold">{{ number_format($item->quantity_ordered, 0, ',', '.') }}</td>
                                                <td class="px-4 py-3 text-right font-medium">Rp {{ number_format($item->price_per_item, 0, ',', '.') }}</td>
                                                <td class="px-4 py-3 text-right font-black text-zinc-900">Rp {{ number_format($item->quantity_ordered * $item->price_per_item, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-zinc-50 font-bold border-t border-zinc-200">
                                            <td colspan="3" class="px-4 py-3 text-right uppercase text-xs text-zinc-500">Total Akumulasi:</td>
                                            <td class="px-4 py-3 text-right text-emerald-600 font-black text-base">Rp {{ number_format($selectedPurchase->total_price, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-zinc-50 border-t border-zinc-200 flex justify-end gap-2">
                        <button type="button" wire:click="closeDetailModal" class="px-4 py-2 bg-white border border-zinc-200 text-zinc-700 rounded-xl text-xs font-bold hover:bg-zinc-100 transition shadow-sm">Tutup</button>
                        <button type="button" wire:click="rejectPurchase({{ $selectedPurchase->id }})" class="px-4 py-2 bg-rose-50 text-rose-700 rounded-xl text-xs font-bold hover:bg-rose-100 transition shadow-sm">Tolak PO</button>
                        <button type="button" wire:click="approvePurchase({{ $selectedPurchase->id }})" class="px-4 py-2 bg-zinc-900 text-white rounded-xl text-xs font-bold hover:bg-zinc-800 transition shadow-sm">Setujui & ACC Dokumen</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>