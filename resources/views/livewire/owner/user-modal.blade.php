<x-modal-card wire:model.live="isOpen" maxWidth="lg">
    <form wire:submit.prevent="store" class="p-5 sm:p-8">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">
                {{ $userId ? 'Edit User' : 'Tambah User Baru' }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                Lengkapi data informasi akun di bawah ini secara detail.
            </p>
        </div>
        <!-- Form Body -->
        <div class="space-y-5">
            <!-- Nama Lengkap -->
            <div>
                <x-input-label for="name" value="Nama Lengkap" />
                <x-text-input wire:model="name" id="name" type="text" class="mt-1.5 block w-full"
                    placeholder="Contoh: John Doe" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>
            <!-- Email -->
            <div>
                <x-input-label for="email" value="Email Perusahaan" />
                <x-text-input wire:model="email" id="email" type="email" class="mt-1.5 block w-full"
                    placeholder="john@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>
            <!-- Role & Cabang -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <x-input-label value="Role Akses" />
                    <select wire:model="role"
                        class="mt-1.5 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm transition duration-150">
                        <option value="">Pilih Role</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->name }}" wire:key="role-{{ $r->id }}">
                                {{ ucfirst($r->name) }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-1" />
                </div>
                <div>
                    <x-input-label value="Penempatan Cabang" />
                    <select wire:model="branch_id"
                        class="mt-1.5 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm transition duration-150">
                        <option value="">Pilih Cabang</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" wire:key="branch-{{ $branch->id }}">
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- Password -->
            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input wire:model="password" id="password" type="password" class="mt-1.5 block w-full" />
                @if($userId)
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1 italic">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Kosongkan jika tidak ingin mengganti password
                    </p>
                @endif
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>
        </div>
        <!-- Action Buttons (Responsive Flex) -->
        <div class="mt-10 flex flex-col sm:flex-row-reverse gap-3">
            <button type="submit"
                class="flex-1 py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-md transition-all active:scale-[0.98] focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                {{ $userId ? 'Update Perubahan' : 'Simpan Akun Baru' }}
            </button>
            <button type="button" wire:click="closeModal"
                class="flex-1 py-3 px-4 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold shadow-md transition-all active:scale-[0.98] focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Batalkan
            </button>
        </div>
    </form>
</x-modal-card>