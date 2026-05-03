<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Stock Approval') }}
    </h2>
</x-slot>

<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Alerts Section -->
    <x-alert type="error" :message="session('error')" />
    <x-alert type="success" :message="session('message')" />
    <!-- Header Section -->
    <div class="mb-8">
        <div class="h-11 flex items-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Tinjau dan setujui pengajuan pengadaan barang dari supplier yang diajukan oleh Manager.
            </p>
        </div>
    </div>
    <!-- Purchase Approval Table Card -->
    <x-card class="overflow-hidden">
        <div class="overflow-x-auto">
            <x-table class="w-full">
                <x-slot name="header">
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Tanggal</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Produk & Cabang</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Supplier</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Jumlah</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Total Harga</th>
                    <th
                        class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Aksi</th>
                </x-slot>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($purchases as $purchase)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-800 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500 italic font-mono mt-0.5">
                                    Inv: {{ $purchase->invoice_number ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-800 dark:text-gray-100">
                                    {{ $purchase->product->name }}</div>
                                <div class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold mt-0.5">
                                    {{ $purchase->branch->name ?? 'Pusat' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                {{ $purchase->supplier->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge color="green">+{{ $purchase->quantity }}</x-badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-800 dark:text-gray-100">
                                    Rp {{ number_format($purchase->total_price, 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button wire:click="approvePurchase({{ $purchase->id }})"
                                        wire:confirm="Setujui pembelian stok ini?"
                                        class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-bold hover:bg-indigo-100 hover:text-indigo-800 transition-all shadow-sm active:scale-95">
                                        Setujui
                                    </button>
                                    <button wire:click="rejectPurchase({{ $purchase->id }})"
                                        wire:confirm="Tolak pembelian stok ini?"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-bold hover:bg-red-100 hover:text-red-800 transition-all shadow-sm active:scale-95">
                                        Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-sm text-gray-500 italic">
                                Tidak ada pengajuan pembelian yang perlu diproses.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-table>
        </div>
        <!-- Pagination Section -->
        @if($purchases->hasPages())
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                {{ $purchases->links() }}
            </div>
        @endif
    </x-card>
</div>