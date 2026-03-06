<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <flux:heading size="xl" level="1">Daftar Pelanggan</flux:heading>
            <flux:text class="mt-1">Kelola informasi pelanggan dan riwayat transaksi Anda.</flux:text>
        </div>

        <div class="flex items-center">
            <flux:modal.trigger name="add-customer">
                <flux:button variant="primary" icon="plus" wire:click="resetForm" class="w-full sm:w-auto">
                    Tambah Pelanggan
                </flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 mb-8">
        {{-- Total Terbayar --}}
        <flux:card class="space-y-2">
            <flux:text size="sm" class="text-zinc-500">Total Pelanggan</flux:text>
            <flux:heading size="lg">
                {{ number_format($this->stats['total'], 0, ',', '.') }}
            </flux:heading>
        </flux:card>

    </div>

    <flux:card>
        <flux:table :paginate="$this->customers">
            <flux:table.columns>
                <flux:table.column>Kode Pelanggan</flux:table.column>
                <flux:table.column>Nama Pelanggan</flux:table.column>
                <flux:table.column>Email</flux:table.column>
                <flux:table.column>Telepon</flux:table.column>
                <flux:table.column>Alamat</flux:table.column>
                <flux:table.column />
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->customers as $customer)
                    <flux:table.row wire:key="customer-{{ $customer->id }}">
                        <flux:table.cell>{{ $customer->code }}</flux:table.cell>
                        <flux:table.cell>{{ $customer->name }}</flux:table.cell>
                        <flux:table.cell>{{ $customer->email }}</flux:table.cell>
                        <flux:table.cell>{{ $customer->phone }}</flux:table.cell>
                        <flux:table.cell>{{ $customer->address }}</flux:table.cell>
                        <flux:table.cell class="text-right">
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />
                                <flux:menu>
                                    <flux:menu.item icon="pencil-square" wire:click="edit({{ $customer->id }})">
                                        Edit
                                    </flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item variant="danger" icon="trash"
                                        wire:click="confirmDelete({{ $customer->id }})">
                                        Hapus
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="6" class="text-center text-zinc-500">
                            Tidak ada pelanggan yang ditemukan.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <flux:modal name="add-customer" class="md:w-96" @close="resetForm()" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">
                    {{ $customer_id ? 'Edit Pelanggan' : 'Tambah Pelanggan' }}
                </flux:heading>

                <flux:text class="mt-2">
                    {{ $customer_id ? 'Perbarui informasi pelanggan.' : 'Isi formulir di bawah untuk menambahkan pelanggan baru.' }}
                </flux:text>
            </div>

            <form wire:submit="save" class="space-y-6">
                <flux:field>
                    <flux:label>Kode Pelanggan</flux:label>
                    <flux:input wire:model="code" placeholder="Masukkan kode pelanggan" required />
                </flux:field>

                <flux:field>
                    <flux:label>Nama Pelanggan</flux:label>
                    <flux:input wire:model="name" placeholder="Masukkan nama pelanggan" required />
                </flux:field>

                <flux:field>
                    <flux:label>Email</flux:label>
                    <flux:input wire:model="email" type="email" placeholder="Masukkan email pelanggan" />
                </flux:field>

                <flux:field>
                    <flux:label>Telepon</flux:label>
                    <flux:input wire:model="phone" placeholder="Masukkan nomor telepon pelanggan" />
                </flux:field>

                <flux:field>
                    <flux:label>Alamat</flux:label>
                    <flux:textarea wire:model="address" placeholder="Masukkan alamat pelanggan" />
                </flux:field>

                <div class="flex justify-end">
                    <flux:button variant="primary" type="submit">Simpan</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <flux:modal name="delete-customer" class="min-w-88">
        <div class="space-y-6">

            <div>
                <flux:heading size="lg">Hapus Pelanggan?</flux:heading>

                <flux:text class="mt-2">
                    Anda akan menghapus data pelanggan ini.<br>
                    Tindakan ini tidak dapat dibatalkan.
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">
                        Batal
                    </flux:button>
                </flux:modal.close>

                <flux:button wire:click="delete" variant="danger">
                    Hapus Pelanggan
                </flux:button>

            </div>
        </div>
    </flux:modal>
</div>
