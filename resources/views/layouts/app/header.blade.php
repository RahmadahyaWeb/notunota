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
        @auth
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        @endauth

        <a href="/" class="hidden md:flex items-center gap-2 group mr-4">

            {{-- ICON --}}
            <div class="w-8 h-8 rounded-lg bg-black text-white flex items-center justify-center text-sm font-bold">
                N
            </div>

            {{-- TEXT --}}
            <div class="flex items-baseline gap-1">
                <span class="text-lg font-semibold tracking-tight text-gray-900 group-hover:text-black">
                    Notu
                </span>

                <span class="text-lg font-semibold tracking-tight text-gray-500 group-hover:text-gray-700">
                    Nota
                </span>

                <span class="text-lg font-semibold text-gray-400">.</span>
            </div>

        </a>

        <flux:navbar class="max-lg:hidden">
            @auth
                <flux:navbar.item icon="layout-grid" href="{{ route('dashboard') }}">Dashboard</flux:navbar.item>

                <flux:dropdown>
                    <flux:navbar.item icon="document-text" icon-trailing="chevron-down">Invoice</flux:navbar.item>

                    <flux:navmenu>
                        <flux:navmenu.item icon="plus-circle" href="{{ route('invoice.create') }}">
                            Buat Invoice
                        </flux:navmenu.item>

                        <flux:navmenu.item icon="list-bullet" href="{{ route('invoice.index') }}">
                            Daftar Invoice
                        </flux:navmenu.item>

                        <flux:navmenu.item icon="clock" href="{{ route('invoice.index', ['status' => 'sent']) }}">
                            Tagihan Aktif
                        </flux:navmenu.item>

                        <flux:navmenu.item icon="check-circle" href="{{ route('invoice.index', ['status' => 'paid']) }}">
                            Sudah Lunas
                        </flux:navmenu.item>
                    </flux:navmenu>
                </flux:dropdown>

                <flux:dropdown>
                    <flux:navbar.item icon="user-group" icon-trailing="chevron-down">Manajemen</flux:navbar.item>

                    <flux:navmenu>
                        <flux:navmenu.item icon="users" href="{{ route('customer.index') }}">
                            Daftar Pelanggan
                        </flux:navmenu.item>
                        <flux:navmenu.item icon="shopping-bag" href="{{ route('product.index') }}">Katalog Produk
                        </flux:navmenu.item>

                        <flux:navmenu.separator />

                        <flux:navmenu.item icon="cog-6-tooth" href="#">Pengaturan</flux:navmenu.item>
                    </flux:navmenu>
                </flux:dropdown>
            @endauth
        </flux:navbar>

        <flux:spacer />

        {{-- <flux:navbar class="me-4">
            <flux:navbar.item class="max-lg:hidden" icon="information-circle" href="#" label="Help" />
        </flux:navbar> --}}

        @auth
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
        @else
            <div class="flex items-center gap-3">

                <flux:button href="{{ route('login') }}" variant="ghost" size="sm">
                    Login
                </flux:button>

                <flux:button href="{{ route('register') }}" variant="primary" size="sm">
                    Daftar Gratis
                </flux:button>

            </div>
        @endauth

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
            @auth
                <flux:sidebar.item icon="layout-grid" href="#" current>Dashboard</flux:sidebar.item>

                <flux:sidebar.group expandable heading="Invoice" class="grid">
                    <flux:sidebar.item .item icon="plus-circle" href="{{ route('invoice.create') }}">
                        Buat Invoice
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="list-bullet" href="{{ route('invoice.index') }}">
                        Semua Invoice
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="clock" href="{{ route('invoice.index', ['status' => 'sent']) }}">
                        Tagihan Aktif
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="check-circle" href="{{ route('invoice.index', ['status' => 'paid']) }}">
                        Sudah Lunas
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group expandable heading="Manajemen" class="grid">
                    <flux:sidebar.item icon="users" href="{{ route('customer.index') }}">
                        Daftar Pelanggan
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="shopping-bag" href="{{ route('product.index') }}">Katalog Produk
                    </flux:sidebar.item>
                </flux:sidebar.group>
            @endauth
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
