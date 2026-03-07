<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div>

    {{-- HERO --}}
    <div class="mx-auto py-24">

        <div class="grid md:grid-cols-2 gap-16 items-center">

            {{-- LEFT --}}
            <div>

                <div class="text-sm font-semibold tracking-wide text-gray-500">
                    NOTUNOTA
                </div>

                <h1 class="text-4xl md:text-5xl font-bold leading-tight mt-3">
                    Bikin Invoice Profesional
                    <br>
                    Tanpa Ribet
                </h1>

                <p class="mt-6 text-gray-600 leading-relaxed">
                    Tidak perlu lagi membuat invoice di Word atau Excel.
                    Dengan <span class="font-medium text-gray-900">NotuNota</span>,
                    Anda dapat membuat invoice rapi, menyimpan data pelanggan,
                    dan mengirim invoice ke customer dalam hitungan detik.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">

                    <a href="/register" class="px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition">
                        Buat Invoice Sekarang
                    </a>

                    <a href="#fitur" class="px-6 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        Lihat Fitur
                    </a>

                </div>

            </div>


            {{-- PREVIEW --}}
            <div>

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-7">

                    {{-- HEADER --}}
                    <div class="flex items-start justify-between pb-5 border-b">

                        <div>
                            <div class="text-lg font-semibold tracking-wide">
                                NOTUNOTA
                            </div>

                            <div class="text-xs text-gray-500 mt-1">
                                Invoice sederhana & profesional
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="text-xs text-gray-400 uppercase tracking-wide">
                                Invoice
                            </div>

                            <div class="text-sm font-semibold mt-1">
                                INV-001
                            </div>
                        </div>

                    </div>


                    {{-- INFO --}}
                    <div class="grid grid-cols-2 gap-6 text-sm py-5">

                        <div>
                            <div class="text-xs text-gray-400 uppercase mb-1">
                                Ditagihkan ke
                            </div>

                            <div class="font-medium">
                                PT Maju Bersama
                            </div>

                            <div class="text-xs text-gray-500">
                                Jakarta, Indonesia
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="text-xs text-gray-400 uppercase mb-1">
                                Tanggal
                            </div>

                            <div>
                                12 Mar 2026
                            </div>
                        </div>

                    </div>


                    {{-- TABLE --}}
                    <div class="text-sm">

                        <div class="grid grid-cols-12 text-xs text-gray-400 border-b pb-2">
                            <div class="col-span-6">Item</div>
                            <div class="col-span-2 text-center">Qty</div>
                            <div class="col-span-4 text-right">Harga</div>
                        </div>

                        <div class="grid grid-cols-12 py-3 border-b">
                            <div class="col-span-6">Website Development</div>
                            <div class="col-span-2 text-center text-gray-600">1</div>
                            <div class="col-span-4 text-right">Rp 5.000.000</div>
                        </div>

                        <div class="grid grid-cols-12 py-3">
                            <div class="col-span-6">Maintenance</div>
                            <div class="col-span-2 text-center text-gray-600">1</div>
                            <div class="col-span-4 text-right">Rp 500.000</div>
                        </div>

                    </div>


                    {{-- TOTAL --}}
                    <div class="flex justify-end mt-6">

                        <div class="w-48 border-t pt-3 flex justify-between text-sm font-semibold">
                            <span>Total</span>
                            <span>Rp 5.500.000</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- FITUR --}}
    <div id="fitur" class="bg-gray-50 py-24">

        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-16">

                <h2 class="text-3xl font-semibold">
                    Semua yang Anda butuhkan untuk membuat invoice
                </h2>

                <p class="text-gray-600 mt-4">
                    Dirancang supaya Anda bisa fokus ke bisnis,
                    bukan mengurus format invoice.
                </p>

            </div>


            <div class="grid md:grid-cols-3 gap-8">

                <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition">

                    <div class="font-semibold mb-2">
                        Buat Invoice dalam Hitungan Detik
                    </div>

                    <p class="text-sm text-gray-600">
                        Isi data pelanggan, tambah item, dan invoice langsung siap.
                    </p>

                </div>


                <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition">

                    <div class="font-semibold mb-2">
                        Simpan Data Customer
                    </div>

                    <p class="text-sm text-gray-600">
                        Tidak perlu mengetik ulang pelanggan setiap kali membuat invoice.
                    </p>

                </div>


                <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition">

                    <div class="font-semibold mb-2">
                        Tampilan Invoice Profesional
                    </div>

                    <p class="text-sm text-gray-600">
                        Invoice terlihat rapi dan siap dikirim ke customer Anda.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- INTEGRASI --}}
    <div class="py-24">

        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-16">

                <h2 class="text-3xl font-semibold">
                    Kirim Invoice Lebih Cepat
                </h2>

                <p class="text-gray-600 mt-4">
                    Kirim invoice langsung ke customer tanpa perlu download file dulu.
                </p>

            </div>


            <div class="grid md:grid-cols-2 gap-8">

                <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition">

                    <div class="font-semibold">
                        Kirim via WhatsApp
                    </div>

                    <p class="text-sm text-gray-600 mt-2">
                        Kirim invoice langsung ke pelanggan melalui WhatsApp
                        hanya dengan satu klik.
                    </p>

                </div>


                <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition bg-gray-50">

                    <div class="font-semibold">
                        Telegram Bot (Coming Soon)
                    </div>

                    <p class="text-sm text-gray-600 mt-2">
                        Lihat ringkasan invoice dan laporan bisnis
                        langsung dari Telegram bot.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- CTA --}}
    <div class="py-24 bg-black text-white">

        <div class="max-w-3xl mx-auto text-center px-6">

            <h2 class="text-3xl font-semibold">
                Sudah siap membuat invoice pertama Anda?
            </h2>

            <p class="text-gray-300 mt-4">
                Daftar gratis dan mulai buat invoice
                dalam waktu kurang dari 1 menit.
            </p>

            <a href="/register"
                class="inline-block mt-8 px-8 py-3 bg-white text-black rounded-lg hover:bg-gray-200 transition">
                Daftar Gratis
            </a>

        </div>

    </div>


    {{-- FOOTER --}}
    <div class="border-t py-8">

        <div class="max-w-6xl mx-auto px-6 text-sm text-gray-500 flex justify-between flex-wrap gap-4">

            <span>
                © {{ date('Y') }} NotuNota
            </span>

            <span>
                Simple Invoice App
            </span>

        </div>

    </div>

</div>
