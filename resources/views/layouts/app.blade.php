<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>JayMart</title>
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">

        <x-sidebar />

        <div class="flex-1 flex flex-col">

            <x-header />

            <main class="p-6 flex-1 overflow-y-auto">
                @yield('content')
            </main>

            <x-footer />

        </div>

    </div>

    @livewireScripts
</body>

</html>