<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card title="Total Jenis Barang" colorClass="border-indigo-500">
            {{ $stats['total_items'] }}
        </x-stat-card>

        <x-stat-card title="Stok Menipis" colorClass="border-red-500">
            <span class="text-red-600 dark:text-red-400">{{ $stats['low_stock_count'] }}</span>
        </x-stat-card>

        <x-stat-card title="Barang Masuk (Hari Ini)" colorClass="border-green-500">
            <span class="text-green-600 dark:text-green-400">+{{ $stats['incoming_today'] }}</span>
        </x-stat-card>

        <x-stat-card title="Menunggu Approval" colorClass="border-yellow-500">
            <span class="text-amber-600 dark:text-amber-400">{{ $stats['pending_adjustments'] }}</span>
        </x-stat-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
        <div class="lg:col-span-2">
            <x-card class="p-6 h-full flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-400">Log Aktivitas Gudang Terbaru</h3>
                    <a href="#" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Semua</a>
                </div>

                <div class="flow-root flex-1">
                    <ul role="list" class="-mb-8">
                        @foreach($recentActivities as $log)
                            <li>
                                <div class="relative pb-8">
                                    @if (!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700"
                                            aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span
                                                class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-gray-800 
                                                {{ $log->type == 'in' ? 'bg-green-500' : ($log->type == 'out' ? 'bg-indigo-500' : 'bg-red-500') }}">
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    @if($log->type == 'in')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 4v16m8-8H4" />
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                                    @endif
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    <span
                                                        class="font-bold text-gray-900 dark:text-gray-100">{{ $log->product->name }}</span>
                                                    ({{ $log->amount }} unit)
                                                    <x-badge color="gray"
                                                        class="ml-1 uppercase text-[10px]">{{ $log->type }}</x-badge>
                                                </p>
                                                <p class="text-xs text-gray-500 italic mt-1">{{ $log->reason }}</p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-xs text-gray-500">
                                                <time>{{ $log->created_at->diffForHumans() }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </x-card>
        </div>

        <div class="lg:col-span-1">
            <x-card class="p-6 border border-red-500 h-full flex flex-col">
                <h3 class="text-lg font-bold text-red-600 dark:text-red-400 flex items-center mb-6">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    Stok Kritis
                </h3>

                <div class="space-y-4 flex-1">
                    @forelse($lowStockItems as $stock)
                        <div
                            class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700">
                            <div>
                                <div class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $stock->product->name }}
                                </div>
                                <div class="text-[10px] text-gray-500 uppercase tracking-wider">Batas:
                                    {{ $stock->low_stock_threshold }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-black text-red-600 dark:text-red-400">{{ $stock->quantity }}</div>
                                <div class="text-[10px] text-gray-400 uppercase">Sisa</div>
                            </div>
                        </div>
                    @empty
                        <div class="flex-1 flex items-center justify-center py-8">
                            <p class="text-sm text-gray-500 italic">Semua stok aman.</p>
                        </div>
                    @endforelse
                </div>

                @if($lowStockItems->count() > 0)
                    <div class="mt-6">
                        <a href="{{ route('warehouse.incoming') }}"
                            class="flex justify-center items-center w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-md shadow-sm transition-all duration-200 uppercase tracking-widest">
                            Restock Sekarang
                        </a>
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</div>