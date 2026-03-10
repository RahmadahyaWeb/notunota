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

            <div class="flex justify-end border-t pt-6">
                <flux:button variant="primary" type="submit">
                    Simpan Pengaturan
                </flux:button>
            </div>

        </form>
    </flux:card>
</div>
