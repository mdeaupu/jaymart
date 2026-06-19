<x-modal-card wire:model.live="isOpen" maxWidth="md">
    <form wire:submit.prevent="store" class="p-6 sm:p-8">
        <div class="text-center mb-8 border-b border-zinc-100 pb-6">
            <h2 class="text-2xl font-black text-zinc-900 tracking-tight">
                {{ $userId ? 'Edit Staff' : 'Tambah Staff Baru' }}</h2>
        </div>

        <div class="space-y-5">
            <div>
                <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Nama
                    Lengkap</label>
                <input type="text" wire:model="name"
                    class="w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold transition-all shadow-sm">
                @error('name') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Email</label>
                <input type="email" wire:model="email"
                    class="w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold transition-all shadow-sm">
                @error('email') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Password</label>
                <input type="password" wire:model="password"
                    placeholder="{{ $userId ? 'Kosongkan jika tidak diganti' : 'Minimal 8 karakter' }}"
                    class="w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold transition-all shadow-sm">
                @error('password') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-[11px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Role
                    Jabatan</label>
                <select wire:model="role"
                    class="w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold transition-all shadow-sm">
                    <option value="">Pilih Role</option>
                    @foreach($availableRoles as $r)
                        <option value="{{ $r->name }}">{{ $r->name }}</option>
                    @endforeach
                </select>
                @error('role') <span class="text-rose-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 border-t border-zinc-100 pt-6">
            <button type="button" wire:click="$set('isOpen', false)"
                class="px-4 py-2.5 bg-zinc-100 text-zinc-700 rounded-xl text-xs font-bold hover:bg-zinc-200 transition-all shadow-sm">Batal</button>
            <button type="submit" wire:loading.attr="disabled"
                class="px-6 py-2.5 bg-zinc-900 hover:bg-zinc-800 text-white rounded-xl text-xs font-bold shadow-sm transition-all active:scale-95 disabled:opacity-50">
                <span wire:loading.remove wire:target="store">Simpan Perubahan</span>
                <span wire:loading wire:target="store">Menyimpan...</span>
            </button>
        </div>
    </form>
</x-modal-card>