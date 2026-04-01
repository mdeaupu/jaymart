<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        @if(isset($header))
            <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                <tr>
                    {{ $header }}
                </tr>
            </thead>
        @endif
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            {{ $slot }}
        </tbody>
    </table>
</div>