@props(['title', 'colorClass' => 'border-indigo-500', 'iconBgClass' => ''])

<div
    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 {{ $colorClass }} transition-colors flex items-center gap-4">
    @if (isset($icon))
        <div class="p-3 rounded-xl {{ $iconBgClass }}">
            {{ $icon }}
        </div>
    @endif
    <div>
        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-400">{{ $title }}</h3>
        <div class="mt-2 text-2xl font-bold text-gray-800 dark:text-gray-100">
            {{ $slot }}
        </div>
    </div>
</div>