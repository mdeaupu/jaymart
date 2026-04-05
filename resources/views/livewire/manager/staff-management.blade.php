<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">{{ __('Staff Management') }}</h2>
</x-slot>

<div class="py-10 mx-auto sm:px-6 lg:px-8" x-data="{ openModal: false }">
    <x-card class="p-6">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Kelola Staff Cabang</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Manajemen akun akses kasir dan supervisor.</p>
            </div>
            <button @click="openModal = true" wire:click="$set('userId', null)"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm transition">
                + Tambah Staff
            </button>
        </div>

        <x-table>
            <x-slot name="header">
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-400">Nama</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-400">Email</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800 dark:text-gray-400">Role</th>
                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-800 dark:text-gray-400">Aksi</th>
            </x-slot>

            @foreach($staff as $member)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $member->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $member->email }}</td>
                    <td class="px-6 py-4 text-sm">
                        <x-badge color="gray">{{ $member->getRoleNames()->first() }}</x-badge>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button wire:click="edit({{ $member->id }})" @click="openModal = true"
                            class="text-indigo-600 hover:text-indigo-900 font-bold text-sm">Edit</button>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </x-card>

    <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
        x-cloak>
        <div class="bg-white dark:bg-gray-800 rounded-xl w-full max-w-md p-8 shadow-2xl">
            <h3 class="text-xl font-bold mb-6 dark:text-white">{{ $userId ? 'Edit Staff' : 'Tambah Staff Baru' }}</h3>
            <form wire:submit.prevent="store">
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium dark:text-gray-300 mb-1">Nama Lengkap</label>
                        <input type="text" wire:model="name"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium dark:text-gray-300 mb-1">Email</label>
                        <input type="email" wire:model="email"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium dark:text-gray-300 mb-1">Password</label>
                        <input type="password" wire:model="password" placeholder="Kosongkan jika tidak diganti"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium dark:text-gray-300 mb-1">Role Jabatan</label>
                        <select wire:model="role"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg">
                            <option value="">Pilih Role</option>
                            @foreach($availableRoles as $r)
                                <option value="{{ $r->name }}">{{ $r->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" @click="openModal = false"
                        class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium">Batal</button>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold shadow-lg"
                        @click="openModal = false">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>