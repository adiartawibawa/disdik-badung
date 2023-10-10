<div>
    <x-slot name="title">
        {{ __('Manage Users') }}
    </x-slot>
    <x-card title="Data Users" subtitle="All of the users of the application" shadow>
        {{-- filter --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 pb-4 w-full">
            <div class="flex flex-col md:items-center gap-4 md:flex-row w-full md:w-1/2 md:space-x-8">
                <div class="inline-flex">
                    <label for="paginate" class="block mr-2 text-sm font-medium text-gray-900 dark:text-white">
                        Per page
                    </label>
                    <select class="select select-bordered select-sm select-primary w-full max-w-xs" id="paginate"
                        name="paginate" wire:model.live="paginate">
                        <option disabled selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="inline-flex">
                    <label for="selectedRole"
                        class="block mr-2 text-sm font-medium text-gray-900 dark:text-white">FilterBy
                        Role</label>
                    <select class="select select-bordered select-sm select-primary w-full max-w-xs" id="selectedRole"
                        name="selectedRole" wire:model.live="selectedRole">
                        <option value="">Semua Roles</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex flex-col md:justify-end md:items-center gap-4 md:flex-row w-full md:w-1/2 md:space-x-8">
                <div class="inline-flex">
                    <label for="search"
                        class="block md:hidden mr-2 text-sm font-medium text-gray-900 dark:text-white">
                        Search by
                    </label>
                    <x-input class="w-full" class="input-sm" id="search" wire:model.live.debounce.500ms="search"
                        placeholder="Search for items by name, email and role..." icon="o-magnifying-glass" />
                </div>
            </div>
        </div>
        {{-- end filter --}}

        {{-- selected data  --}}
        <div class="flex w-full items-center justify-between">
            <div class="text-sm text-gray-800">
                @if ($selectPage)
                    <div class="mb-4">
                        @if ($selectAll)
                            <div>
                                You have selected all <strong>{{ $users->total() }}</strong> items.
                                <a href="#" class="underline text-primary ml-2"
                                    wire:click.prevent="unselectAll">Batalkan
                                    Semua</a>
                            </div>
                        @else
                            <div>
                                You have selected <strong>{{ count($checked) }}</strong> items, Do you want to
                                Select
                                All
                                <strong>{{ $users->total() }}</strong>?
                                <a href="#" class="underline text-primary ml-2"
                                    wire:click.prevent="selectAll">Pilih
                                    Semua</a>
                            </div>
                        @endif

                    </div>
                @endif
            </div>
            <div>
                @if ($checked)
                    <x-dropdown label="With Checked ({{ count($checked) }})" class="btn-ghost">
                        <div class="w-36">
                            <x-menu-item title="Delete"
                                onclick="confirm('Are you sure you want to delete these Records?') || event.stopImmediatePropagation()"
                                wire:click.prevent="deleteRecords()" />
                            <x-menu-item title="Export"
                                onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()"
                                wire:click.prevent="exportSelected()" />
                        </div>
                    </x-dropdown>
                @endif
            </div>
        </div>
        {{-- end selected data  --}}

        <div class="overflow-x-auto">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th><input type="checkbox" class="checkbox" wire:model.live="selectPage"></th>
                        <th>
                            Pengguna
                            <span wire:click="sortBy('name')" class="cursor-pointer">
                                <x-icon
                                    name="{{ $sortColumnName === 'name' && $sortDirection === 'asc' ? 'o-bars-arrow-up' : 'o-bars-arrow-down' }}"
                                    class="w-4 h-4 " />
                            </span>
                        </th>
                        <th>
                            Terdaftar pada
                            <span wire:click="sortBy('created_at')" class="cursor-pointer">
                                <x-icon
                                    name="{{ $sortColumnName === 'created_at' && $sortDirection === 'asc' ? 'o-bars-arrow-up' : 'o-bars-arrow-down' }}"
                                    class="w-4 h-4" />
                            </span>
                        </th>
                        <th>
                            Role
                        </th>
                        <th>
                            <x-button label="Tambah Data" class="btn-success btn-sm"
                                wire:click="$dispatch('openModal',{ component: 'pages.users.form-user'} )" />
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $item)
                        <tr>
                            <th>
                                <label>
                                    <input type="checkbox" class="checkbox" value="{{ $item->id }}"
                                        wire:model.live="checked" />
                                </label>
                            </th>
                            <td>
                                <div class="flex items-center space-x-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle w-12 h-12">
                                            <img src="https://www.gravatar.com/avatar/{{ md5($item->email) }}?d=mp"
                                                alt="{{ $item->name }}" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $item->name }}</div>
                                        <div class="text-sm opacity-50">{{ $item->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $item->created_at->diffForHumans() }}
                            </td>
                            <td>
                                @foreach ($item->roles as $role)
                                    <span class="badge badge-ghost badge-sm">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <x-button icon="o-eye" class="btn-square btn-sm md:btn-md"
                                        wire:click="$dispatch('openModal', { component: 'pages.users.form-user', arguments: { user: '{{ $item->id }}' }})" />
                                    <x-button icon="o-pencil-square" class="btn-square btn-sm md:btn-md" />
                                    <x-button icon="o-trash" class="btn-square btn-error btn-sm md:btn-md" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="flex flex-col items-center justify-center">
                                    <img src="{{ asset('img/empty.png') }}" class="h-52 w-auto" alt="Empty Data">
                                    <p>Aplikasi belum memiliki users.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pt-4">
            {!! $users->links() !!}
        </div>
    </x-card>
</div>
