<x-layouts::app.header :title="$title ?? null">
    <flux:main container>
        <livewire:notification-modal />

        {{ $slot }}
    </flux:main>
</x-layouts::app.header>
