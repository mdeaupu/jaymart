@props(['type' => 'success', 'message' => null])

@php
    $classes = $type === 'success'
        ? 'bg-green-50 border-green-200 border-l-green-500 text-green-700 dark:bg-green-900/20 dark:border-green-800 dark:text-green-400'
        : 'bg-red-50 border-red-200 border-l-red-500 text-red-700 dark:bg-red-900/30 dark:border-red-800 dark:text-red-400';
@endphp

@if($message)
    <div {{ $attributes->merge(['class' => "mb-4 p-4 border border-l-4 rounded shadow-sm text-sm $classes"]) }}>
        {{ $message }}
    </div>
@endif