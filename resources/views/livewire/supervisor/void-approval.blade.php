<div wire:poll.5s>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Void Approval
        </h2>
    </x-slot>

    <div class="py-10 mx-auto sm:px-6 lg:px-8">

        @if(session()->has('message'))
            <div class="mb-4 text-green-500">
                {{ session('message') }}
            </div>
        @endif

        <x-card>
            <div class="p-6">

                <x-table>
                    <x-slot name="header">
                        <th class="px-6 py-3">Invoice</th>
                        <th class="px-6 py-3">Cabang</th>
                        <th class="px-6 py-3">Kasir</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Alasan</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Aksi</th>
                    </x-slot>

                    @foreach($requests as $req)
                    <tr>

                        <td>{{ $req->transaction->invoice_number }}</td>
                        <td>{{ $req->transaction->branch->name }}</td>
                        <td>{{ $req->requester->name }}</td>
                        <td>Rp {{ number_format($req->transaction->total_price) }}</td>
                        <td>{{ $req->reason }}</td>
                        <td>{{ $req->created_at->format('d-m-Y H:i') }}</td>

                        <td class="flex gap-2">
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
                    @endforeach

                </x-table>

            </div>
        </x-card>

    </div>

</div>