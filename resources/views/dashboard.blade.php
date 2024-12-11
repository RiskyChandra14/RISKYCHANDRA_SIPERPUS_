<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="p-32">
        <div class="max-w-7xl mx-auto sm:px-8 lg:p-96">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Selamat Datang, ".Auth()->user()->name." !") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>