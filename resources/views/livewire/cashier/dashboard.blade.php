<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans">

    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span
                    class="px-2.5 py-0.5 bg-blue-100 text-blue-800 text-xs font-extrabold rounded-md uppercase tracking-wider">
                    Sistem Kasir Pintar
                </span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">
                Selamat Datang, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-sm text-zinc-500 mt-1">
                Anda saat ini login di cabang:
                <strong class="text-blue-600 font-bold">{{ auth()->user()->branch->name ?? 'Cabang Aktif' }}</strong>
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">

        <a href="{{ route('cashier.pos') }}" class="group block h-full">
            <div
                class="bg-gradient-to-br from-emerald-600 to-emerald-700 text-white p-6 rounded-2xl shadow-lg border border-emerald-500 flex flex-col justify-between h-full transform transition hover:-translate-y-1 hover:shadow-xl">
                <div>
                    <div class="mb-4">
                        <span class="p-3 bg-white/20 rounded-xl inline-block backdrop-blur-sm text-xl">🛒</span>
                    </div>
                    <h3 class="text-xl font-black tracking-tight mb-2">Mulai Transaksi Baru</h3>
                    <p class="text-xs font-medium text-emerald-100 leading-relaxed">
                        Buka mesin kasir dan layani pembelian barang konsumen sekarang.
                    </p>
                </div>
            </div>
        </a>

        <a href="{{ route('cashier.report') }}" class="group block h-full">
            <div
                class="bg-white p-6 rounded-2xl border border-zinc-200 shadow-sm flex flex-col justify-between h-full transform transition hover:-translate-y-1 hover:shadow-md hover:border-zinc-300">
                <div>
                    <div class="mb-4">
                        <span class="p-3 bg-zinc-100 text-zinc-600 rounded-xl inline-block text-xl">📊</span>
                    </div>
                    <h3 class="text-xl font-black text-zinc-900 tracking-tight mb-2">Laporan Shift Saya</h3>
                    <p class="text-xs font-medium text-zinc-500 leading-relaxed">
                        Pantau akumulasi total penjualan harian dan riwayat cetak struk Anda.
                    </p>
                </div>
            </div>
        </a>

    </div>
</div>