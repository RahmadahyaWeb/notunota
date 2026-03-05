<div class="mx-auto space-y-10">

    {{-- ========================= --}}
    {{-- FORM PEMBUATAN INVOICE --}}
    {{-- ========================= --}}
    <flux:card>
        <div class="space-y-6">

            <div>
                <h2 class="text-xl font-semibold">Buat Invoice Baru</h2>
                <p class="text-sm text-gray-500">
                    Lengkapi informasi di bawah ini untuk membuat invoice.
                </p>
            </div>

            {{-- Informasi Customer --}}
            <div class="space-y-4">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                    Informasi Pelanggan
                </h3>

                <flux:select wire:model.change.live="customer_id" label="Pilih Pelanggan"
                    description="Pilih pelanggan yang akan menerima invoice ini.">
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </flux:select>
            </div>

            {{-- Tanggal --}}
            <div class="space-y-4">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                    Tanggal Invoice
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input type="date" wire:model="invoice_date" label="Tanggal Invoice"
                        description="Tanggal invoice dibuat." />

                    <flux:input type="date" wire:model="due_date" label="Tanggal Jatuh Tempo"
                        description="Batas akhir pembayaran." />
                </div>
            </div>

            {{-- Item Produk --}}
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                        Daftar Produk / Layanan
                    </h3>

                    <flux:button wire:click="add_item" size="sm">
                        + Tambah Item
                    </flux:button>
                </div>

                <p class="text-xs text-gray-500">
                    Tambahkan produk atau layanan yang akan ditagihkan.
                </p>

                <div class="space-y-4">
                    @foreach ($items as $index => $item)
                        <div class="border rounded-lg p-4 space-y-4 bg-gray-50">

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">

                                <div class="md:col-span-5">
                                    <flux:select wire:model.change.live="items.{{ $index }}.product_id"
                                        label="Produk / Layanan">
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </flux:select>
                                </div>

                                <div class="md:col-span-2">
                                    <flux:input type="number" wire:model.live="items.{{ $index }}.qty"
                                        label="Jumlah" min="1" />
                                </div>

                                <div class="md:col-span-4">
                                    <flux:input type="number" wire:model="items.{{ $index }}.price"
                                        label="Harga Satuan (Rp)" min="0" />
                                </div>

                                <div class="md:col-span-1 flex items-end">
                                    <flux:button wire:click="remove_item({{ $index }})" variant="danger"
                                        class="w-full">
                                        ✕
                                    </flux:button>
                                </div>

                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Total --}}
            <div class="border-t pt-6">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    {{-- Total --}}
                    <div>
                        <div class="text-sm text-gray-500">
                            Total Tagihan
                        </div>
                        <div class="text-2xl font-bold text-primary">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </div>
                    </div>

                    {{-- Button --}}
                    <div class="w-full sm:w-auto">
                        <flux:button wire:click="save" variant="primary" class="w-full sm:w-auto">
                            Simpan & Terbitkan Invoice
                        </flux:button>
                    </div>

                </div>

            </div>
        </div>
    </flux:card>

    <div x-data="invoicePreview()" x-init="fitToScreen()" class="space-y-6">

        {{-- Header --}}
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

                {{-- Sisi Kiri: Informasi & Judul --}}
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg hidden sm:block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Preview Invoice</h2>
                        <p class="text-sm text-gray-500 font-medium">Atur skala tampilan dokumen</p>
                    </div>
                </div>

                {{-- Sisi Kanan: Kontrol (Zoom & Fit) --}}
                <div class="flex flex-wrap items-center gap-4 bg-gray-50 p-2 sm:p-3 rounded-2xl border border-gray-100">

                    {{-- Tombol Fit to Screen dengan Icon --}}
                    <button @click="fitToScreen()"
                        class="flex items-center gap-2 px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded-xl border border-gray-200 shadow-sm hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                        </svg>
                        <span>Fit</span>
                    </button>

                    <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>

                    {{-- Slider Zoom yang Lebih Manis --}}
                    <div class="flex items-center gap-4 flex-1 sm:flex-none min-w-[160px]">
                        <span class="text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7" />
                            </svg>
                        </span>

                        <input type="range" min="0.1" max="1.5" step="0.01" x-model="zoom"
                            class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">

                        <span class="text-sm font-bold text-indigo-600 tabular-nums w-12 text-right"
                            x-text="Math.round(zoom * 100) + '%'"></span>
                    </div>
                </div>

            </div>
        </div>

        {{-- Wrapper Abu-abu: Sekarang tingginya dinamis --}}
        <div x-ref="container"
            class="bg-gray-100 p-4 sm:p-8 rounded-xl overflow-hidden flex justify-center border border-gray-200 duration-300"
            :style="`height: auto; min-height: ${(baseHeight * zoom) + 64}px;`">
            {{-- Sizing Container: Mengunci dimensi layout agar tidak ada whitespace --}}
            <div class="relative shadow-2xl" :style="`width: ${baseWidth * zoom}px; height: ${baseHeight * zoom}px;`">
                {{-- Scaled Element --}}
                <div class="absolute left-0 top-0 origin-top-left bg-white"
                    :style="`transform: scale(${zoom}); width: ${baseWidth}px; height: ${baseHeight}px;`">
                    @includeIf('invoices.templates.' . $template, ['data' => $this->previewData])
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function invoicePreview() {
                return {
                    zoom: 0.7,
                    baseWidth: 800,
                    baseHeight: 1132, // Sesuaikan dengan tinggi asli template Anda

                    fitToScreen() {
                        const containerWidth = this.$refs.container.clientWidth - 64;
                        const ratio = containerWidth / this.baseWidth;
                        this.zoom = ratio > 1 ? 1 : ratio.toFixed(2);
                    }
                }
            }
        </script>
    @endpush

</div>
