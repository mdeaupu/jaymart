<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="mb-8 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Pantau performa seluruh cabang secara
                    real-time.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500 transition-colors">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Total
                    Pendapatan Hari Ini</div>
                <div class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                    Rp {{ number_format($income['daily'], 0, ',', '.') }}
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500 transition-colors">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Minggu Ini
                </div>
                <div class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                    Rp {{ number_format($income['weekly'], 0, ',', '.') }}
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500 transition-colors">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Bulan Ini
                </div>
                <div class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                    Rp {{ number_format($income['monthly'], 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700"
                x-data="{
                    init() {
                        const isDark = document.documentElement.classList.contains('dark');
                        new Chart($refs.canvas, {
                            type: 'bar',
                            data: {
                                labels: {{ json_encode($chartData->pluck('name')) }},
                                datasets: [{
                                    label: 'Total Penjualan (Rp)',
                                    data: {{ json_encode($chartData->pluck('total_sales')) }},
                                    backgroundColor: isDark ? '#818cf8' : '#6366f1',
                                    borderRadius: 6
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { 
                                    legend: { display: false } 
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: { color: isDark ? '#374151' : '#f3f4f6' },
                                        ticks: { color: isDark ? '#9ca3af' : '#6b7280' }
                                    },
                                    x: {
                                        grid: { display: false },
                                        ticks: { color: isDark ? '#9ca3af' : '#6b7280' }
                                    }
                                }
                            }
                        })
                    }
                 }">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Performa Penjualan Cabang</h3>
                <div class="relative h-64">
                    <canvas x-ref="canvas"></canvas>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-red-600 dark:text-red-400 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Peringatan Stok Kritis
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <th
                                    class="px-2 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                    Produk</th>
                                <th
                                    class="px-2 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest text-center">
                                    Cabang</th>
                                <th
                                    class="px-2 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest text-right">
                                    Sisa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($criticalStocks as $stock)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-2 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $stock->product->name }}
                                        </div>
                                    </td>
                                    <td class="px-2 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                            {{ $stock->branch->name }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-4 text-right">
                                        <span class="text-sm font-bold text-red-600 dark:text-red-400">
                                            {{ $stock->quantity }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="px-2 py-8 text-sm text-center text-gray-500 dark:text-gray-400 italic">
                                        Tidak ada stok di bawah ambang batas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>