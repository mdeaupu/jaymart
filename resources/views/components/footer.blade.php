<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
    <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between">
            <div class="mt-8 md:mt-0 md:order-1">
                <p class="text-center text-base text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }}
                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">
                        <a href="{{ route('dashboard') }}">Jaymart</a>
                    </span>.
                </p>
            </div>

            <div class="flex justify-center space-x-6 md:order-2">
                <span class="text-gray-400 text-xs">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </span>
            </div>
        </div>
    </div>
</footer>