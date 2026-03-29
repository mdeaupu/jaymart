<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Audit Log') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center">
                <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Audit Log Mutasi Barang</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Riwayat lengkap keluar masuk barang untuk mencegah manipulasi.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/50 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700">
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Produk / Cabang</th>
                            <th class="px-6 py-4 text-center">Tipe</th>
                            <th class="px-6 py-4 text-center">Jumlah</th>
                            <th class="px-6 py-4">Alasan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($logs as $log)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $log->created_at->format('d/m/Y') }}<br>
                                    <span class="text-xs opacity-75">{{ $log->created_at->format('H:i') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $log->user->name ?? 'System' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $log->product->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->branch->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $typeStyles = [
                                            'in' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                            'out' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                            'adjustment' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300'
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-bold rounded-md {{ $typeStyles[$log->type] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ strtoupper($log->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-gray-900 dark:text-white">
                                    {{ $log->amount }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 italic font-serif">
                                    "{{ $log->reason ?? '-' }}"
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-gray-100 dark:border-gray-700">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>