<div x-data="{ show: @entangle('isOpen') }" x-show="show" class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;">

    <div class="fixed inset-0 transition-all transform" x-on:click="show = false">
        <div class="absolute inset-0 bg-gray-900/75 backdrop-blur-sm"></div>
    </div>

    <div class="flex items-center justify-center min-h-screen p-4">

        <div x-show="show"
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl transform transition-all sm:w-full sm:max-w-lg overflow-hidden border border-gray-100 dark:border-gray-700"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

            <form wire:submit.prevent="store" class="p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        {{ $userId ? 'Edit User' : 'Tambah User Baru' }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Lengkapi data informasi akun di bawah ini
                    </p>
                </div>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="name" value="Nama Lengkap" class="ml-1" />
                        <x-text-input id="name" type="text"
                            class="mt-1 block w-full bg-gray-50 dark:bg-gray-900 rounded-xl border-none ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-indigo-500"
                            wire:model="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" class="ml-1" />
                        <x-text-input id="email" type="email"
                            class="mt-1 block w-full bg-gray-50 dark:bg-gray-900 rounded-xl border-none ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-indigo-500"
                            wire:model="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="role" value="Role" class="ml-1" />
                            <select wire:model="role"
                                class="mt-1 block w-full bg-gray-50 dark:bg-gray-900 rounded-xl border-none ring-1 ring-gray-200 dark:ring-gray-700 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500">
                                <option value="">Pilih Role</option>
                                @foreach($roles as $r)
                                    <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="branch_id" value="Cabang" class="ml-1" />
                            <select wire:model="branch_id"
                                class="mt-1 block w-full bg-gray-50 dark:bg-gray-900 rounded-xl border-none ring-1 ring-gray-200 dark:ring-gray-700 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500">
                                <option value="">Pilih Cabang</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="password" value="Password" class="ml-1" />
                        <x-text-input id="password" type="password"
                            class="mt-1 block w-full bg-gray-50 dark:bg-gray-900 rounded-xl border-none ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-indigo-500"
                            wire:model="password" />
                        @if($userId)
                            <p class="text-[10px] text-gray-400 mt-1 italic">*Kosongkan jika tidak ingin ganti</p>
                        @endif
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-2">
                    <button type="submit"
                        class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 dark:shadow-none transition-all active:scale-[0.98]">
                        {{ $userId ? 'Update Perubahan' : 'Simpan Akun Baru' }}
                    </button>
                    <button type="button" wire:click="closeModal"
                        class="w-full py-3 text-sm font-semibold text-gray-500 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
                        Batalkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>