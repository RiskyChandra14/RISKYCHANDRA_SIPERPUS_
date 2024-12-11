@props([
    'header' => '',
])

<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>{{ $header }}</tr>
                    </thead>
                    <tbody>
                        {{ $slot }}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('th')
        .forEach(el => el.classList.add("px-6", "py-3", "text-left", "text-xl", "font-medium", "text-black-500",
            "uppercase")); // Perbesar font pada th ke text-xl

    document.querySelectorAll('td')
        .forEach(el => el.classList.add("px-6", "py-4", "whitespace-nowrap", "text-lg", "font-medium", "text-black-800",
            "dark:text-black-200")); // Perbesar font pada td ke text-lg
</script>
