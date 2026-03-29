<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Branches Management') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session()->has('error'))
            <div
                class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        @if (session()->has('message'))
            <div
                class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded shadow-sm">
                {{ session('message') }}
            </div>
        @endif
        <div class="mb-6 flex justify-between items-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">Kelola lokasi dan data operasional cabang mini market.
            </p>
            <button wire:click="create"
                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Tambah Cabang') }}
            </button>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ __('Nama Cabang') }}
                                </th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ __('Alamat') }}
                                </th>
                                <th class="px-6 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300 text-right">
                                    {{ __('Aksi') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($branches as $branch)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $branch->name }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $branch->address }}
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-3">
                                        <button wire:click="edit({{ $branch->id }})"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 font-medium transition">
                                            Edit
                                        </button>

                                        <button wire:click="delete({{ $branch->id }})"
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
                    {{ $branches->links() }}
                </div>
            </div>
        </div>
    </div>

    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('isOpen', false)"></div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl z-10 w-full max-w-md transform transition-all">
                <form wire:submit.prevent="store" class="p-8">
                    <h3 class="text-xl font-bold mb-6 dark:text-white text-center">Data Cabang</h3>

                    <div class="space-y-4">
                        <div>
                            <x-input-label value="Nama Toko" class="dark:text-gray-300" />
                            <x-text-input wire:model="name"
                                class="w-full mt-1 bg-gray-50 dark:bg-gray-900 border-none rounded-xl shadow-inner"
                                placeholder="Jaymart Jakarta" />
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label value="Alamat Lengkap" class="dark:text-gray-300" />
                            <textarea wire:model="address"
                                class="w-full mt-1 bg-gray-50 dark:bg-gray-900 border-none rounded-xl shadow-inner text-gray-900 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500"
                                rows="3" placeholder="Jl. Raya No..."></textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-1" />
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="button" wire:click="$set('isOpen', false)"
                            class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 transition-colors uppercase tracking-widest">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg font-bold text-xs uppercase tracking-widest transition-all">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>