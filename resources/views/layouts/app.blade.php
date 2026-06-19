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
    @livewireStyles


</head>

<body class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-900">
    {{-- LAYOUT FLEXBOX HUBUNGAN SIDEBAR DAN KONTEN UTAMA --}}
    <div class="min-h-screen flex flex-col lg:flex-row">

        {{-- Komponen Navigasi Sidebar Samping --}}
        <livewire:layout.navigation />

        {{-- AREA KERJA UTAMA (KANAN): Menggeser konten sejauh w-64 pada layar besar desktop --}}
        <div class="flex-1 flex flex-col min-w-0 lg:pl-64 pt-14 lg:pt-0">

            <!-- Page Heading (Jika Ada) -->
            @if (isset($header))
                <header
                    class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-14 lg:top-0 z-20">
                    <div class="py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>

            {{-- Footer Komponen --}}
            <x-footer></x-footer>
        </div>
    </div>

    @livewireScripts

</body>

</html>