<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-blue-100 text-blue-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Reporting</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Export Center</h1>
            <p class="text-sm text-zinc-500 mt-1">Unduh laporan performa bulanan dalam format yang diinginkan secara
                real-time.</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-10 rounded-2xl border border-zinc-200 shadow-sm mt-8">
        <div class="max-w-xs mx-auto mb-10">
            <label class="block text-[11px] font-black text-zinc-500 uppercase tracking-wider mb-2 text-center">Pilih
                Bulan Laporan</label>
            <input type="month" wire:model="month"
                class="w-full border-zinc-200 bg-zinc-50 text-zinc-800 font-bold rounded-xl shadow-sm focus:ring-purple-500 focus:border-purple-500 transition-all text-center">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <button wire:click="exportExcel"
                class="group p-8 bg-white border border-zinc-200 rounded-2xl hover:border-emerald-500 hover:bg-emerald-50 transition-all text-center shadow-sm active:scale-95">
                <div class="text-emerald-600 font-black text-2xl mb-2">Export Excel</div>
                <div class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider group-hover:text-emerald-700">
                    Format .xlsx (Raw Data)</div>
            </button>

            <button wire:click="exportPdf"
                class="group p-8 bg-white border border-zinc-200 rounded-2xl hover:border-rose-500 hover:bg-rose-50 transition-all text-center shadow-sm active:scale-95">
                <div class="text-rose-600 font-black text-2xl mb-2">Cetak PDF</div>
                <div class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider group-hover:text-rose-700">
                    Format Laporan Standar</div>
            </button>
        </div>
    </div>
</div>