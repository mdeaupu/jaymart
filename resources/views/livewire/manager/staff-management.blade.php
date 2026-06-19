<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen font-sans" x-data="{ openModal: false }">
    
    {{-- EXECUTIVE HEADER --}}
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 bg-indigo-100 text-indigo-800 text-xs font-extrabold rounded-md uppercase tracking-wider">HR & Access</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight mt-1">Manajemen Staff</h1>
            <p class="text-sm text-zinc-500 mt-1">Manajemen akun akses kasir dan supervisor cabang.</p>
        </div>
        <div class="w-full sm:w-auto">
            <button wire:click="create"
                class="inline-flex items-center px-5 py-2.5 bg-zinc-900 rounded-xl font-bold text-sm text-white hover:bg-zinc-800 shadow-sm transition-all active:scale-95 w-full justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Staff
            </button>
        </div>
    </div>

    @if(session()->has('message'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-sm text-emerald-700 font-medium shadow-sm flex items-center gap-2">✨ {{ session('message') }}</div>
    @endif

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Nama & Email</th>
                        <th class="px-6 py-4">Role / Jabatan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($staff as $member)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-black text-zinc-900">{{ $member->name }}</div>
                                <div class="text-xs font-medium text-zinc-500">{{ $member->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-md uppercase tracking-wider">{{ $member->getRoleNames()->first() }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button wire:click="edit({{ $member->id }})" @click="openModal = true"
                                        class="px-3 py-1.5 bg-zinc-100 text-zinc-700 rounded-lg text-xs font-bold hover:bg-zinc-200 transition-all shadow-sm">
                                        Edit
                                    </button>
                                    <button wire:click="confirmDelete({{ $member->id }})"
                                        class="px-3 py-1.5 bg-rose-50 text-rose-700 rounded-lg text-xs font-bold hover:bg-rose-100 transition-all shadow-sm">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-6 py-12 text-center text-zinc-400 font-medium italic">Tidak ada data staff.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL HAPUS --}}
    @if($confirmingStaffDeletion)
        <x-modal-card wire:model.live="confirmingStaffDeletion" maxWidth="sm">
            <div class="p-8 text-center">
                <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">🗑️</span>
                </div>
                <h3 class="text-xl font-black text-zinc-900 mb-2">Hapus Staff?</h3>
                <p class="text-xs text-zinc-500 font-medium mb-6">Akses akun ini akan dicabut secara permanen.</p>
                <div class="flex gap-3">
                    <button type="button" wire:click="$set('confirmingStaffDeletion', false)" class="flex-1 px-4 py-2.5 bg-zinc-100 text-zinc-700 rounded-xl text-sm font-bold hover:bg-zinc-200 transition-all">Batal</button>
                    <button type="button" wire:click="delete" class="flex-1 px-4 py-2.5 bg-rose-600 text-white rounded-xl text-sm font-bold hover:bg-rose-700 shadow-sm transition-all active:scale-95">Hapus Akun</button>
                </div>
            </div>
        </x-modal-card>
    @endif
    
    {{-- INCLUDE STAFF MODAL --}}
    @if($isOpen) @include('livewire.manager.staff-modal') @endif
</div>