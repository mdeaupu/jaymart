<x-modal-card wire:model.live="isOpen" maxWidth="lg">
    <form wire:submit.prevent="store" class="p-8">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                {{ $userId ? 'Edit User' : 'Tambah User Baru' }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Lengkapi data informasi akun di bawah ini</p>
        </div>

        <div class="space-y-4">
            <div>
                <x-input-label for="name" value="Nama Lengkap" />
                <x-text-input wire:model="name" id="name" type="text" class="mt-1 block w-full"
                    placeholder="John Doe" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input wire:model="email" id="email" type="email" class="mt-1 block w-full"
                    placeholder="john@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label value="Role" />
                    <select wire:model="role"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Pilih Role</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-1" />
                </div>

                <div>
                    <x-input-label value="Cabang" />
                    <select wire:model="branch_id"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Pilih Cabang</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input wire:model="password" id="password" type="password" class="mt-1 block w-full" />
                @if($userId)
                    <p class="text-[10px] text-gray-400 mt-1 italic">*Kosongkan jika tidak ingin mengganti password</p>
                @endif
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-2">
            <button type="submit"
                class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg transition-all active:scale-[0.98]">
                {{ $userId ? 'Update Perubahan' : 'Simpan Akun Baru' }}
            </button>

            <button type="button" wire:click="closeModal"
                class="w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold shadow-lg transition-all active:scale-[0.98]">
                Batalkan
            </button>
        </div>
    </form>
</x-modal-card>