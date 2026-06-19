<div class="py-6 lg:py-10 mx-auto px-4 sm:px-6 lg:px-8 bg-zinc-50 min-h-screen">
    <x-alert type="success" :message="session('message')" />
    <x-alert type="error" :message="session('error')" />

    {{-- EXECUTIVE HEADER --}}
    <div
        class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 border-b border-zinc-200 pb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span
                    class="px-2.5 py-0.5 bg-purple-100 text-purple-800 text-xs font-extrabold rounded-md uppercase tracking-wider">Master
                    Data</span>
            </div>
            <h1 class="text-3xl font-black text-zinc-900 tracking-tight">Manajemen Akun Pegawai</h1>
            <p class="text-sm text-zinc-500 mt-1">Kelola hak akses dan penempatan cabang pegawai secara terpusat.</p>
        </div>
        <div class="w-full sm:w-auto">
            <button wire:click="create"
                class="inline-flex items-center justify-center px-5 py-2.5 bg-zinc-900 border border-transparent rounded-xl font-bold text-sm text-white tracking-wide hover:bg-zinc-800 focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2 shadow-sm active:scale-95 transition-all duration-200 w-full">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah User Baru
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-100 text-zinc-600 uppercase text-[10px] tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Cabang</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach($users as $user)
                        <tr wire:key="user-{{ $user->id }}" class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-black text-zinc-800">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs font-medium text-zinc-500">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2.5 py-1 bg-purple-100 text-purple-800 text-xs font-bold rounded-md">{{ $user->getRoleNames()->first() }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-zinc-700">{{ $user->branch->name ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button wire:click="edit({{ $user->id }})"
                                        class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-all"
                                        title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $user->id }})"
                                        class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-all" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-zinc-100 bg-zinc-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    @if($isOpen) @include('livewire.owner.user-modal') @endif
    @if($confirmingUserDeletion)
        <x-modal-card wire:model.live="confirmingUserDeletion" maxWidth="sm">
            <div class="p-6 text-center" wire:key="delete-modal-content">
                <div class="w-16 h-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-zinc-900 mb-2">Hapus Pengguna?</h3>
                <p class="text-xs text-zinc-500 font-medium mb-6">Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="button" wire:click="$set('confirmingUserDeletion', false)"
                        class="flex-1 px-4 py-2.5 text-sm font-bold text-zinc-700 bg-zinc-100 hover:bg-zinc-200 rounded-xl transition-all">
                        Batal
                    </button>
                    <button type="button" wire:click="delete" wire:loading.attr="disabled"
                        class="flex-1 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-sm font-bold shadow-sm transition-all disabled:opacity-50">
                        Hapus
                    </button>
                </div>
            </div>
        </x-modal-card>
    @endif
</div>