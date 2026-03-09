<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <flux:heading size="xl" level="1">Pengaturan Toko</flux:heading>
            <flux:text class="mt-1">Kelola informasi toko yang akan muncul pada invoice.</flux:text>
        </div>
    </div>

    <flux:card class="mt-6">
        <form wire:submit="save" class="space-y-8">

            {{-- ========================= --}}
            {{-- INFORMASI TOKO --}}
            {{-- ========================= --}}
            <div class="space-y-4">
                <div>
                    <flux:heading size="lg">Informasi Toko</flux:heading>
                    <flux:text class="mt-1 text-sm">
                        Informasi ini akan ditampilkan pada bagian header invoice.
                    </flux:text>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label>Nama Toko</flux:label>
                        <flux:input wire:model="name" placeholder="Contoh: Toko Maju Jaya" required />
                    </flux:field>

                    <flux:field>
                        <flux:label>Telepon</flux:label>
                        <flux:input wire:model="phone" placeholder="Contoh: 0812xxxxxxx" required />
                    </flux:field>
                </div>

                <flux:field>
                    <flux:label>Alamat Toko</flux:label>
                    <flux:input wire:model="address" placeholder="Masukkan alamat lengkap toko" required />
                </flux:field>
            </div>


            {{-- ========================= --}}
            {{-- INFORMASI BANK --}}
            {{-- ========================= --}}
            <div class="space-y-4 border-t pt-6">
                <div>
                    <flux:heading size="lg">Informasi Pembayaran</flux:heading>
                    <flux:text class="mt-1 text-sm">
                        Informasi rekening untuk pembayaran invoice.
                    </flux:text>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <flux:field>
                        <flux:label>Nama Bank</flux:label>
                        <flux:input wire:model="bank_name" placeholder="Contoh: BCA / BRI / Mandiri" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Nomor Rekening</flux:label>
                        <flux:input wire:model="bank_account_number" placeholder="Contoh: 1234567890" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Nama Pemilik Rekening</flux:label>
                        <flux:input wire:model="bank_account_name" placeholder="Contoh: Ahmad Fauzi" />
                    </flux:field>
                </div>
            </div>


            {{-- ========================= --}}
            {{-- PENGATURAN INVOICE --}}
            {{-- ========================= --}}
            <div class="space-y-4 border-t pt-6">
                <div>
                    <flux:heading size="lg">Pengaturan Invoice</flux:heading>
                    <flux:text class="mt-1 text-sm">
                        Prefix akan digunakan pada nomor faktur otomatis.
                    </flux:text>
                </div>

                <div class="max-w-xs">
                    <flux:field>
                        <flux:label>Prefix Faktur</flux:label>
                        <flux:input wire:model="invoice_prefix" placeholder="Contoh: INV" />
                    </flux:field>
                </div>
            </div>

            {{-- ========================= --}}
            {{-- PENGATURAN WHATSAPP --}}
            {{-- ========================= --}}
            <div class="space-y-4 border-t pt-6">
                <div>
                    <flux:heading size="lg">Integrasi WA</flux:heading>
                    <flux:text class="mt-1 text-sm">
                        WA akan digunakan untuk mengirim invoice ke pelanggan melalui WhatsApp. Pastikan nomor yang
                        digunakan sudah terdaftar di WhatsApp.
                    </flux:text>
                </div>

                <div class="max-w-2xl space-y-8">
                    {{-- Header & Penjelasan Singkat --}}
                    <div class="space-y-2">
                        <flux:heading level="2">Konfigurasi WhatsApp Gateway</flux:heading>
                        <flux:subheading>
                            Notunota menggunakan layanan <strong>Fonnte</strong> sebagai perantara agar pengiriman
                            invoice lebih reliabel dan real-time.
                        </flux:subheading>
                    </div>

                    {{-- Pemilihan Metode --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Opsi 1: Notunota Token --}}
                        <button type="button" wire:click="$set('use_notunota_token', '1')"
                            class="group relative p-5 text-left rounded-xl border-2 transition-all duration-200 
            {{ $use_notunota_token == '1'
                ? 'border-primary-500 bg-primary-50/50 ring-1 ring-primary-500'
                : 'border-zinc-200 hover:border-zinc-300 bg-white dark:bg-zinc-900' }}">

                            {{-- Checkmark Indicator --}}
                            <div
                                class="absolute top-3 right-3 transition-opacity {{ $use_notunota_token == '1' ? 'opacity-100' : 'opacity-0' }}">
                                <div class="bg-primary-500 rounded-full p-1">
                                    <flux:icon name="check" variant="micro" class="text-white" />
                                </div>
                            </div>

                            <div class="flex flex-col h-full">
                                <flux:icon variant="outline" name="sparkles"
                                    class="{{ $use_notunota_token == '1' ? 'text-primary-600' : 'text-zinc-400' }}" />

                                <div class="mt-3">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="font-bold {{ $use_notunota_token == '1' ? 'text-primary-900' : 'text-zinc-900' }}">Token
                                            Notunota</span>
                                        @if ($use_notunota_token == '1')
                                            <flux:badge color="primary" size="sm" inset="top bottom">Aktif
                                            </flux:badge>
                                        @endif
                                    </div>
                                    <div class="text-xs text-zinc-500 mt-1">Siap pakai tanpa setup. Kami yang mengelola
                                        teknisnya untuk Anda.</div>
                                </div>
                            </div>
                        </button>

                        {{-- Opsi 2: Personal Token --}}
                        <button type="button" wire:click="$set('use_notunota_token', '0')"
                            class="group relative p-5 text-left rounded-xl border-2 transition-all duration-200
            {{ $use_notunota_token == '0'
                ? 'border-primary-500 bg-primary-50/50 ring-1 ring-primary-500'
                : 'border-zinc-200 hover:border-zinc-300 bg-white dark:bg-zinc-900' }}">

                            {{-- Checkmark Indicator --}}
                            <div
                                class="absolute top-3 right-3 transition-opacity {{ $use_notunota_token == '0' ? 'opacity-100' : 'opacity-0' }}">
                                <div class="bg-primary-500 rounded-full p-1">
                                    <flux:icon name="check" variant="micro" class="text-white" />
                                </div>
                            </div>

                            <div class="flex flex-col h-full">
                                <flux:icon variant="outline" name="device-phone-mobile"
                                    class="{{ $use_notunota_token == '0' ? 'text-primary-600' : 'text-zinc-400' }}" />

                                <div class="mt-3">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="font-bold {{ $use_notunota_token == '0' ? 'text-primary-900' : 'text-zinc-900' }}">Token
                                            Personal</span>
                                        @if ($use_notunota_token == '0')
                                            <flux:badge color="primary" size="sm" inset="top bottom">Aktif
                                            </flux:badge>
                                        @endif
                                    </div>
                                    <div class="text-xs text-zinc-500 mt-1">Gunakan nomor WA sendiri melalui API Fonnte
                                        Anda.</div>
                                </div>
                            </div>
                        </button>
                    </div>

                    {{-- Konten Dinamis untuk Token Pribadi --}}
                    @if ($use_notunota_token == '0')
                        <div class="space-y-6 animate-in fade-in slide-in-from-top-4 duration-300">
                            <div
                                class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 shadow-sm space-y-4">
                                <flux:field>
                                    <flux:label icon="key">Fonnte API Token</flux:label>
                                    <flux:input wire:model="wa_device_id" placeholder="Paste token Anda di sini..."
                                        class="font-mono text-sm" />
                                    <flux:description>Token ini bersifat rahasia dan digunakan untuk menghubungkan
                                        sistem ke akun Fonnte Anda.</flux:description>
                                </flux:field>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Step 1 --}}
                                <div class="space-y-3">
                                    <div
                                        class="flex items-center gap-2 font-medium text-sm text-zinc-800 dark:text-zinc-200">
                                        Hubungkan Perangkat
                                    </div>
                                    <a href="https://youtu.be/aNSCRlJ51fI" target="_blank"
                                        class="block group relative aspect-video rounded-lg overflow-hidden border border-zinc-200">
                                        <img src="https://img.youtube.com/vi/aNSCRlJ51fI/mqdefault.jpg"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                        <div
                                            class="absolute inset-0 bg-black/20 group-hover:bg-black/40 flex items-center justify-center transition-colors">
                                            <flux:button size="sm" variant="filled" class="pointer-events-none"
                                                icon="play">Video Tutorial</flux:button>
                                        </div>
                                    </a>
                                </div>

                                {{-- Step 2 --}}
                                <div class="space-y-3">
                                    <div
                                        class="flex items-center gap-2 font-medium text-sm text-zinc-800 dark:text-zinc-200">
                                        Ambil API Token
                                    </div>
                                    <a href="https://youtu.be/pivL1U-7OLw" target="_blank"
                                        class="block group relative aspect-video rounded-lg overflow-hidden border border-zinc-200">
                                        <img src="https://img.youtube.com/vi/pivL1U-7OLw/mqdefault.jpg"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                        <div
                                            class="absolute inset-0 bg-black/20 group-hover:bg-black/40 flex items-center justify-center transition-colors">
                                            <flux:button size="sm" variant="filled" class="pointer-events-none"
                                                icon="play">Video Tutorial</flux:button>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            <div class="flex justify-end border-t pt-6">
                <flux:button variant="primary" type="submit">
                    Simpan Pengaturan
                </flux:button>
            </div>

        </form>
    </flux:card>
</div>
