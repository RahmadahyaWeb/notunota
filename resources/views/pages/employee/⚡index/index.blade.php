<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <flux:heading size="xl" level="1">Daftar Pegawai</flux:heading>
            <flux:text class="mt-1">Kelola pegawai yang memiliki akses ke bisnis Anda.</flux:text>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6 my-8">

        {{-- GENERATE INVITE --}}
        <flux:card class="space-y-4">

            <flux:heading size="lg">
                Undang Pegawai
            </flux:heading>

            <flux:text class="text-sm text-zinc-500">
                Buat link undangan yang bisa dibagikan kepada pegawai.
            </flux:text>

            <flux:field>
                <flux:label>Role Pegawai</flux:label>

                <flux:select wire:model="role">
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </flux:select>
            </flux:field>

            <flux:button wire:click="generateInvite" variant="primary" icon="link">

                Generate Invitation Link
            </flux:button>

            @if ($invite_link)
                <flux:field>
                    <flux:label>Link Undangan</flux:label>

                    <flux:input readonly value="{{ $invite_link }}" copyable />
                </flux:field>
            @endif

        </flux:card>


        {{-- LIST INVITE --}}
        <flux:card>

            <flux:heading size="lg" class="mb-4">
                Invitation Link
            </flux:heading>

            <flux:table>

                <flux:table.columns>
                    <flux:table.column>Role</flux:table.column>
                    <flux:table.column>Link</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>

                    @forelse ($this->invites as $invite)
                        <flux:table.row>

                            <flux:table.cell class="capitalize">
                                {{ $invite->role }}
                            </flux:table.cell>

                            <flux:table.cell class="text-xs text-zinc-500">
                                {{ url('/join/' . $invite->token) }}
                            </flux:table.cell>

                        </flux:table.row>

                    @empty

                        <flux:table.row>
                            <flux:table.cell colspan="2" class="text-center text-zinc-500">
                                Belum ada invitation.
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse

                </flux:table.rows>

            </flux:table>

        </flux:card>

    </div>

    <flux:card>

        <div class="flex items-center justify-between mb-6">

            <flux:heading size="lg">
                Pegawai
            </flux:heading>

            <flux:text class="text-sm text-zinc-500">
                {{ $this->employees->total() }} pegawai
            </flux:text>

        </div>

        <flux:table :paginate="$this->employees">

            <flux:table.columns>
                <flux:table.column>Nama</flux:table.column>
                <flux:table.column>Email</flux:table.column>
                <flux:table.column>Role</flux:table.column>
                <flux:table.column />
            </flux:table.columns>

            <flux:table.rows>

                @forelse ($this->employees as $employee)
                    <flux:table.row wire:key="employee-{{ $employee->id }}">

                        <flux:table.cell>
                            {{ $employee->name }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $employee->email }}
                        </flux:table.cell>

                        <flux:table.cell class="capitalize">
                            {{ $employee->pivot->role }}
                        </flux:table.cell>

                        <flux:table.cell class="text-right">

                            <flux:dropdown>

                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" />

                                <flux:menu>

                                    <flux:menu.item icon="pencil-square" wire:click="edit({{ $employee->id }})">

                                        Edit Role

                                    </flux:menu.item>

                                    <flux:menu.separator />

                                    <flux:menu.item variant="danger" icon="trash"
                                        wire:click="confirmDelete({{ $employee->id }})">

                                        Hapus Pegawai

                                    </flux:menu.item>

                                </flux:menu>

                            </flux:dropdown>

                        </flux:table.cell>

                    </flux:table.row>

                @empty

                    <flux:table.row>

                        <flux:table.cell colspan="4" class="text-center text-zinc-500">

                            Belum ada pegawai.

                        </flux:table.cell>

                    </flux:table.row>
                @endforelse

            </flux:table.rows>

        </flux:table>

    </flux:card>

    {{-- MODAL TAMBAH PEGAWAI --}}
    <flux:modal name="add-employee" class="md:w-96" @close="resetForm()" :dismissible="false">
        <div class="space-y-6">

            <div>
                <flux:heading size="lg">
                    {{ $employee_id ? 'Edit Role Pegawai' : 'Tambah Pegawai' }}
                </flux:heading>

                <flux:text class="mt-2">
                    {{ $employee_id ? 'Perbarui role pegawai.' : 'Masukkan email pegawai yang ingin diberi akses.' }}
                </flux:text>
            </div>

            <form wire:submit="updateRole" class="space-y-6">

                <flux:field>
                    <flux:label>Email Pegawai</flux:label>
                    <flux:input wire:model="email" type="email" placeholder="contoh@email.com" required />
                </flux:field>

                <flux:field>
                    <flux:label>Role</flux:label>

                    <flux:select wire:model="role">

                        <option value="staff">Staff</option>

                        <option value="admin">Admin</option>

                    </flux:select>
                </flux:field>

                <div class="flex justify-end">
                    <flux:button variant="primary" type="submit">
                        Simpan
                    </flux:button>
                </div>

            </form>

        </div>
    </flux:modal>


    {{-- MODAL DELETE --}}
    <flux:modal name="delete-employee" class="min-w-88">

        <div class="space-y-6">

            <div>
                <flux:heading size="lg">Hapus Pegawai?</flux:heading>

                <flux:text class="mt-2">
                    Pegawai ini akan kehilangan akses ke bisnis Anda.
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
                    Hapus Pegawai
                </flux:button>

            </div>

        </div>

    </flux:modal>

</div>
