<x-card title="{{ $updateData ? $user->name : 'User Baru' }}"
    subtitle="{{ $updateData ? 'User detail information' : 'Tambahkan informasi user baru' }}" shadow separator>
    <x-form wire:submit="{{ $updateData ? 'update' : 'store' }}">

        <div class="flex flex-col gap-4 w-full">
            <div class="flex flex-col md:flex-row gap-4 w-full">
                <x-input placeholder="Nama Pengguna" type="text" label="Name" wire:model="name" />
                <x-input placeholder="Username Pengguna" type="text" label="Username" wire:model="username" />
            </div>

            <x-input placeholder="Alamat Surel Pengguna" type="email" label="Email" wire:model="email" />

            {{-- @if (!$updatePassword)
                <a href="#" wire:click.prevent="isUpdatePassword" class="text-error underline text-sm">Update
                    password</a>
            @endif --}}

            <x-input placeholder="Kata Sandi" type="password" label="Password" wire:model="password" />

            <x-input placeholder="Ulangi Kata Sandi" type="password" label="Confirm Password"
                wire:model="password_confirmation" />
        </div>


        <x-slot:actions>
            <x-button label="Cancel" wire:click="cancel" />
            <x-button label="{{ $updateData ? 'Update' : 'Save' }}" class="btn-primary" type="submit" />
        </x-slot:actions>
    </x-form>
</x-card>
