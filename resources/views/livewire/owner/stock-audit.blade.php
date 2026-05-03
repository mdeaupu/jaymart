<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Audit Log') }}
    </h2>
</x-slot>

<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="h-11 flex items-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Riwayat lengkap keluar masuk barang untuk mencegah manipulasi.
            </p>
        </div>
    </div>
    <!-- Audit Log Table Card -->
    <x-card class="overflow-hidden">
        <div class="overflow-x-auto">
            <x-table class="w-full">
                <x-slot name="header">
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Waktu</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        User</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Produk / Cabang</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Jumlah</th>
                    <th
                        class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Alasan</th>
                    <th
                        class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-400 bg-gray-300 dark:bg-gray-700">
                        Tipe</th>
                </x-slot>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($logs as $log)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-800 dark:text-gray-100 font-medium">
                                    {{ $log->created_at->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                                    {{ $log->created_at->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800 dark:text-gray-100">
                                {{ $log->user->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-800 dark:text-gray-100">
                                    {{ $log->product->name }}
                                </div>
                                <div class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold mt-0.5">
                                    {{ $log->branch->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                    {{ number_format($log->amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 italic max-w-xs truncate">
                                "{{ $log->reason ?? '-' }}"
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $colorMap = ['in' => 'green', 'out' => 'red', 'adjustment' => 'blue'];
                                @endphp
                                <x-badge :color="$colorMap[$log->type] ?? 'gray'"
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-tighter capitalize transition-all duration-200">
                                    {{ str($log->type) }}
                                </x-badge>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-table>
        </div>
        <!-- Pagination Section -->
        @if($logs->hasPages())
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                {{ $logs->links() }}
            </div>
        @endif
    </x-card>
</div>