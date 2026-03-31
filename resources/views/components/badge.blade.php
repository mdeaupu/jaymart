@props(['color' => 'gray'])

@php
    $colors = [
        'green' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        'red' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        'blue' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
        'indigo' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
        'orange' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
        'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
    ];
    $theme = $colors[$color] ?? $colors['gray'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold $theme"]) }}>
    {{ $slot }}
</span>