<x-modal-card wire:model.live="isOpen" maxWidth="lg">
    <form wire:submit.prevent="store" class="p-5 sm:p-8">
        <div class="text-center mb-8 border-b border-zinc-100 pb-6">
            <h2 class="text-2xl font-black text-zinc-900 tracking-tight">
                {{ $userId ? 'Edit User' : 'Tambah User Baru' }}
            </h2>
            <p class="text-sm font-medium text-zinc-500 mt-2">
                Lengkapi data informasi akun di bawah ini secara detail.
            </p>
        </div>

        <div class="space-y-5">
            <div>
                <x-input-label for="name" value="Nama Lengkap"
                    class="text-zinc-600 font-bold text-[11px] uppercase tracking-wider" />
                <x-text-input wire:model="name" id="name" type="text"
                    class="mt-1.5 block w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold transition-all shadow-sm"
                    placeholder="Contoh: John Doe" />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-rose-600 text-xs font-bold" />
            </div>

            <div>
                <x-input-label for="email" value="Email Perusahaan"
                    class="text-zinc-600 font-bold text-[11px] uppercase tracking-wider" />
                <x-text-input wire:model="email" id="email" type="email"
                    class="mt-1.5 block w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold transition-all shadow-sm"
                    placeholder="john@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-600 text-xs font-bold" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label value="Role Akses"
                        class="text-zinc-600 font-bold text-[11px] uppercase tracking-wider" />
                    <select wire:model="role"
                        class="mt-1.5 block w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold transition-all shadow-sm cursor-pointer">
                        <option value="">Pilih Role</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->name }}" wire:key="role-{{ $r->id }}">
                                {{ ucfirst($r->name) }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-1 text-rose-600 text-xs font-bold" />
                </div>
                <div>
                    <x-input-label value="Penempatan Cabang"
                        class="text-zinc-600 font-bold text-[11px] uppercase tracking-wider" />
                    <select wire:model="branch_id"
                        class="mt-1.5 block w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold transition-all shadow-sm cursor-pointer">
                        <option value="">Pilih Cabang</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" wire:key="branch-{{ $branch->id }}">
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <x-input-label for="password" value="Password"
                    class="text-zinc-600 font-bold text-[11px] uppercase tracking-wider" />
                <x-text-input wire:model="password" id="password" type="password"
                    class="mt-1.5 block w-full bg-zinc-50 border-zinc-200 text-zinc-800 rounded-xl focus:border-purple-500 focus:ring-purple-500 text-sm font-semibold transition-all shadow-sm" />
                @if($userId)
                    <p class="text-[10px] font-bold text-zinc-500 mt-2 flex items-center gap-1 uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5 text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Kosongkan jika tidak ingin mengganti password
                    </p>
                @endif
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-600 text-xs font-bold" />
            </div>
        </div>

        <div class="mt-10 flex flex-col sm:flex-row-reverse gap-3">
            <button type="submit"
                class="flex-1 py-3 px-4 bg-zinc-900 hover:bg-zinc-800 text-white rounded-xl font-bold shadow-sm transition-all active:scale-95">
                {{ $userId ? 'Update Perubahan' : 'Simpan Akun Baru' }}
            </button>
            <button type="button" wire:click="closeModal"
                class="flex-1 py-3 px-4 bg-zinc-100 hover:bg-zinc-200 text-zinc-700 rounded-xl font-bold shadow-sm transition-all active:scale-95">
                Batal
            </button>
        </div>
    </form>
</x-modal-card>