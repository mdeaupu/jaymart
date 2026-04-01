@props(['id', 'maxWidth' => 'md'])

@php
    $maxWidthClass = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
    ][$maxWidth] ?? 'sm:max-w-md';
@endphp

<div x-data="{ show: @entangle($attributes->wire('model')) }" x-show="show" x-on:keydown.escape.window="show = false"
    class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="fixed inset-0 transition-all transform" x-on:click="show = false">
        <div class="absolute inset-0 bg-gray-900/75 backdrop-blur-sm"></div>
    </div>

    <div class="flex items-center justify-center min-h-screen p-4">
        <div x-show="show"
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl transform transition-all w-full {{ $maxWidthClass }} overflow-hidden border border-gray-100 dark:border-gray-700 relative z-10"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">
            {{ $slot }}
        </div>
    </div>
</div>