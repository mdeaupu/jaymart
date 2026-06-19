<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-indigo-100 text-indigo-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Procurement</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Riwayat Pengadaan Barang</h1>
            <p class="text-sm text-zinc-500 mt-1">Pantau perkembangan status pengadaan barang multi-item dari supplier
                secara real-time.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Nomor PO & Tanggal</th>
                        <th class="px-6 py-4">Supplier</th>
                        <th class="px-6 py-4">Daftar Item Barang (Ordered)</th>
                        <th class="px-6 py-4 text-right">Total Biaya</th>
                        <th class="px-6 py-4 text-center">Status Dokumen</th>
                        <th class="px-6 py-4 text-center">Nota Supplier</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($purchases as $purchase)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-black text-zinc-900 font-mono">{{ $purchase->po_number }}</div>
                                <div class="text-[10px] font-bold text-zinc-400 mt-0.5 uppercase tracking-wider">
                                    {{ $purchase->purchase_date->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-black text-zinc-800">{{ $purchase->supplier->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="max-w-xs bg-zinc-50 border border-zinc-200 p-2.5 rounded-xl space-y-1.5">
                                    @foreach($purchase->details as $detail)
                                        <div
                                            class="text-[11px] font-medium text-zinc-700 flex justify-between items-center border-b border-zinc-100 last:border-0 pb-1 last:pb-0">
                                            <span>• {{ $detail->product->name ?? 'Produk Terhapus' }}</span>
                                            <span
                                                class="font-black text-zinc-900 bg-white px-1.5 py-0.5 rounded shadow-sm">{{ $detail->quantity_ordered }}
                                                pcs</span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-black text-zinc-900">
                                Rp {{ number_format($purchase->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($purchase->status === 'pending')
                                    <span
                                        class="px-2.5 py-1 text-[10px] font-black rounded-md uppercase tracking-wider bg-amber-100 text-amber-800">Menunggu
                                        Owner</span>
                                @elseif($purchase->status === 'approved')
                                    <span
                                        class="px-2.5 py-1 text-[10px] font-black rounded-md uppercase tracking-wider bg-purple-100 text-purple-800">Disetujui
                                        Owner</span>
                                @elseif($purchase->status === 'received')
                                    <span
                                        class="px-2.5 py-1 text-[10px] font-black rounded-md uppercase tracking-wider bg-emerald-100 text-emerald-800">Diterima
                                        Gudang</span>
                                @else
                                    <span
                                        class="px-2.5 py-1 text-[10px] font-black rounded-md uppercase tracking-wider bg-rose-100 text-rose-800">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($purchase->invoice_file)
                                    <button type="button"
                                        onclick="showInvoiceModal('{{ $purchase->invoice_url }}', '{{ $purchase->po_number }}')"
                                        class="text-[10px] font-black uppercase tracking-wider text-purple-600 hover:text-purple-800 bg-purple-50 hover:bg-purple-100 px-3 py-1.5 rounded-lg transition-colors">
                                        👁️ Lihat Nota
                                    </button>
                                @else
                                    <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">Tidak Ada
                                        Nota</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-zinc-400 font-medium italic">Belum ada
                                riwayat pengadaan barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($purchases->hasPages())
            <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50/50">
                {{ $purchases->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL NATIVE JS UNTUK NOTA (DISERAGAMKAN DENGAN TEMA) --}}
    <div id="invoiceModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-zinc-900/60 backdrop-blur-sm" onclick="closeInvoiceModal()">
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-zinc-200">
                <div class="px-6 py-4 bg-zinc-50 border-b border-zinc-200 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-black text-zinc-900">Nota Fisik Pengadaan</h3>
                        <p class="text-xs font-bold text-zinc-500 mt-0.5">PO: <span id="invoicePoNumber"
                                class="text-zinc-800 font-mono"></span></p>
                    </div>
                    <button type="button" onclick="closeInvoiceModal()"
                        class="text-zinc-400 hover:text-zinc-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L12 12M12 12l12 12M12 12L6 6m6 6l6-6" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 bg-white">
                    <div class="flex justify-center bg-zinc-50 rounded-xl border border-zinc-200 p-2">
                        <img id="invoiceImage" src="" alt="Invoice" class="max-h-[60vh] object-contain rounded-lg">
                    </div>
                </div>
                <div class="px-6 py-4 bg-zinc-50 border-t border-zinc-200 flex justify-end">
                    <button type="button" onclick="closeInvoiceModal()"
                        class="px-4 py-2.5 bg-white border border-zinc-200 text-zinc-700 rounded-xl text-xs font-bold hover:bg-zinc-100 transition shadow-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showInvoiceModal(imageUrl, poNumber) {
            document.getElementById('invoiceImage').src = imageUrl;
            document.getElementById('invoicePoNumber').innerText = poNumber;
            document.getElementById('invoiceModal').classList.remove('hidden');
        }
        function closeInvoiceModal() {
            document.getElementById('invoiceModal').classList.add('hidden');
        }
    </script>
</div>