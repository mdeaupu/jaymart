<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">{{ __('Staff Management') }}</h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8" x-data="{ openModal: false }">
    <x-alert type="success" :message="session('message')" />
    <x-alert type="error" :message="session('error')" />
    <div class="mb-2 py-2">
        <div class="h-11 items-center flex justify-between">
            <p class="text-sm text-gray-800 dark:text-gray-400">Manajemen akun akses kasir dan supervisor.</p>
            <button wire:click="create"
                class="inline-flex items-center px-5 py-2.5 bg-gray-600 border border-transparent rounded-lg font-medium text-sm text-white tracking-wide hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2 shadow-md active:scale-95 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Staff
            </button>
        </div>
    </div>

    <x-card>
        <div class="p-6">
            <x-table>
                <x-slot name="header">
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-400">Nama</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-400">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-400">Role</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-800 dark:text-gray-400">Aksi</th>
                </x-slot>

                @forelse($staff as $member)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $member->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs text-gray-400">{{ $member->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm capitalize">
                            <x-badge color="indigo">{{ $member->getRoleNames()->first() }}</x-badge>
                        </td>
                        <td class="px-6 py-4 space-x-3 text-center">
                            <button wire:click="edit({{ $member->id }})" @click="openModal = true"
                                class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-semibold hover:bg-indigo-100 hover:text-indigo-800 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Edit
                            </button>

                            <button wire:click="confirmDelete({{ $member->id }})"
                                class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-sm font-semibold hover:bg-red-100 hover:text-red-800 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 italic">Tidak ada data staff.
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>
    </x-card>

    @if($isOpen) @include('livewire.manager.staff-modal') @endif

    @if($confirmingStaffDeletion)
        <x-modal-card wire:model.live="confirmingStaffDeletion" maxWidth="sm">
            <div class="p-8 text-center">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Hapus Staff?</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Akses akun ini akan dicabut secara permanen.</p>

                <div class="flex gap-3">
                    <button type="button" wire:click="$set('confirmingStaffDeletion', false)"
                        class="flex-1 px-4 py-3 text-gray-800 font-bold bg-gray-100 hover:bg-gray-200 rounded-xl transition-all active:scale-[0.98]">
                        Batal
                    </button>

                    <button type="button" wire:click="delete" wire:loading.attr="disabled"
                        class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold disabled:opacity-50 transition-all active:scale-[0.98]">
                        <span wire:loading.remove wire:target="delete">Hapus</span>
                        <span wire:loading wire:target="delete">Proses...</span>
                    </button>
                </div>
            </div>
        </x-modal-card>
    @endif
</div>