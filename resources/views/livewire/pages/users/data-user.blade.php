<x-card title="Card Title" subtitle="Card subtitle" shadow>
    <x-form wire:submit="save">
        <x-input label="Name" wire:model="name" />
        <x-input label="Name" wire:model="name" />
        <x-input label="Name" wire:model="name" />
        <x-slot:actions>
            <x-button label="Cancel" />
            <x-button label="Click me!" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</x-card>
