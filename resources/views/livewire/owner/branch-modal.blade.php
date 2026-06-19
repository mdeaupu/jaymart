<x-modal-card wire:model.live="isOpen" maxWidth="lg">
    <form wire:submit.prevent="store" class="p-5 sm:p-8">
        <div class="text-center mb-8 border-b border-zinc-100 pb-6">
            <h2 class="text-2xl font-black text-zinc-900 tracking-tight">
                {{ $branchId ? 'Edit Cabang' : 'Tambah Cabang Baru' }}
            </h2>
            <p class="text-sm font-medium text-zinc-500 mt-2">
                Lengkapi informasi detail lokasi cabang mini market di bawah ini.
            </p>
        </div>

        <div class="space-y-5">
            <div>
                <x-input-label for="name" value="Nama Cabang"
                    class="text-zinc-600 font-bold text-[11px] uppercase tracking-wider" />
                <x-text-input wire:model="name" id="name" type="text"
                    class="mt-1.5 block w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold transition-all shadow-sm"
                    placeholder="Contoh: Cabang Jakarta Pusat" />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-rose-600 text-xs font-bold" />
            </div>

            <div>
                <x-input-label for="address" value="Alamat Lengkap"
                    class="text-zinc-600 font-bold text-[11px] uppercase tracking-wider" />
                <textarea wire:model="address" id="address" rows="3"
                    class="mt-1.5 block w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold transition-all shadow-sm"
                    placeholder="Masukkan alamat lengkap cabang..."></textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-1 text-rose-600 text-xs font-bold" />
            </div>
        </div>

        <div class="mt-10 flex flex-col sm:flex-row-reverse gap-3">
            <button type="submit" wire:loading.attr="disabled"
                class="flex-1 py-3 px-4 bg-zinc-900 hover:bg-zinc-800 text-white rounded-xl font-bold shadow-sm transition-all active:scale-95">
                <div class="flex items-center justify-center gap-2">
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
                class="flex-1 py-3 px-4 bg-zinc-100 hover:bg-zinc-200 text-zinc-700 rounded-xl font-bold shadow-sm transition-all active:scale-95">
                Batal
            </button>
        </div>
    </form>
</x-modal-card>