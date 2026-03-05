<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <flux:heading size="xl" level="1">Daftar Invoice</flux:heading>
            <flux:text class="mt-1">Kelola penagihan dan pantau status pembayaran Anda.</flux:text>
        </div>

        <div class="flex items-center">
            <flux:button variant="primary" icon="plus" class="w-full sm:w-auto" href="{{ route('invoice.create') }}">
                Buat Invoice
            </flux:button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 mb-8">
        {{-- Total Terbayar --}}
        <flux:card class="space-y-2">
            <flux:text size="sm" class="text-zinc-500">Uang Masuk</flux:text>
            <flux:heading size="lg">
                Rp {{ number_format($this->stats['paid'], 0, ',', '.') }}
            </flux:heading>
        </flux:card>

        {{-- Menunggu Pembayaran --}}
        <flux:card class="space-y-2">
            <flux:text size="sm" class="text-zinc-500">Menunggu Pelunasan</flux:text>
            <flux:heading size="lg" class="text-yellow-600">
                Rp {{ number_format($this->stats['pending'], 0, ',', '.') }}
            </flux:heading>
        </flux:card>

        {{-- Overdue --}}
        <flux:card class="space-y-2 border-red-200 bg-red-50/30">
            <flux:text size="sm" class="text-red-600">Perlu Ditagih</flux:text>
            <flux:heading size="lg" class="text-red-700">
                Rp {{ number_format($this->stats['overdue'], 0, ',', '.') }}
            </flux:heading>
        </flux:card>
    </div>

    <flux:card>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div class="flex-1 max-w-sm">
                <flux:input icon="magnifying-glass" placeholder="Cari nomor invoice atau pelanggan..." />
            </div>

            <div class="flex gap-2">
                {{-- .live memastikan tabel langsung update saat opsi dipilih --}}
                <flux:select wire:model.live="status" placeholder="Pilih Status">
                    <flux:select.option value="">Semua Status</flux:select.option>
                    <flux:select.option value="draft">Draft</flux:select.option>
                    <flux:select.option value="sent">Sent</flux:select.option>
                    <flux:select.option value="paid">Paid</flux:select.option>
                    <flux:select.option value="overdue">Overdue</flux:select.option>
                </flux:select>

                {{-- Tombol filter bisa digunakan untuk fungsi lain (seperti reset) --}}
                @if ($status)
                    <flux:button wire:click="$set('status', '')" variant="subtle" icon="x-mark">
                        Reset
                    </flux:button>
                @endif
            </div>
        </div>

        <flux:table :paginate="$this->invoices">
            <flux:table.columns>
                <flux:table.column>Nomor Invoice</flux:table.column>
                <flux:table.column>Pelanggan</flux:table.column>
                <flux:table.column>Tanggal</flux:table.column>
                <flux:table.column>Jatuh Tempo</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column align="end">Total</flux:table.column>
                <flux:table.column />
            </flux:table.columns>

            <flux:table.rows>
                {{-- Loop data di sini --}}
                @forelse ($this->invoices as $invoice)
                    <flux:table.row>
                        <flux:table.cell class="font-medium text-zinc-900">#{{ $invoice->invoice_number }}
                        </flux:table.cell>
                        <flux:table.cell>{{ $invoice->customer->name }}</flux:table.cell>
                        <flux:table.cell>{{ date('d-m-Y', strtotime($invoice->invoice_date)) }}</flux:table.cell>
                        <flux:table.cell>{{ date('d-m-Y', strtotime($invoice->due_date)) }}</flux:table.cell>
                        <flux:table.cell>
                            {{ $invoice->status }}
                        </flux:table.cell>
                        <flux:table.cell align="end" class="font-mono">Rp
                            {{ number_format($invoice->total, 0, ',', '.') }}</flux:table.cell>
                        <flux:table.cell align="end">
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />
                                <flux:menu>
                                    <flux:menu.item icon="eye"
                                        href="{{ route('invoice.preview', $invoice->public_token) }}" target="_blank">
                                        Preview
                                    </flux:menu.item>
                                    <flux:menu.item icon="pencil-square">Edit</flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item variant="danger" icon="trash">Hapus</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>

                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="7" class="text-center text-zinc-500">
                            Tidak ada invoice yang ditemukan.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
                {{-- End Loop --}}
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
