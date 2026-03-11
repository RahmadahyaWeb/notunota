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

            <!-- LEFT -->
            <div>

                <div
                    class="inline-flex items-center text-xs font-medium px-3 py-1 rounded-full bg-gray-100 text-gray-700">
                    Simple Invoice App
                </div>

                <h1 class="text-4xl md:text-5xl font-bold leading-tight mt-4">
                    Tidak Perlu Lagi
                    <br>
                    Membuat Invoice di Excel
                </h1>

                <p class="mt-6 text-gray-600 leading-relaxed">
                    Dengan <span class="font-medium text-gray-900">NotuNota</span>,
                    Anda bisa membuat invoice profesional, menyimpan pelanggan,
                    dan melihat riwayat transaksi dalam satu tempat.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">

                    <a href="/register" class="px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition">
                        Mulai Buat Invoice
                    </a>

                    <a href="#cara-kerja"
                        class="px-6 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        Cara Kerja
                    </a>

                </div>

            </div>


            <!-- PREVIEW -->
            <div>

                <div class="bg-white border border-gray-200 rounded-xl shadow-lg p-7">

                    <!-- HEADER -->
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
                                INV-1042
                            </div>

                            <span class="inline-block mt-2 text-xs px-2 py-1 bg-green-100 text-green-700 rounded">
                                Paid
                            </span>
                        </div>

                    </div>


                    <!-- INFO -->
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


                    <!-- TABLE -->
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


                    <!-- TOTAL -->
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
    <div id="cara-kerja" class="py-24 bg-gray-50">

        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-16">

                <h2 class="text-3xl font-semibold">
                    Membuat Invoice Hanya 3 Langkah
                </h2>

                <p class="text-gray-600 mt-4">
                    Dirancang agar Anda bisa membuat invoice dengan cepat.
                </p>

            </div>

            <div class="grid md:grid-cols-3 gap-8">

                <div class="bg-white border rounded-xl p-6 text-center">

                    <div class="text-3xl font-bold text-gray-900 mb-3">1</div>

                    <div class="font-semibold mb-2">
                        Tambahkan Pelanggan
                    </div>

                    <p class="text-sm text-gray-600">
                        Simpan data customer agar tidak perlu mengetik ulang.
                    </p>

                </div>

                <div class="bg-white border rounded-xl p-6 text-center">

                    <div class="text-3xl font-bold text-gray-900 mb-3">2</div>

                    <div class="font-semibold mb-2">
                        Buat Invoice
                    </div>

                    <p class="text-sm text-gray-600">
                        Tambahkan item dan harga dengan cepat.
                    </p>

                </div>

                <div class="bg-white border rounded-xl p-6 text-center">

                    <div class="text-3xl font-bold text-gray-900 mb-3">3</div>

                    <div class="font-semibold mb-2">
                        Invoice Siap Digunakan
                    </div>

                    <p class="text-sm text-gray-600">
                        Invoice terlihat rapi dan siap dikirim ke customer.
                    </p>

                </div>

            </div>

        </div>

    </div>

    <div class="py-24">

        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-16">

                <h2 class="text-3xl font-semibold">
                    Fitur yang Membantu Mengelola Invoice
                </h2>

                <p class="text-gray-600 mt-4">
                    NotuNota tidak hanya membuat invoice, tetapi juga membantu
                    Anda memahami penjualan dari setiap transaksi.
                </p>

            </div>

            <div class="grid md:grid-cols-2 gap-8">

                <!-- PENJUALAN -->
                <div class="bg-white border border-gray-200 rounded-xl p-8 hover:shadow-lg transition">

                    <div class="font-semibold text-lg mb-2">
                        Catatan Penjualan Otomatis
                    </div>

                    <p class="text-gray-600 text-sm leading-relaxed">
                        Setiap invoice yang Anda buat otomatis tercatat sebagai
                        penjualan sehingga Anda dapat melihat riwayat transaksi
                        dan memahami perkembangan bisnis Anda.
                    </p>

                    <div class="mt-4 text-xs text-gray-500">
                        • Riwayat transaksi tersimpan rapi
                        <br>
                        • Total penjualan dapat dihitung otomatis
                    </div>

                </div>


                <!-- TELEGRAM -->
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-8 relative">

                    <div class="absolute top-4 right-4 text-xs bg-black text-white px-2 py-1 rounded">
                        Coming Soon
                    </div>

                    <div class="font-semibold text-lg mb-2">
                        Telegram Bot untuk Ringkasan Bisnis
                    </div>

                    <p class="text-gray-600 text-sm leading-relaxed">
                        Nantinya Anda dapat melihat ringkasan penjualan dan
                        aktivitas invoice langsung melalui Telegram bot,
                        tanpa perlu membuka dashboard.
                    </p>

                    <div class="mt-4 text-xs text-gray-500">
                        • Notifikasi ringkasan penjualan
                        <br>
                        • Statistik bisnis langsung di Telegram
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="py-24 bg-gray-50">

        <div class="max-w-6xl mx-auto px-6">

            <div class="text-center mb-16">

                <h2 class="text-3xl font-semibold">
                    Cocok untuk Berbagai Jenis Bisnis
                </h2>

                <p class="text-gray-600 mt-4">
                    NotuNota membantu berbagai jenis usaha membuat invoice
                    lebih cepat dan lebih rapi.
                </p>

            </div>


            <div class="grid md:grid-cols-4 gap-6 text-center">

                <div class="bg-white border border-gray-200 rounded-xl p-6">

                    <div class="font-semibold mb-2">
                        Freelancer
                    </div>

                    <p class="text-sm text-gray-600">
                        Kirim invoice proyek ke klien dengan format profesional.
                    </p>

                </div>


                <div class="bg-white border border-gray-200 rounded-xl p-6">

                    <div class="font-semibold mb-2">
                        Jasa Digital
                    </div>

                    <p class="text-sm text-gray-600">
                        Buat invoice untuk website, desain, atau layanan digital.
                    </p>

                </div>


                <div class="bg-white border border-gray-200 rounded-xl p-6">

                    <div class="font-semibold mb-2">
                        Konsultan
                    </div>

                    <p class="text-sm text-gray-600">
                        Catat transaksi layanan konsultasi dengan invoice rapi.
                    </p>

                </div>


                <div class="bg-white border border-gray-200 rounded-xl p-6">

                    <div class="font-semibold mb-2">
                        UMKM
                    </div>

                    <p class="text-sm text-gray-600">
                        Kelola penagihan pelanggan dengan lebih mudah.
                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- CTA --}}
    <div class="py-24 bg-black text-white mt-24">

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

        <div class="mx-auto text-sm text-gray-500 flex justify-between flex-wrap gap-4">

            <span>
                © {{ date('Y') }} NotuNota
            </span>

            <span>
                Simple Invoice App
            </span>

        </div>

    </div>

</div>
