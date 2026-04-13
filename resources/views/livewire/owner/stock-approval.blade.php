<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Persetujuan Pembelian Stok') }}
    </h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <x-alert type="error" :message="session('error')" />
    <x-alert type="success" :message="session('message')" />

    <div class="mb-2 py-2">
        <div class="h-11 items-center flex justify-between">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Tinjau dan setujui pengajuan pengadaan barang dari supplier yang diajukan oleh Manager.
            </p>
        </div>
    </div>

    <x-card>
        <div class="p-6 overflow-x-auto">
            <x-table>
                <x-slot name="header">
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-400">Tanggal</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-400">Produk & Cabang</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-400">Supplier</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-400">Jumlah</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-400">Total Harga</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-400">Aksi</th>
                </x-slot>

                @forelse($purchases as $purchase)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-800 dark:text-gray-100">
                                {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}
                            </div>
                            <div class="text-xs text-gray-500 italic">Inv: {{ $purchase->invoice_number ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-800 dark:text-gray-100">{{ $purchase->product->name }}
                            </div>
                            <div class="text-xs text-gray-500">{{ $purchase->branch->name ?? 'Pusat' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-400">
                            {{ $purchase->supplier->name }}
                        </td>
                        <td class="px-6 py-4">
                            <x-badge color="green">+{{ $purchase->quantity }}</x-badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-800 dark:text-gray-100">
                                Rp {{ number_format($purchase->total_price, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <button wire:click="approvePurchase({{ $purchase->id }})"
                                    wire:confirm="Setujui pembelian stok ini?"
                                    class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-semibold hover:bg-indigo-100 transition-colors">
                                    Setujui
                                </button>
                                <button wire:click="rejectPurchase({{ $purchase->id }})"
                                    wire:confirm="Tolak pembelian stok ini?"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-sm font-semibold hover:bg-red-100 transition-colors">
                                    Tolak
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-2 py-10 text-center text-sm text-gray-400 italic">
                            Tidak ada pengajuan pembelian yang perlu diproses.
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $purchases->links() }}
        </div>
    </x-card>
</div>