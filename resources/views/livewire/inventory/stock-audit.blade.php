<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Audit Log') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">

            <!-- HEADER -->
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center">
                <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Audit Log Mutasi Barang</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Riwayat lengkap + status approval untuk mencegah manipulasi.
                    </p>
                </div>
            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/50 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase border-b">
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Produk / Cabang</th>
                            <th class="px-6 py-4 text-center">Tipe</th>
                            <th class="px-6 py-4 text-center">Jumlah</th>
                            <th class="px-6 py-4 text-center">Status</th> <!-- NEW -->
                            <th class="px-6 py-4">Alasan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($logs as $log)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">

                                <!-- WAKTU -->
                                <td class="px-6 py-4 text-sm">
                                    {{ $log->created_at->format('d/m/Y') }}<br>
                                    <span class="text-xs opacity-70">{{ $log->created_at->format('H:i') }}</span>
                                </td>

                                <!-- USER -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold">
                                        {{ $log->user->name ?? 'System' }}
                                    </div>
                                </td>

                                <!-- PRODUK -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium">
                                        {{ $log->product->name }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $log->branch->name }}
                                    </div>
                                </td>

                                <!-- TIPE -->
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $typeStyles = [
                                            'in' => 'bg-green-100 text-green-800',
                                            'out' => 'bg-red-100 text-red-800',
                                            'adjustment' => 'bg-blue-100 text-blue-800'
                                        ];
                                    @endphp

                                    <span class="px-2 py-1 text-xs font-bold rounded-md {{ $typeStyles[$log->type] ?? 'bg-gray-100' }}">
                                        {{ strtoupper($log->type) }}
                                    </span>
                                </td>

                                <!-- JUMLAH -->
                                <td class="px-6 py-4 text-center font-bold">
                                    {{ $log->amount }}
                                </td>

                                <!-- STATUS APPROVAL (NEW) -->
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusStyles = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp

                                    <span class="px-2 py-1 text-xs font-bold rounded-md {{ $statusStyles[$log->status] ?? 'bg-gray-100' }}">
                                        {{ strtoupper($log->status ?? 'approved') }}
                                    </span>
                                </td>

                                <!-- ALASAN -->
                                <td class="px-6 py-4 text-sm italic">
                                    "{{ $log->reason ?? '-' }}"
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="p-6 border-t">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>