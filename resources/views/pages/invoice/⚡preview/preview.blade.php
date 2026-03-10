<div>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8 space-y-6">
            <div wire:key="preview-{{ $template }}" x-data="invoicePreview()" class="space-y-6">

                {{-- Header --}}
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm mb-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

                        {{-- Sisi Kiri: Informasi & Judul --}}
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg hidden sm:block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
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
                        <div
                            class="flex flex-wrap items-center gap-4 bg-gray-50 p-2 sm:p-3 rounded-2xl border border-gray-100">

                            {{-- Tombol Fit to Screen dengan Icon --}}
                            <button @click="fitToScreen()"
                                class="flex items-center gap-2 px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded-xl border border-gray-200 shadow-sm hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                </svg>
                                <span>Fit</span>
                            </button>

                            <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>

                            {{-- Slider Zoom yang Lebih Manis --}}
                            <div class="flex items-center gap-4 flex-1 sm:flex-none min-w-[160px]">
                                <span class="text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
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

                {{-- Wrapper Preview --}}
                <div x-ref="container" class="bg-gray-100 p-4 sm:p-8 rounded-xl border border-gray-200 overflow-auto">
                    <div class="flex justify-center min-w-max">
                        <div class="relative shadow-2xl"
                            :style="`width: ${baseWidth * zoom}px; height: ${baseHeight * zoom}px;`">
                            <div class="absolute left-0 top-0 origin-top-left bg-white"
                                :style="`transform: scale(${zoom}); width: ${baseWidth}px; height: ${baseHeight}px;`">
                                @includeIf('invoices.templates.' . $template, ['data' => $this->data])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Kanan: Ringkasan Invoice --}}
        <div class="lg:col-span-4 space-y-6">

            <flux:card class="space-y-5">

                {{-- Header --}}
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Ringkasan Invoice</h3>

                {{-- Nomor Invoice --}}
                <div class="flex justify-between items-center text-sm text-gray-500">
                    <span>Nomor Invoice</span>
                    <span
                        class="font-medium text-gray-800 dark:text-gray-200">{{ $data['invoice_number'] ?? '-' }}</span>
                </div>

                {{-- Status --}}
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Status</span>
                    <span
                        class="px-2 py-1 rounded text-white text-xs font-semibold 
                {{ $data['status'] == 'paid' ? 'bg-green-500' : ($data['status'] == 'pending' ? 'bg-yellow-500' : 'bg-orange-500') }}">
                        {{ ucfirst($data['status'] ?? 'Draft') }}
                    </span>
                </div>

                <hr class="border-gray-200 dark:border-gray-700">

                {{-- Total Tagihan --}}
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500">Total Tagihan</span>
                    <span class="text-indigo-600 dark:text-indigo-400 font-bold text-lg">
                        Rp {{ number_format($data['total'] ?? 0, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Rekening Pembayaran --}}
                <div class="space-y-4 text-sm">
                    <span class="text-gray-500">Rekening Pembayaran</span>
                    <div class="relative">
                        <input id="rekeningInput" type="text" readonly
                            value="{{ $data['business']->bank_account_number ?? 'FLUX-1234-5678-ABCD-EFGH' }}"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 pr-16 text-gray-800 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 focus:outline-none">

                        <button onclick="copyRekening()"
                            class="absolute right-1 top-1/2 -translate-y-1/2 bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-xs">
                            Copy
                        </button>
                    </div>
                    <p id="copyMsg" class="text-green-500 text-xs mt-1 hidden">Berhasil disalin!</p>
                </div>

            </flux:card>

            {{-- <flux:card class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <flux:button variant="outline" icon="printer" class="w-full">Cetak</flux:button>
                    <flux:button variant="outline" icon="arrow-down-tray" class="w-full">Unduh PDF</flux:button>
                </div>
            </flux:card> --}}

            @if ($data['status'] == 'draft')
                <flux:button variant="primary" icon="paper-airplane" class="w-full">Kirim Invoice</flux:button>
            @endif

            <flux:button icon="document-duplicate" variant="primary" class="w-full" onclick="copyInvoiceLink()">
                Bagikan Invoice
            </flux:button>

            <p id="shareMsg" class="text-green-600 text-xs text-center hidden">
                Link invoice berhasil disalin
            </p>

        </div>


    </div>

    @push('scripts')
        <script>
            function copyRekening() {
                const input = document.getElementById('rekeningInput');
                input.select();
                input.setSelectionRange(0, 99999); // For mobile devices
                navigator.clipboard.writeText(input.value).then(() => {
                    const msg = document.getElementById('copyMsg');
                    msg.classList.remove('hidden');
                    setTimeout(() => msg.classList.add('hidden'), 2000);
                });
            }
        </script>

        <script>
            function invoicePreview() {
                return {
                    zoom: 0.7,
                    // Inisialisasi awal
                    baseWidth: 800, // Default untuk A4
                    baseHeight: 1132,

                    init() {
                        // Memantau perubahan template dari Livewire secara langsung
                        this.$watch('$wire.template', (value) => {
                            this.updateDimensions(value);
                        });

                        // window.addEventListener('resize', () => {
                        //     this.fitToScreen()
                        // });


                        // Jalankan fitToScreen setelah inisialisasi
                        this.$nextTick(() => this.fitToScreen());
                    },

                    updateDimensions(template) {
                        this.baseWidth = 800; // A4
                        this.baseHeight = 1132;

                        this.fitToScreen();
                    },

                    fitToScreen() {
                        // Beri sedikit delay agar DOM selesai merender perubahan template
                        this.$nextTick(() => {
                            const containerWidth = this.$refs.container.clientWidth - 64;
                            const ratio = containerWidth / this.baseWidth;
                            this.zoom = ratio > 1 ? 1 : parseFloat(ratio.toFixed(2));
                        });
                    }
                }
            }
        </script>

        <script>
            function copyInvoiceLink() {
                const link = "{{ route('invoice.preview', $data['public_token'] ?? 'preview') }}";

                navigator.clipboard.writeText(link).then(() => {
                    const msg = document.getElementById('shareMsg');
                    msg.classList.remove('hidden');

                    setTimeout(() => {
                        msg.classList.add('hidden');
                    }, 2000);
                });
            }
        </script>
    @endpush
</div>
