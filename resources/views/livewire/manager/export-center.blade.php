<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">{{ __('Export Center') }}</h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <div class="mb-2 py-2">
        <div class="h-11 flex items-center">
            <div class="mx-auto">
                <p class="text-sm text-gray-800 dark:text-gray-400">Unduh laporan performa bulanan dalam format yang
                    diinginkan secara real-time.</p>
            </div>
        </div>
    </div>

    <x-card class="max-w-4xl mx-auto p-10">
        <div class="text-center">
            <div class="max-w-xs mx-auto mb-10">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Pilih Bulan Laporan</label>
                <input type="month" wire:model="month"
                    class="[&::-webkit-calendar-picker-indicator]:dark:invert w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <button wire:click="exportExcel"
                    class="group p-8 border-2 border-green-500/30 rounded-2xl hover:bg-green-600 transition-all duration-200 text-center shadow-sm active:scale-95">
                    <div class="text-green-600 dark:text-green-400 group-hover:text-white font-bold text-xl mb-1">
                        Export Excel (.xlsx)
                    </div>
                    <p class="text-xs text-gray-500 group-hover:text-green-50/80">Cocok untuk olah data transaksi besar
                    </p>
                </button>

                <button wire:click="exportPdf"
                    class="group p-8 border-2 border-red-500/30 rounded-2xl hover:bg-red-600 transition-all duration-200 text-center shadow-sm active:scale-95">
                    <div class="text-red-600 dark:text-red-400 group-hover:text-white font-bold text-xl mb-1">
                        Cetak PDF Resmi
                    </div>
                    <p class="text-xs text-gray-500 group-hover:text-red-50/80">Format laporan standar cetak</p>
                </button>
            </div>
        </div>
    </x-card>
</div>