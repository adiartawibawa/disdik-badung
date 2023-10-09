<x-app-layout>
    <x-slot name="title">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="flex gap-6">
        <x-stat title="Sales" value="22.124" icon="o-arrow-trending-up" />

        <x-stat title="Sales" description="This month" value="22.124" icon="o-arrow-trending-up" />

        <x-stat title="Sales" description="This month" value="22.124" icon="o-arrow-trending-down"
            class="text-orange-500" color="text-pink-500" />
    </div>

    {{-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            {{ __("You're logged in!") }}
        </div>
    </div> --}}
</x-app-layout>
