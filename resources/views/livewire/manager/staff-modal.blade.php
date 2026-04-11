<x-modal-card wire:model.live="isOpen" maxWidth="md">
    <div class="p-8">
        <h3 class="text-xl font-bold mb-6 dark:text-white">{{ $userId ? 'Edit Staff' : 'Tambah Staff Baru' }}</h3>

        <form wire:submit.prevent="store">
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                    <input type="text" wire:model="name"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input type="email" wire:model="email"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                    <input type="password" wire:model="password"
                        placeholder="{{ $userId ? 'Kosongkan jika tidak diganti' : 'Minimal 8 karakter' }}"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role Jabatan</label>
                    <select wire:model="role"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Pilih Role</option>
                        @foreach($availableRoles as $r)
                            <option value="{{ $r->name }}">{{ $r->name }}</option>
                        @endforeach
                    </select>
                    @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" wire:click="$set('isOpen', false)"
                    class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 font-bold transition-all">
                    Batal
                </button>
                <button type="submit" wire:loading.attr="disabled"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-bold shadow-lg transition-all active:scale-95 disabled:opacity-50">
                    <span wire:loading.remove wire:target="store">Simpan Perubahan</span>
                    <span wire:loading wire:target="store">Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</x-modal-card>