<div class="space-y-8">

    {{-- HEADER --}}
    <div>
        <flux:heading size="xl" level="1">
            {{ $greeting }}, {{ auth()->user()->name }}
        </flux:heading>

        <flux:text class="mt-2 text-zinc-500">
            Berikut informasi terbaru untuk bisnis Anda hari ini
        </flux:text>
    </div>

    {{-- KEY METRICS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <flux:card class="space-y-1">
            <flux:text size="sm" class="text-zinc-500">
                Total Invoice
            </flux:text>
            <flux:heading size="lg">
                {{ $total_invoice }}
            </flux:heading>
        </flux:card>

        <flux:card class="space-y-1">
            <flux:text size="sm" class="text-zinc-500">
                Sudah Dibayar
            </flux:text>
            <flux:heading size="lg">
                {{ $paid_invoice }}
            </flux:heading>
        </flux:card>

        <flux:card class="space-y-1">
            <flux:text size="sm" class="text-zinc-500">
                Belum Dibayar
            </flux:text>
            <flux:heading size="lg">
                {{ $unpaid_invoice }}
            </flux:heading>
        </flux:card>

        <flux:card class="space-y-1">
            <flux:text size="sm" class="text-zinc-500">
                Pendapatan Bulan Ini
            </flux:text>
            <flux:heading size="lg">
                Rp {{ number_format($revenue_month, 0, ',', '.') }}
            </flux:heading>
        </flux:card>

    </div>

    {{-- MAIN GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- REVENUE CHART --}}
        <flux:card class="lg:col-span-2">
            <flux:heading size="md">
                Grafik Pendapatan
            </flux:heading>
            <flux:text size="sm" class="text-zinc-500 mb-4">
                30 hari terakhir
            </flux:text>

            <div class="h-56 rounded-lg bg-zinc-100 flex items-center justify-center text-sm text-zinc-500">
                Area Grafik
            </div>
        </flux:card>

        {{-- QUICK ACTIONS --}}
        <flux:card class="space-y-4">
            <flux:heading size="md">
                Aksi Cepat
            </flux:heading>
            <div class="grid gap-2">
                <flux:button variant="primary">Buat Invoice</flux:button>
                <flux:button>Tambah Klien</flux:button>
                <flux:button>Tambah Produk</flux:button>
                <flux:button>Lihat Laporan</flux:button>
            </div>
        </flux:card>

    </div>

    {{-- BOTTOM GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- RECENT ACTIVITY --}}
        <flux:card>
            <flux:heading size="md">
                Aktivitas Terbaru
            </flux:heading>
            <div class="mt-4 space-y-3 text-sm">
                @forelse ($recent_invoices as $invoice)
                    <div class="flex justify-between">
                        <span>Invoice {{ $invoice->invoice_number }} dibuat</span>
                        <span class="text-zinc-500">{{ $invoice->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-sm text-zinc-500">
                        Belum ada aktivitas terbaru
                    </div>
                @endforelse
            </div>
        </flux:card>

        {{-- DUE INVOICES --}}
        <flux:card>
            <flux:heading size="md">
                Invoice Mendekati Jatuh Tempo
            </flux:heading>
            <div class="mt-4 space-y-3 text-sm">
                @forelse ($due_invoices as $invoice)
                    <div class="flex justify-between">
                        <span>{{ $invoice->invoice_number }} • {{ $invoice->client->name ?? '-' }}</span>
                        <span
                            class="text-red-500">{{ \Carbon\Carbon::parse($invoice->due_date)->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-sm text-zinc-500">
                        Tidak ada invoice yang akan jatuh tempo
                    </div>
                @endforelse
            </div>
        </flux:card>

    </div>

</div>
