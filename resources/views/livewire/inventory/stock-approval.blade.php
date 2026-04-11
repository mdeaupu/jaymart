<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
        Approval Request
    </h2>
</x-slot>

<div class="p-6">
    @foreach($requests as $req)
        <div class="border p-4 mb-3 rounded">
            <p><b>ID:</b> {{ $req->id }}</p>
            <p><b>Type:</b> {{ $req->type }}</p>
            <p><b>Status:</b> {{ $req->status }}</p>

            <button wire:click="approve({{ $req->id }})" class="bg-green-500 text-white px-3 py-1 rounded">
                Approve
            </button>

            <button wire:click="reject({{ $req->id }})" class="bg-red-500 text-white px-3 py-1 rounded">
                Reject
            </button>
        </div>
    @endforeach
</div>