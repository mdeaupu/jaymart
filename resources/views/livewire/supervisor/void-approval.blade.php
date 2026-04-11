<div wire:poll.5s class="space-y-6 p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                Void Approval
            </h2>
            <p class="text-sm text-gray-500">
                Kelola permintaan pembatalan transaksi dari kasir
            </p>
        </div>

        <div class="text-sm text-gray-500">
            Total: <span class="font-semibold">{{ count($requests) }}</span>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session()->has('message'))
        <div class="px-4 py-3 bg-green-100 text-green-700 rounded-xl shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    {{-- LIST --}}
    <div class="grid gap-4">

        @forelse($requests as $req)
        <div class="p-5 bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-md transition">

            <div class="flex justify-between items-start">

                {{-- LEFT --}}
                <div class="space-y-2">

                    {{-- INVOICE --}}
                    <div class="text-lg font-bold text-gray-800 dark:text-gray-100">
                        {{ $req->transaction->invoice_number }}
                    </div>

                    {{-- INFO --}}
                    <div class="text-sm text-gray-500 space-y-1">
                        <div>Cabang: <span class="font-medium text-gray-700 dark:text-gray-200">
                            {{ $req->transaction->branch->name }}
                        </span></div>

                        <div>Kasir: <span class="font-medium">
                            {{ $req->requester->name }}
                        </span></div>

                        <div>Total: 
                            <span class="font-semibold text-blue-600">
                                Rp {{ number_format($req->transaction->total_price) }}
                            </span>
                        </div>
                    </div>

                    {{-- ALASAN --}}
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        <span class="font-semibold">Alasan:</span> {{ $req->reason }}
                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="text-right flex flex-col justify-between items-end h-full">

                    {{-- DATE --}}
                    <div class="text-xs text-gray-400">
                        <div>{{ $req->created_at->format('d M Y') }}</div>
                        <div>{{ $req->created_at->format('H:i') }}</div>
                    </div>

                    {{-- ACTION --}}
                    <div class="flex gap-2 mt-4">

                        <button 
                            wire:click="approve({{ $req->id }})"
                            class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-xl shadow hover:bg-green-600 transition"
                        >
                            ✔ Approve
                        </button>

                        <button 
                            wire:click="reject({{ $req->id }})"
                            class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-xl shadow hover:bg-red-600 transition"
                        >
                            ✖ Reject
                        </button>

                    </div>

                </div>

            </div>

        </div>

        @empty
        <div class="text-center py-12 text-gray-500 italic">
            Tidak ada request void
        </div>
        @endforelse

    </div>

</div>