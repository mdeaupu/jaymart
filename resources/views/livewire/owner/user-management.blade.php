<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('User Management') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session()->has('message'))
            <div
                class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded shadow-sm">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded shadow-sm">
                {{ session('error') }}
            </div>
        @endif
        <div class="mb-6 flex justify-between items-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">Kelola hak akses dan penempatan cabang pegawai.</p>
            <button wire:click="create"
                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Tambah User') }}
            </button>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ __('Nama / Email') }}
                                </th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ __('Role') }}
                                </th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ __('Cabang') }}
                                </th>
                                <th
                                    class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300 text-center">
                                    {{ __('Aksi') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                            {{ $user->getRoleNames()->first() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $user->branch->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-3">
                                        <button wire:click="edit({{ $user->id }})"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 font-medium transition">
                                            Edit
                                        </button>

                                        <button wire:click="confirmDelete({{ $user->id }})"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 font-medium transition">
                                            {{ __('Hapus') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    @if($isOpen)
        @include('livewire.user-modal')
    @endif

    @if($confirmingUserDeletion)
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"
                wire:click="$set('confirmingUserDeletion', false)"></div>

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl z-10 w-full max-w-sm p-8 text-center border border-gray-100 dark:border-gray-700">
                <div
                    class="w-16 h-16 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Hapus Pengguna?</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Apakah Anda yakin? Data user ini akan dihapus
                    permanen dari sistem.</p>

                <div class="flex gap-3">
                    <button type="button" wire:click="$set('confirmingUserDeletion', false)"
                        class="flex-1 px-4 py-2 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 transition-colors uppercase tracking-widest">
                        Batal
                    </button>
                    <button type="button" wire:click="delete"
                        class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-red-200 dark:shadow-none transition-all">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>