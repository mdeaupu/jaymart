<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Audit Log') }}</h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <div class="mb-2 py-2">
        <div class="h-11 items-center flex justify-between">
            <p class="text-sm text-gray-600 dark:text-gray-400">Riwayat lengkap keluar masuk barang untuk mencegah
                manipulasi.</p>
        </div>
    </div>

    <x-card>
        <div class="p-6">
            <x-table>
                <x-slot name="header">
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400">Waktu</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400">User</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400 ">Produk / Cabang</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400 ">Jumlah</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400 ">Alasan</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-400 text-center">Tipe</th>
                </x-slot>

                @foreach($logs as $log)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="gap-2 items-center flex px-6 py-4 text-sm text-gray-800 dark:text-gray-100">
                            {{ $log->created_at->format('d/m/Y') }}<br><span
                                class="text-xs opacity-75">{{ $log->created_at->format('H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-800 dark:text-gray-100">
                            {{ $log->user->name ?? 'System' }}
                        </td>
                        <td class="px-6 py-4 gap-2 items-center flex">
                            <div class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $log->product->name }}
                            </div>
                            <div class="text-xs text-gray-400">{{ $log->branch->name }}</div>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-800 dark:text-gray-100">{{ $log->amount }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-400 italic">"{{ $log->reason ?? '-' }}"
                        <td class="px-6 py-4 text-center">
                            @php
                                $colorMap = ['in' => 'green', 'out' => 'red', 'adjustment' => 'blue'];
                            @endphp
                            <x-badge :color="$colorMap[$log->type] ?? 'gray'"
                                class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-semibold transition-colors duration-200 cursor-default capitalize">{{ str($log->type) }}</x-badge>
                        </td>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">{{ $logs->links() }}</div>
    </x-card>
</div>