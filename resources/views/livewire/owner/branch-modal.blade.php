<x-modal-card wire:model.live="isOpen" maxWidth="2xl">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white">
            {{ $branchId ? 'Edit Cabang' : 'Tambah Cabang Baru' }}
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">
            Lengkapi informasi detail lokasi cabang mini market di bawah ini.
        </p>
    </div>

    <form wire:submit.prevent="store" class="p-6">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-input-label for="name" value="Nama Cabang" class="mb-2" />
                <x-text-input id="name" type="text" class="w-full shadow-sm focus:ring-indigo-500" wire:model="name"
                    placeholder="Contoh: Cabang Jakarta Pusat" />
                <x-input-error :messages="$errors->get('name')" for="name" class="mt-2" />
            </div>

            <div>
                <x-input-label for="address" value="Alamat Lengkap" class="mb-2" />
                <x-text-input id="address" rows="3"
                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    wire:model="address" placeholder="Masukkan alamat lengkap cabang..."></x-text-input>
                <x-input-error :messages="$errors->get('address')" for="address" class="mt-2" />
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-3">
            <button type="submit" wire:loading.attr="disabled"
                class="w-full text-center items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 border border-transparent rounded-lg font-bold text-xs text-gray-100 tracking-widest active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all active:scale-95 disabled:opacity-50">
                <span wire:loading.remove wire:target="store">
                    {{ $branchId ? 'Simpan Perubahan' : 'Tambah Cabang' }}
                </span>
                <span wire:loading wire:target="store">
                    Memproses...
                </span>
            </button>
            <button type="button" wire:click="closeModal"
                class="w-full px-5 py-2.5 text-sm font-semibold text-gray-100 bg-red-600 hover:bg-red-700 rounded-lg transition-all active:scale-95">
                Batal
            </button>

        </div>
    </form>
</x-modal-card>