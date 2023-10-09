<?php

use Livewire\Volt\Component;

new class extends Component {
    public function logout(): void
    {
        auth()
            ->guard('web')
            ->logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirect('/', navigate: true);
    }
}; ?>

<x-nav sticky full-width>

    <x-slot:brand>
        <!-- Drawer toggle for "main-drawer" -->
        <label for="main-drawer" class="lg:hidden mr-3">
            <x-icon name="o-bars-3" class="cursor-pointer" />
        </label>

        <!-- Your logo -->
        <a href="{{ route('dashboard') }}" wire:navigate>
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </a>
    </x-slot:brand>

    <!-- Right side actions -->
    <x-slot:actions>
        <div class="dropdown dropdown-end cursor-pointer">
            <div tabindex="0" x-data="{ name: '{{ auth()->user()->name }}' }" x-text="name"
                x-on:profile-updated.window="name = $event.detail.name"></div>
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                <li><a href="{{ route('profile') }}" wire:navigate>{{ __('Profile') }}</a></li>
                <li><a wire:click="logout">{{ __('Log Out') }}</a></li>
            </ul>
        </div>

    </x-slot:actions>
</x-nav>
