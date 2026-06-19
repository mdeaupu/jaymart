<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-black text-zinc-900 tracking-tight">Mesin Kasir (POS)</h1>
            <p class="text-xs text-zinc-500 mt-1">Pilih produk dan layani pelanggan.</p>
        </div>
        <input type="text" wire:model.live="search" placeholder="🔍 Cari produk..."
            class="w-full sm:w-64 px-4 py-2.5 bg-white border border-zinc-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition">
    </div>

    @if(session()->has('error'))
        <div
            class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl text-sm text-rose-700 font-medium shadow-sm flex items-center gap-2">
            ❌ {{ session('error') }}
        </div>
    @endif
    @if(session()->has('success'))
        <div
            class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-sm text-emerald-700 font-medium shadow-sm flex items-center gap-2">
            ✨ {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6 items-start">

        <div class="flex-1 w-full bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-zinc-100 bg-zinc-900 text-white">
                <h2 class="font-extrabold text-sm uppercase tracking-wider">Daftar Produk</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                        <tr>
                            <th class="px-5 py-3">Nama Produk</th>
                            <th class="px-5 py-3">Harga Jual</th>
                            <th class="px-5 py-3 text-center">Stok</th>
                            <th class="px-5 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach($products as $p)
                            <tr class="hover:bg-zinc-50 transition-colors">
                                <td class="px-5 py-3 font-bold text-zinc-800">{{ $p->name }}</td>
                                <td class="px-5 py-3 font-medium text-emerald-600">Rp
                                    {{ number_format($p->sell_price, 0, ',', '.') }}</td>
                                <td class="px-5 py-3 text-center">
                                    <span
                                        class="px-2.5 py-1 {{ ($p->stock->quantity ?? 0) > 5 ? 'bg-zinc-100 text-zinc-600' : 'bg-rose-100 text-rose-700' }} rounded-md text-[10px] font-black uppercase">
                                        {{ $p->stock->quantity ?? 0 }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-center">
                                    <button wire:click="addToCart({{ $p->id }})"
                                        class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 shadow-sm transition">
                                        + Keranjang
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w-full lg:w-[400px] flex flex-col gap-6">

            <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden flex flex-col">
                <div class="px-5 py-4 border-b border-zinc-100 bg-zinc-50 flex justify-between items-center">
                    <h3 class="font-black text-zinc-800 text-sm uppercase tracking-wider">🛒 Keranjang</h3>
                    <span
                        class="px-2 py-1 bg-blue-100 text-blue-800 text-[10px] font-black rounded-full">{{ count($cart) }}
                        Item</span>
                </div>

                <div class="p-5 flex-1 divide-y divide-zinc-100 max-h-[400px] overflow-y-auto">
                    @forelse($cart as $item)
                        <div class="py-3 first:pt-0 last:pb-0">
                            <div class="font-bold text-sm text-zinc-900">{{ $item['name'] }}</div>
                            <div class="text-xs text-zinc-500 font-medium mt-0.5">Rp
                                {{ number_format($item['price'], 0, ',', '.') }}</div>

                            <div class="flex items-center justify-between mt-2">
                                <div class="flex items-center gap-2 bg-zinc-100 p-1 rounded-lg border border-zinc-200">
                                    <button wire:click="decreaseQty({{ $item['id'] }})"
                                        class="w-7 h-7 bg-white text-zinc-700 border border-zinc-200 rounded-md font-bold hover:bg-rose-50 hover:text-rose-600 transition">-</button>
                                    <span class="w-6 text-center text-xs font-black text-zinc-800">{{ $item['qty'] }}</span>
                                    <button wire:click="increaseQty({{ $item['id'] }})"
                                        class="w-7 h-7 bg-white text-zinc-700 border border-zinc-200 rounded-md font-bold hover:bg-blue-50 hover:text-blue-600 transition">+</button>
                                </div>
                                <div class="font-black text-sm text-emerald-600">
                                    Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-zinc-400 text-xs font-medium">
                            🛒 Keranjang belanja Anda masih kosong
                        </div>
                    @endforelse
                </div>

                <div class="p-5 bg-zinc-50 border-t border-zinc-100">
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-bold text-sm text-zinc-600 uppercase tracking-wider">Total</span>
                        <span class="font-black text-2xl text-zinc-900 tracking-tight">Rp
                            {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <button wire:click="checkout" @if(empty($cart)) disabled @endif
                        class="w-full py-3.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 shadow-sm transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Bayar Sekarang
                    </button>
                </div>
            </div>

            @if($lastTransaction)
                <div class="bg-amber-50 rounded-2xl border border-amber-200 shadow-sm p-5">
                    <h4 class="font-black text-amber-800 text-xs uppercase tracking-wider flex items-center gap-2 mb-3">
                        🧾 Struk Terakhir: <span
                            class="bg-amber-200 text-amber-900 px-2 py-0.5 rounded">{{ $lastTransaction->invoice_number }}</span>
                    </h4>
                    <div
                        class="bg-white rounded-xl border border-amber-100 p-3 max-h-[220px] overflow-y-auto divide-y divide-zinc-50 text-xs">
                        @foreach($lastTransaction->details as $det)
                            <div class="py-2 first:pt-0 last:pb-0 flex justify-between items-center gap-2">
                                <div>
                                    <strong class="text-zinc-800">{{ $det->product->name }}</strong><br>
                                    <span class="text-zinc-500 font-medium">{{ $det->qty }} Pcs x Rp
                                        {{ number_format($det->price_at_transaction, 0, ',', '.') }}</span>
                                </div>
                                <button wire:click="openCorrection({{ $det->id }})"
                                    class="px-2.5 py-1.5 bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 rounded-lg text-[10px] font-black uppercase tracking-wider transition whitespace-nowrap">
                                    Void Item
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    @if($showCorrectionModal)
        <div class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4">
            <div class="bg-white p-6 rounded-2xl w-full max-w-md shadow-2xl">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 text-xl">
                        ⚠️</div>
                    <div>
                        <h3 class="font-black text-zinc-900 text-lg tracking-tight">Otorisasi Pembatalan</h3>
                        <p class="text-xs text-zinc-500 font-medium">Pengajuan void item ke supervisor.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-zinc-600 uppercase tracking-wider mb-1.5">Kuantitas
                            Terjual</label>
                        <input type="text" value="{{ $wrong_qty }} Unit" disabled
                            class="w-full px-4 py-2.5 bg-zinc-100 border border-zinc-200 rounded-xl font-bold text-zinc-500 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-zinc-800 uppercase tracking-wider mb-1.5">Kuantitas Nyata
                            (Fisik)</label>
                        <input type="number" wire:model="correct_qty" min="0" placeholder="Contoh: 1"
                            class="w-full px-4 py-2.5 bg-white border border-zinc-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition text-sm">
                        @error('correct_qty') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-zinc-800 uppercase tracking-wider mb-1.5">Alasan
                            Void</label>
                        <textarea wire:model="reason" placeholder="Contoh: Batal beli, uang kurang..."
                            class="w-full px-4 py-2.5 bg-white border border-zinc-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition text-sm h-20 resize-none"></textarea>
                        @error('reason') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-zinc-100">
                    <button type="button" wire:click="$set('showCorrectionModal', false)"
                        class="px-4 py-2 bg-white border border-zinc-300 text-zinc-700 rounded-xl text-xs font-bold hover:bg-zinc-50 transition">
                        Batal
                    </button>
                    <button type="button" wire:click="submitCorrectionRequest"
                        class="px-4 py-2 bg-rose-600 text-white rounded-xl text-xs font-bold hover:bg-rose-700 shadow-sm transition">
                        Kirim Pengajuan
                    </button>
                </div>
            </div>
        </div>
    @endif

    <iframe id="receipt-printer-iframe" name="receipt-printer-iframe" wire:ignore class="hidden"></iframe>

    <script>
        // Logika cetak struk bawaan, tidak diubah fungsinya
        function handlePrintReceipt(event) {
            const data = event.detail ? event.detail[0] : (event[0] || event);
            if (!data || !data.url) return;

            const receiptUrl = data.url;
            const iframe = document.getElementById('receipt-printer-iframe');

            if (iframe) {
                iframe.onload = function () {
                    if (iframe.src && iframe.src.includes('receipt')) {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();
                        iframe.src = '';
                    }
                };
                iframe.src = receiptUrl;
            }
        }
        window.addEventListener('print-receipt', handlePrintReceipt);
        document.addEventListener('livewire:init', () => {
            Livewire.on('print-receipt', (event) => {
                const payload = Array.isArray(event) ? event[0] : event;
                handlePrintReceipt({ detail: [payload] });
            });
        });
    </script>
</div>