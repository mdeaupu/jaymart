<x-modal-card wire:model.live="isOpen" maxWidth="lg">
    <form wire:submit.prevent="store" class="p-5 sm:p-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">
                {{ $branchId ? 'Edit Cabang' : 'Tambah Cabang Baru' }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                Lengkapi informasi detail lokasi cabang mini market di bawah ini.
            </p>
        </div>
        <!-- Form Body -->
        <div class="space-y-5">
            <!-- Nama Cabang -->
            <div>
                <x-input-label for="name" value="Nama Cabang" />
                <x-text-input wire:model="name" id="name" type="text" class="mt-1.5 block w-full"
                    placeholder="Contoh: Cabang Jakarta Pusat" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>
            <!-- Alamat Lengkap -->
            <div>
                <x-input-label for="address" value="Alamat Lengkap" />
                <textarea wire:model="address" id="address" rows="3"
                    class="mt-1.5 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 rounded-md shadow-sm transition duration-150"
                    placeholder="Masukkan alamat lengkap cabang..."></textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-1" />
            </div>
        </div>
        <!-- Action Buttons -->
        <div class="mt-10 flex flex-col sm:flex-row-reverse gap-3">
            <button type="submit" wire:loading.attr="disabled"
                class="flex-1 py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-md transition-all active:scale-[0.98] focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <div class="flex items-center justify-center gap-2">
                    <!-- Loading Spinner -->
                    <svg wire:loading wire:target="store" class="animate-spin h-4 w-4 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>
                        <span wire:loading.remove wire:target="store">
                            {{ $branchId ? 'Update Perubahan' : 'Simpan Cabang' }}
                        </span>
                        <span wire:loading wire:target="store">
                            Memproses...
                        </span>
                    </span>
                </div>
            </button>
            <button type="button" wire:click="closeModal"
                class="flex-1 py-3 px-4 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold shadow-md transition-all active:scale-[0.98] focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Batalkan
            </button>
        </div>
    </form>
</x-modal-card>