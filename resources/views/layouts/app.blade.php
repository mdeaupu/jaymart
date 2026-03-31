<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script>
        function applyTheme() {
            if (localStorage.getItem('color-theme') === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }

        applyTheme();

        // Listener untuk menangani penghapusan tema setelah pindah halaman
        document.addEventListener('livewire:navigated', () => {
            // Jika ada tanda di session/storage bahwa kita baru saja logout
            if (window.isLoggingOut) {
                localStorage.removeItem('color-theme');
                window.isLoggingOut = false; // Reset flag
            }
            applyTheme();
        });

        // Tangkap event logout dari Livewire
        window.addEventListener('prepare-for-logout', () => {
            // Kita tidak hapus class 'dark' di sini agar tidak flicker
            // Kita hanya beri tanda (flag) untuk dihapus di halaman berikutnya
            window.isLoggingOut = true;
        });
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">
        <livewire:layout.navigation />

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <x-footer></x-footer>
    </div>

</body>

</html>