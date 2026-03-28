<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('User Management') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                            Hapus
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
</div>