<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
    <div class="mx-auto max-w-7xl py-4 px-4 sm:px-2 lg:px-2">
        <div class="flex flex-col items-center justify-center space-y-4 md:flex-row md:justify-between md:space-y-0">
            <div class="order-1 md:order-2">
                <div
                    class="inline-flex items-center px-5 py-2.5 bg-gray-50 dark:bg-gray-700/40 rounded-full border border-gray-100 dark:border-gray-600 shadow-sm">
                    <span
                        class="text-gray-500 dark:text-gray-400 text-[11px] sm:text-xs font-mono tracking-widest leading-relaxed">
                        LARAVEL <span
                            class="text-indigo-500 dark:text-indigo-400 font-bold">v{{ Illuminate\Foundation\Application::VERSION }}</span>
                        <span class="mx-3 text-gray-300 dark:text-gray-600">|</span>
                        PHP <span class="text-indigo-500 dark:text-indigo-400 font-bold">v{{ PHP_VERSION }}</span>
                    </span>
                </div>
            </div>
            <div class="order-2 md:order-1">
                <p class="text-center md:text-left text-sm text-gray-500 dark:text-gray-400 tracking-tight">
                    &copy; {{ date('Y') }}
                    <span class="font-bold text-indigo-600 dark:text-indigo-400 ml-1">
                        <a href="{{ route('dashboard') }}" class="hover:underline transition-all">Jaymart</a>
                    </span>.
                    <span class="ml-1 hidden sm:inline text-gray-400">All rights reserved.</span>
                </p>
            </div>
        </div>
    </div>
</footer>