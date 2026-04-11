<div wire:poll.5s>

    {{-- HEADER --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Audit Trail Aktivitas
        </h2>
    </x-slot>

    <div class="py-10 mx-auto sm:px-6 lg:px-8">

        {{-- DESKRIPSI --}}
        <div class="mb-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Riwayat aktivitas pegawai pada sistem cabang.
            </p>
        </div>

        {{-- CARD --}}
        <x-card class="p-6">

            {{-- TITLE --}}
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                    Log Aktivitas
                </h3>

                <span class="text-sm text-gray-500">
                    Total: {{ count($logs) }} aktivitas
                </span>
            </div>

            {{-- LIST LOG --}}
            <div class="space-y-4">

                @forelse($logs as $log)
                <div class="p-4 rounded-xl border bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition">

                    <div class="flex justify-between items-start">

                        {{-- KIRI --}}
                        <div>

                            {{-- USER --}}
                            <p class="font-semibold text-gray-800 dark:text-gray-100">
                                {{ $log->user->name ?? '-' }}
                            </p>

                            {{-- ACTION --}}
                            <p class="text-sm mt-1">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($log->action == 'approve') bg-green-100 text-green-600
                                    @elseif($log->action == 'reject') bg-red-100 text-red-600
                                    @else bg-blue-100 text-blue-600
                                    @endif
                                ">
                                    {{ strtoupper($log->action) }}
                                </span>
                            </p>

                            {{-- DESKRIPSI --}}
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                                {{ $log->description }}
                            </p>

                            {{-- CABANG --}}
                            <p class="text-xs text-gray-400 mt-1">
                                Cabang: {{ $log->branch->name ?? '-' }}
                            </p>

                        </div>

                        {{-- KANAN (WAKTU) --}}
                        <div class="text-right text-xs text-gray-400">
                            <p>{{ $log->created_at->format('d M Y') }}</p>
                            <p>{{ $log->created_at->format('H:i') }}</p>
                        </div>

                    </div>

                </div>
                @empty
                <div class="text-center py-10 text-gray-500 italic">
                    Belum ada aktivitas
                </div>
                @endforelse

            </div>

        </x-card>

    </div>

</div>