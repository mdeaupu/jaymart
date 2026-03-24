<header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-gray-900 shadow-sm">

    <div class="flex items-center">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard Admin</h2>
    </div>

    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" @click.outside="open = false"
            class="relative z-10 flex items-center p-2 text-sm text-gray-600 bg-white border border-transparent rounded-md focus:border-gray-900 focus:ring-opacity-40 focus:ring-gray-900 focus:ring focus:outline-none transition-all hover:bg-gray-50">
            <span class="mx-2 font-medium">Administrator</span>
            <img class="object-cover w-8 h-8 rounded-full border border-gray-300 shadow-sm"
                src="https://ui-avatars.com/api/?name=Admin&background=4f46e5&color=fff" alt="Avatar">
            <svg class="w-5 h-5 mx-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 15.713L18.01 9.702L16.597 8.288L12 12.885L7.404 8.288L5.99 9.702L12 15.713Z"
                    fill="currentColor"></path>
            </svg>
        </button>

        <div x-show="open" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute right-0 z-20 w-56 py-2 mt-2 overflow-hidden bg-white rounded-md shadow-xl border border-gray-100"
            style="display: none;">

            <a href="#"
                class="flex items-center p-3 -mt-2 text-sm text-gray-600 transition-colors duration-200 transform hover:bg-gray-100">
                <img class="shrink-0 object-cover mx-1 rounded-full w-9 h-9"
                    src="https://ui-avatars.com/api/?name=Admin&background=4f46e5&color=fff" alt="jane avatar">
                <div class="mx-1">
                    <h1 class="text-sm font-semibold text-gray-700">Administrator</h1>
                    <p class="text-xs text-gray-500">admin@email.com</p>
                </div>
            </a>

            <hr class="border-gray-200">

            <a href="#"
                class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform hover:bg-indigo-50 hover:text-indigo-600">
                Lihat Profil
            </a>

            <a href="#"
                class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform hover:bg-indigo-50 hover:text-indigo-600">
                Pengaturan
            </a>

            <hr class="border-gray-200">

            <a href="#"
                class="block px-4 py-3 text-sm text-red-600 font-medium transition-colors duration-200 transform hover:bg-red-50">
                Keluar Aplikasi
            </a>
        </div>
    </div>
</header>