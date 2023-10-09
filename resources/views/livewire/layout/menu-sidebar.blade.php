<div>
    <x-slot:sidebar drawer="main-drawer" class="bg-white"
        style="scroll-behavior: smooth; scroll-padding-top: 5rem;">

        <!-- Activate menu item when route matches `link` property -->
        <x-menu activate-by-route class="w-64 gap-2 mt-7">
            <x-menu-item title="{{ __('Dashboard') }}" icon="o-home" link="{{ route('dashboard') }}" />
            <x-menu-item title="Layanan" icon="o-ticket" />
            <x-menu-separator title="Settings" />
            <x-menu-sub title="Settings" icon="o-cog-6-tooth">
                <x-menu-item title="Users" icon="o-user-group" link="{{ route('data.user') }}" />
                <x-menu-item title="Application" icon="o-wrench-screwdriver" />
                <x-menu-item title="Roles & Permissions" icon="o-identification" />
            </x-menu-sub>
            <x-menu-separator title="Master" />
            <x-menu-sub title="Master Data" icon="o-archive-box">
                <x-menu-item title="Sekolah" icon="o-home-modern" />
            </x-menu-sub>
            <div
                class="bg-base-100 pointer-events-none sticky bottom-0 flex h-40 [mask-image:linear-gradient(transparent,#000000)]">
            </div>
        </x-menu>
    </x-slot:sidebar>
</div>
