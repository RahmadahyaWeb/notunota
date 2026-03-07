<div class="p-4 text-[12px] font-mono text-black w-full h-full flex flex-col">

    {{-- HEADER --}}
    <div class="text-center space-y-1">

        <div class="font-bold text-sm">
            {{ $data['business']->name ?? 'BUSINESS NAME' }}
        </div>

        @if ($data['business']->address ?? null)
            <div class="text-[11px]">
                {{ $data['business']->address }}
            </div>
        @endif

        @if ($data['business']->phone ?? null)
            <div class="text-[11px]">
                {{ $data['business']->phone }}
            </div>
        @endif

    </div>

    <div class="border-t border-dashed my-2"></div>

    {{-- INFO INVOICE --}}
    <div class="space-y-1 text-[11px]">

        <div class="flex justify-between">
            <span>No</span>
            <span>{{ $data['invoice_number'] }}</span>
        </div>

        <div class="flex justify-between">
            <span>Tanggal</span>
            <span>{{ $data['invoice_date'] }}</span>
        </div>

        @if ($data['customer'])
            <div>
                Customer:
                {{ $data['customer']->name }}
            </div>
        @endif

    </div>

    <div class="border-t border-dashed my-2"></div>

    {{-- ITEMS --}}
    <div class="space-y-2 flex-1">

        @foreach ($data['items'] as $item)
            @php
                $name = $item['description'] ?? '-';
                $qty = $item['qty'] ?? 0;
                $price = $item['price'] ?? 0;
                $lineTotal = $qty * $price;
            @endphp

            <div>

                <div class="truncate">
                    {{ $name }}
                </div>

                <div class="flex justify-between text-[11px]">

                    <span>
                        {{ $qty }} x {{ number_format($price, 0, ',', '.') }}
                    </span>

                    <span>
                        {{ number_format($lineTotal, 0, ',', '.') }}
                    </span>

                </div>

            </div>
        @endforeach

    </div>

    <div class="border-t border-dashed my-2"></div>

    {{-- TOTAL --}}
    <div class="space-y-1 text-[12px]">

        <div class="flex justify-between">
            <span>Subtotal</span>
            <span>
                {{ number_format($data['subtotal'], 0, ',', '.') }}
            </span>
        </div>

        <div class="flex justify-between font-bold text-sm">
            <span>Total</span>
            <span>
                {{ number_format($data['total'], 0, ',', '.') }}
            </span>
        </div>

    </div>

    <div class="border-t border-dashed my-2"></div>

    {{-- FOOTER --}}
    <div class="text-center text-[11px] space-y-1">

        <div>
            Terima kasih
        </div>

        <div>
            {{ $data['business']->name ?? '' }}
        </div>

    </div>

</div>
