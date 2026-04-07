<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">{{ __('Export Center') }}</h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8">
    <x-card class="max-w-4xl mx-auto p-10 text-center">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">Pusat Laporan Cabang</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-8">Unduh laporan performa bulanan dalam format yang diinginkan.
        </p>

        <div class="max-w-xs mx-auto mb-10">
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Pilih Bulan Laporan</label>
            <input type="month" wire:model="month"
                class="[&::-webkit-calendar-picker-indicator]:dark:invert w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <button wire:click="exportExcel"
                class="group p-8 border-2 border-green-500/30 rounded-2xl hover:bg-green-500 transition-all duration-200 text-center">
                <div class="text-green-600 dark:text-green-400 group-hover:text-white font-bold text-xl mb-1">Export
                    Excel (.xlsx)</div>
                <p class="text-xs text-gray-500 group-hover:text-green-100">Cocok untuk olah data transaksi besar</p>
            </button>

            <button wire:click="exportPdf"
                class="group p-8 border-2 border-red-500/30 rounded-2xl hover:bg-red-500 transition-all duration-200 text-center">
                <div class="text-red-600 dark:text-red-400 group-hover:text-white font-bold text-xl mb-1">Cetak PDF
                    Resmi</div>
                <p class="text-xs text-gray-500 group-hover:text-red-100">Format laporan standar cetak</p>
            </button>
        </div>
    </x-card>
</div>