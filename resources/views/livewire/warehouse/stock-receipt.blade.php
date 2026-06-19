<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-blue-100 text-blue-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Sistem
                    Penerimaan</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Verifikasi Muatan (PO)</h1>
            <p class="text-sm text-zinc-500 mt-1">Lakukan cek fisik barang yang tiba dari armada supplier.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div
            class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-sm text-emerald-700 font-medium shadow-sm flex items-center gap-2">
            ✨ {{ session('message') }}
        </div>
    @endif

    @if(!$selected_purchase)
        <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-zinc-100 bg-zinc-900 text-white">
                <h2 class="font-extrabold text-sm uppercase tracking-wider">Daftar PO Menunggu Bongkar</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                        <tr>
                            <th class="px-6 py-4">No. PO & Tanggal</th>
                            <th class="px-6 py-4">Tujuan Cabang</th>
                            <th class="px-6 py-4">Supplier</th>
                            <th class="px-6 py-4">Total Item</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @forelse ($incomingPurchases as $purchase)
                            <tr class="hover:bg-zinc-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-black text-zinc-900 font-mono">{{ $purchase->po_number }}</div>
                                    <div class="text-[10px] text-zinc-500 font-bold uppercase tracking-wider mt-1">
                                        {{ $purchase->purchase_date->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider rounded-md bg-indigo-50 text-indigo-700">
                                        {{ $purchase->branch->name ?? 'Cabang Utama' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-zinc-700">
                                    {{ $purchase->supplier->name }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900">
                                    {{ $purchase->details->count() }} Jenis Produk
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button wire:click="startVerification({{ $purchase->id }})"
                                        class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                                        Buka Cek Fisik
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-zinc-400 font-medium">
                                    🚚 Belum ada pengiriman barang masuk yang disetujui Owner saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($incomingPurchases->hasPages())
                <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50">
                    {{ $incomingPurchases->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <button type="button" wire:click="cancelVerification"
                    class="text-xs font-bold text-zinc-500 hover:text-zinc-800 transition flex items-center mb-2 uppercase tracking-wider">
                    ← Kembali ke Daftar PO
                </button>
                <h3 class="text-2xl font-black text-zinc-900 tracking-tight">
                    Verifikasi PO: <span class="font-mono text-purple-600">{{ $selected_purchase->po_number }}</span>
                </h3>
            </div>
            <div
                class="text-right text-xs text-zinc-600 bg-white p-4 rounded-2xl border border-zinc-200 shadow-sm flex flex-col gap-1">
                <div>Supplier: <strong class="text-zinc-900 font-black">{{ $selected_purchase->supplier->name }}</strong>
                </div>
                <div>Tujuan: <strong
                        class="text-purple-600 font-black">{{ $selected_purchase->branch->name ?? 'Cabang Utama' }}</strong>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="saveReceipt">
            <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm p-6">
                <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-sm font-medium">
                    ⚠️ <strong class="font-black">Instruksi Lapangan:</strong> Hitung kuantitas fisik secara teliti. Jika
                    ada barang cacat/kurang, sesuaikan input kolom <strong>"Jumlah Diterima Nyata"</strong> sesuai barang
                    bagus yang siap dijual.
                </div>

                <div class="space-y-4">
                    @foreach($selected_purchase->details as $detail)
                        <div
                            class="grid grid-cols-1 md:grid-cols-12 gap-4 p-5 bg-zinc-50 rounded-xl items-center border border-zinc-100">

                            <div class="md:col-span-5">
                                <div class="text-sm font-bold text-zinc-900">
                                    {{ $detail->product->name ?? 'Produk Tidak Diketahui' }}
                                </div>
                                @if($detail->expired_at)
                                    <div class="text-[10px] text-rose-500 mt-1 font-bold uppercase tracking-wider">
                                        Exp Date: {{ $detail->expired_at->format('d M Y') }}
                                    </div>
                                @endif
                            </div>

                            <div class="md:col-span-3">
                                <span class="block text-[10px] text-zinc-400 uppercase font-bold tracking-wider mb-0.5">Rencana
                                    di Berkas PO</span>
                                <span class="text-lg font-black text-zinc-800">
                                    {{ $detail->quantity_ordered }} <span class="text-xs font-bold text-zinc-500">pcs</span>
                                </span>
                            </div>

                            <div class="md:col-span-4">
                                <label class="block text-[10px] font-bold text-purple-600 uppercase tracking-wider mb-1.5">
                                    Jumlah Diterima Nyata
                                </label>
                                <div class="relative">
                                    <input type="number" wire:model="received_items.{{ $detail->id }}" min="0"
                                        class="w-full px-4 py-2.5 bg-white border border-zinc-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition text-sm font-black">
                                    <div
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-xs font-bold text-zinc-400">
                                        pcs
                                    </div>
                                </div>
                                @error("received_items." . $detail->id)
                                    <span class="text-rose-500 text-xs mt-1.5 block font-bold">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-zinc-100">
                    <button type="button" wire:click="cancelVerification"
                        class="px-5 py-3 bg-white border border-zinc-300 text-zinc-700 rounded-xl text-sm font-bold hover:bg-zinc-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        wire:confirm="Apakah Anda yakin hitungan fisik sudah sesuai? Menyimpan data ini akan langsung menambah nilai stok barang di sistem."
                        class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-sm transition active:scale-[0.98]">
                        Selesaikan Verifikasi & Masuk Stok
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>