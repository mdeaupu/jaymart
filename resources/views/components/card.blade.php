@props(['title', 'slot'])

<div class="bg-white p-4 rounded shadow">
    <h3 class="text-md font-semibold mb-2">{{ $title }}</h3>
    {{ $slot }}
</div>