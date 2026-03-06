<div>
    <flux:modal name="notification" class="min-w-[24rem]">
        <div class="space-y-6">

            <div class="flex items-start gap-4">

                {{-- Icon --}}
                <div class="mt-1">

                    @if ($type === 'success')
                        <flux:icon name="check-circle" class="text-green-600 w-7 h-7" />
                    @elseif($type === 'error')
                        <flux:icon name="x-circle" class="text-red-600 w-7 h-7" />
                    @elseif($type === 'warning')
                        <flux:icon name="exclamation-triangle" class="text-yellow-600 w-7 h-7" />
                    @else
                        <flux:icon name="information-circle" class="text-blue-600 w-7 h-7" />
                    @endif

                </div>

                {{-- Content --}}
                <div class="flex-1">

                    <flux:heading size="lg">
                        {{ $title }}
                    </flux:heading>

                    <flux:text class="mt-2 text-zinc-600 leading-relaxed">
                        {{ $message }}
                    </flux:text>

                </div>

            </div>

            <div class="flex items-center gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="primary">
                        Mengerti
                    </flux:button>
                </flux:modal.close>
            </div>

        </div>
    </flux:modal>
</div>
