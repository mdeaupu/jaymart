<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
        {{ __('Riwayat Pengadaan Barang') }}
    </h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <div class="mb-2 py-2">
        <div class="h-11 flex items-center justify-between">
            <p class="text-sm text-gray-800 dark:text-gray-400">Pantau status persetujuan pengadaan barang dari supplier secara real-time.</p>
        </div>
    </div>

    <x-card>
        <div class="p-6">
            <x-table>
                <x-slot name="header">
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-left">Produk & Supplier</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Jumlah</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-left">Total Biaya</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-left">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                </x-slot>

                @forelse($purchases as $p)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200">
                        <td class="px-6 py-5">
                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $p->product->name }}</div>
                            <div class="text-xs text-gray-500 font-medium italic">{{ $p->supplier->name }}</div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                                +{{ $p->quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-sm font-bold text-gray-900 dark:text-white">
                                Rp {{ number_format($p->total_price, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                                {{ \Carbon\Carbon::parse($p->purchase_date)->format('d/m/Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                                    'approved' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
                                    'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                ];
                                $label = [
                                    'pending' => 'Menunggu',
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak',
                                ];
                            @endphp
                            <span class="inline-flex px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-widest {{ $statusColors[$p->status] }}">
                                {{ $label[$p->status] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">
                            Belum ada riwayat pengadaan barang.
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>
        @if($purchases->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $purchases->links() }}
            </div>
        @endif
    </x-card>
</div>