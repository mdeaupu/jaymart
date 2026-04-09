<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Warehouse Overview</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                <div class="text-sm font-medium text-gray-500">Total Jenis Barang</div>
                <div class="text-2xl font-bold text-gray-900">{{ $stats['total_items'] }}</div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-red-500">
                <div class="text-sm font-medium text-gray-500">Stok Menipis</div>
                <div class="text-2xl font-bold text-red-600">{{ $stats['low_stock_count'] }}</div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                <div class="text-sm font-medium text-gray-500">Barang Masuk (Hari Ini)</div>
                <div class="text-2xl font-bold text-green-600">+{{ $stats['incoming_today'] }}</div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-amber-500">
                <div class="text-sm font-medium text-gray-500">Menunggu Approval Opname</div>
                <div class="text-2xl font-bold text-amber-600">{{ $stats['pending_adjustments'] }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-700">Log Aktivitas Gudang Terbaru</h3>
                        <a href="#" class="text-xs text-blue-600 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="p-6">
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                @foreach($recentActivities as $log)
                                    <li>
                                        <div class="relative pb-8">
                                            @if (!$loop->last)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                                    aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span
                                                        class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white 
                                                        {{ $log->type == 'in' ? 'bg-green-500' : ($log->type == 'out' ? 'bg-blue-500' : 'bg-red-500') }}">
                                                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            @if($log->type == 'in')
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="Build-In" />
                                                            @else
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /> @endif
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="flex min-w-0 flex-one justify-between space-x-4 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-gray-500">
                                                            <span
                                                                class="font-medium text-gray-900">{{ $log->product->name }}</span>
                                                            ({{ $log->amount }} unit)
                                                            <span class="capitalize">[{{ $log->type }}]</span>
                                                        </p>
                                                        <p class="text-xs text-gray-400 italic">{{ $log->reason }}</p>
                                                    </div>
                                                    <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                        <time>{{ $log->created_at->diffForHumans() }}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-red-100">
                    <div class="px-6 py-4 bg-red-50 border-b border-red-100">
                        <h3 class="font-bold text-red-700 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            Peringatan Stok Kritis
                        </h3>
                    </div>
                    <div class="p-4">
                        @forelse($lowStockItems as $stock)
                            <div
                                class="flex items-center justify-between p-3 mb-2 bg-gray-50 rounded border border-gray-100">
                                <div>
                                    <div class="text-sm font-bold text-gray-800">{{ $stock->product->name }}</div>
                                    <div class="text-xs text-gray-500">Threshold: {{ $stock->low_stock_threshold }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-black text-red-600">{{ $stock->quantity }}</div>
                                    <div class="text-[10px] text-gray-400 uppercase">Sisa Unit</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">Semua stok aman.</p>
                        @endforelse

                        @if($lowStockItems->count() > 0)
                            <div class="mt-4">
                                <a href="{{ route('warehouse.incoming') }}"
                                    class="block text-center px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded hover:bg-blue-700 transition">
                                    RESTOCK SEKARANG
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>