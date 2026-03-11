<div>
    <div class="max-w-md mx-auto py-16">

        <flux:card class="space-y-6">

            <div>
                <flux:heading size="lg">
                    Bergabung ke Bisnis
                </flux:heading>

                <flux:text class="mt-1">
                    Anda diundang sebagai
                    <b>{{ $invite->role }}</b>
                </flux:text>
            </div>

            <form wire:submit="register" class="space-y-4">

                <flux:field>
                    <flux:label>Nama</flux:label>
                    <flux:input wire:model="name" required />
                </flux:field>

                <flux:field>
                    <flux:label>Email</flux:label>
                    <flux:input type="email" wire:model="email" required />
                </flux:field>

                <flux:field>
                    <flux:label>Password</flux:label>
                    <flux:input type="password" wire:model="password" required />
                </flux:field>

                <flux:button type="submit" variant="primary" class="w-full">

                    Bergabung
                </flux:button>

            </form>

        </flux:card>

    </div>
</div>
