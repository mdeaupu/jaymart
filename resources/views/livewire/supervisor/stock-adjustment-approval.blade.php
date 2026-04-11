<div wire:poll.5s>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Approval Adjustment Gudang
        </h2>
    </x-slot>

    <div class="py-10 mx-auto sm:px-6 lg:px-8">

        {{-- ALERT --}}
        @if(session()->has('message'))
            <div class="mb-4 text-green-500">
                {{ session('message') }}
            </div>
        @endif

        <x-card>
            <div class="p-6">

                <x-table>
                    <x-slot name="header">
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Cabang</th>
                        <th class="px-6 py-3">Stok Lama</th>
                        <th class="px-6 py-3">Stok Baru</th>
                        <th class="px-6 py-3">Selisih</th>
                        <th class="px-6 py-3">Alasan</th>
                        <th class="px-6 py-3">User</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </x-slot>

                    @forelse($requests as $req)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">

                        {{-- PRODUK --}}
                        <td class="px-6 py-4 font-medium">
                            {{ $req->product->name }}
                        </td>

                        {{-- CABANG --}}
                        <td class="px-6 py-4">
                            <x-badge color="gray">
                                {{ $req->branch->name ?? '-' }}
                            </x-badge>
                        </td>

                        {{-- STOK --}}
                        <td class="px-6 py-4">
                            {{ $req->old_quantity }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $req->new_quantity }}
                        </td>

                        {{-- SELISIH --}}
                        <td class="px-6 py-4 font-bold">
                            <span class="{{ $req->adjustment_amount >= 0 ? 'text-green-500' : 'text-red-500' }}">
                                {{ $req->adjustment_amount }}
                            </span>
                        </td>

                        {{-- ALASAN --}}
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $req->reason }}
                        </td>

                        {{-- USER --}}
                        <td class="px-6 py-4">
                            {{ $req->user->name ?? '-' }}
                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-6 py-4 text-sm">
                            {{ $req->created_at->format('d-m-Y H:i') }}
                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4 flex justify-center gap-2">

                            <button 
                                wire:click="approve({{ $req->id }})"
                                class="flex items-center gap-1 px-3 py-1 text-sm font-medium text-white bg-green-500 rounded-lg shadow hover:bg-green-600 transition-all duration-200"
                            >
                                ✔ <span>Approve</span>
                            </button>

                            <button 
                                wire:click="reject({{ $req->id }})"
                                class="flex items-center gap-1 px-3 py-1 text-sm font-medium text-white bg-red-500 rounded-lg shadow hover:bg-red-600 transition-all duration-200"
                            >
                                ✖ <span>Reject</span>
                            </button>

                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-sm text-gray-500 italic">
                            Tidak ada request pending
                        </td>
                    </tr>
                    @endforelse

                </x-table>

            </div>
        </x-card>

    </div>

</div>