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
                        <th class="px-6 py-3">Waktu</th>
                        <th class="px-6 py-3">Aksi</th>
                    </x-slot>

                    @foreach($requests as $req)
                    {{ $req->transaction }}
                    <tr>
                        <!-- <pre>{{ $req->transaction }}</pre> -->

                       

                    </tr>
                    @endforeach

                </x-table>

            </div>
        </x-card>

    </div>

</div>