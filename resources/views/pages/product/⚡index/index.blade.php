<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <flux:heading size="xl" level="1">Daftar Produk</flux:heading>
            <flux:text class="mt-1">Kelola informasi produk Anda.</flux:text>
        </div>

        <div class="flex items-center">
            <flux:modal.trigger name="add-product">
                <flux:button variant="primary" icon="plus" wire:click="resetForm" class="w-full sm:w-auto">
                    Tambah Produk
                </flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 mb-8">
        {{-- Total Terbayar --}}
        <flux:card class="space-y-2">
            <flux:text size="sm" class="text-zinc-500">Total Produk</flux:text>
            <flux:heading size="lg">
                {{ number_format($this->stats['total'], 0, ',', '.') }}
            </flux:heading>
        </flux:card>
    </div>

    <flux:card>
        <flux:table :paginate="$this->products">
            <flux:table.columns>
                <flux:table.column>Kode Produk</flux:table.column>
                <flux:table.column>Nama Produk</flux:table.column>
                <flux:table.column>Harga</flux:table.column>
                <flux:table.column />
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->products as $product)
                    <flux:table.row wire:key="product-{{ $product->id }}">
                        <flux:table.cell>{{ $product->code }}</flux:table.cell>
                        <flux:table.cell>{{ $product->name }}</flux:table.cell>
                        <flux:table.cell>Rp {{ number_format($product->price, 0, ',', '.') }}</flux:table.cell>
                        <flux:table.cell class="text-right">
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />
                                <flux:menu>
                                    <flux:menu.item icon="pencil-square" wire:click="edit({{ $product->id }})">
                                        Edit
                                    </flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item variant="danger" icon="trash"
                                        wire:click="confirmDelete({{ $product->id }})">
                                        Hapus
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="6" class="text-center text-zinc-500">
                            Tidak ada produk yang ditemukan.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <flux:modal name="add-product" class="md:w-96" @close="resetForm()" :dismissible="false">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">
                    {{ $product_id ? 'Edit Produk' : 'Tambah Produk' }}
                </flux:heading>

                <flux:text class="mt-2">
                    {{ $product_id ? 'Perbarui informasi produk.' : 'Isi formulir di bawah untuk menambahkan produk baru.' }}
                </flux:text>
            </div>

            <form wire:submit="save" class="space-y-6">
                <flux:field>
                    <flux:label>Kode Produk</flux:label>
                    <flux:input wire:model="code" placeholder="Masukkan kode produk" required />
                </flux:field>

                <flux:field>
                    <flux:label>Nama Produk</flux:label>
                    <flux:input wire:model="name" placeholder="Masukkan nama produk" required />
                </flux:field>

                <flux:field>
                    <flux:label>Harga</flux:label>
                    <flux:input wire:model="price" type="number" placeholder="Masukkan harga produk" required />
                </flux:field>

                <div class="flex justify-end">
                    <flux:button variant="primary" type="submit">Simpan</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <flux:modal name="delete-product" class="min-w-88">
        <div class="space-y-6">

            <div>
                <flux:heading size="lg">Hapus Produk?</flux:heading>

                <flux:text class="mt-2">
                    Anda akan menghapus data produk ini.<br>
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
                    Hapus Produk
                </flux:button>

            </div>
        </div>
    </flux:modal>
</div>
