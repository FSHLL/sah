<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('projects.titles.index') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-4">
        <router-view></router-view>
    </div>
</x-app-layout>
