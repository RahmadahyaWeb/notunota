<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')

    <style>
        .a4-page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            box-sizing: border-box;
        }
    </style>
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800 antialiased">
    <flux:header sticky container class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:brand href="#" logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc."
            class="max-lg:hidden dark:hidden" />
        <flux:brand href="#" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc."
            class="max-lg:hidden! hidden dark:flex" />

        <flux:navbar class="max-lg:hidden">
            {{-- Item Utama yang Sering Diakses --}}
            <flux:navbar.item icon="layout-grid" href="{{ route('dashboard') }}">Dashboard</flux:navbar.item>

            {{-- Dropdown Khusus Invoice (User Friendly & Terfokus) --}}
            <flux:dropdown>
                <flux:navbar.item icon="document-text" icon-trailing="chevron-down">Invoices</flux:navbar.item>

                <flux:navmenu>
                    {{-- Hasil: /invoice --}}
                    <flux:navmenu.item icon="list-bullet" href="{{ route('invoice.index') }}">
                        Semua Invoice
                    </flux:navmenu.item>

                    {{-- Hasil: /invoice?status=sent --}}
                    <flux:navmenu.item icon="clock" href="{{ route('invoice.index', ['status' => 'sent']) }}">
                        Tagihan Aktif
                    </flux:navmenu.item>

                    {{-- Hasil: /invoice?status=paid --}}
                    <flux:navmenu.item icon="check-circle" href="{{ route('invoice.index', ['status' => 'paid']) }}">
                        Sudah Lunas
                    </flux:navmenu.item>
                </flux:navmenu>
            </flux:dropdown>

            {{-- Dropdown Manajemen (Ganti dari 'Favorites') --}}
            <flux:dropdown>
                <flux:navbar.item icon="user-group" icon-trailing="chevron-down">Manajemen</flux:navbar.item>

                <flux:navmenu>
                    <flux:navmenu.item icon="users" href="#">Daftar Pelanggan</flux:navmenu.item>
                    <flux:navmenu.item icon="shopping-bag" href="#">Katalog Produk</flux:navmenu.item>

                    <flux:navmenu.separator />

                    <flux:navmenu.item icon="cog-6-tooth" href="#">Pengaturan</flux:navmenu.item>
                </flux:navmenu>
            </flux:dropdown>
        </flux:navbar>

        <flux:spacer />

        <flux:navbar class="me-4">
            <flux:navbar.item class="max-lg:hidden" icon="information-circle" href="#" label="Help" />
        </flux:navbar>

        <flux:dropdown position="top" align="start">
            <flux:profile :chevron="false" :initials="auth()->user()->initials()"
                name="{{ auth()->user()->name }}" />
            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('Pengaturan') }}
                    </flux:menu.item>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer" data-test="logout-button">
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu.radio.group>
            </flux:menu>
        </flux:dropdown>

    </flux:header>

    <flux:sidebar sticky collapsible="mobile"
        class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.header>
            <flux:sidebar.brand href="#" logo="https://fluxui.dev/img/demo/logo.png"
                logo:dark="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc." />

            <flux:sidebar.collapse
                class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.item icon="home" href="#" current>Home</flux:sidebar.item>
        </flux:sidebar.nav>

        <flux:sidebar.spacer />

        <flux:sidebar.nav>
            <flux:sidebar.item icon="cog-6-tooth" href="#">Settings</flux:sidebar.item>
            <flux:sidebar.item icon="information-circle" href="#">Help</flux:sidebar.item>
        </flux:sidebar.nav>
    </flux:sidebar>

    {{ $slot }}

    @fluxScripts

    @stack('scripts')
</body>

</html>
