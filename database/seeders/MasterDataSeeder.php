<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user pertama
        $user = User::first();

        if (! $user) {
            $this->command->warn('Tidak ada user ditemukan. Buat user terlebih dahulu.');

            return;
        }

        // Buat business jika belum ada
        $business = $user->business;

        if (! $business) {
            $business = Business::create([
                'user_id' => $user->id,
                'name' => 'Toko Maju Jaya',
                'phone' => '081234567890',
                'address' => 'Jl. Contoh No. 123',
                'invoice_prefix' => 'INV',
                'invoice_number_padding' => 4,
            ]);
        }

        // ==========================
        // Seed Customers
        // ==========================

        $customers = [
            [
                'name' => 'PT Sinar Abadi',
                'phone' => '081111111111',
                'email' => 'sinarabadi@email.com',
                'address' => 'Pontianak',
            ],
            [
                'name' => 'CV Berkah Mandiri',
                'phone' => '082222222222',
                'email' => 'berkah@email.com',
                'address' => 'Kubu Raya',
            ],
            [
                'name' => 'Budi Santoso',
                'phone' => '083333333333',
                'email' => 'budi@email.com',
                'address' => 'Singkawang',
            ],
            [
                'name' => 'Andi Wijaya',
                'phone' => '084444444444',
                'email' => 'andi@email.com',
                'address' => 'Mempawah',
            ],
            [
                'name' => 'Sari Dewi',
                'phone' => '085555555555',
                'email' => 'sari@email.com',
                'address' => 'Sambas',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create([
                'business_id' => $business->id,
                'name' => $customer['name'],
                'phone' => $customer['phone'],
                'email' => $customer['email'],
                'address' => $customer['address'],
            ]);
        }

        // ==========================
        // Seed Products
        // ==========================

        $products = [
            ['name' => 'Jasa Desain Logo', 'price' => 500000, 'code' => 'LOGO001'],
            ['name' => 'Jasa Pembuatan Website', 'price' => 2500000, 'code' => 'WEB001'],
            ['name' => 'Maintenance Website Bulanan', 'price' => 300000, 'code' => 'MAINT001'],
            ['name' => 'Cetak Banner 1x2m', 'price' => 150000, 'code' => 'BANNER001'],
            ['name' => 'Cetak Brosur 1000pcs', 'price' => 400000, 'code' => 'BROSUR001'],
            ['name' => 'Jasa SEO Basic', 'price' => 1000000, 'code' => 'SEO_BASIC001'],
            ['name' => 'Jasa SEO Premium', 'price' => 2500000, 'code' => 'SEO_PREMIUM001'],
            ['name' => 'Jasa Social Media Management', 'price' => 1200000, 'code' => 'SOCIAL001'],
            ['name' => 'Fotografi Produk', 'price' => 750000, 'code' => 'FOTO001'],
            ['name' => 'Editing Video Promosi', 'price' => 900000, 'code' => 'VIDEO001'],
        ];

        foreach ($products as $product) {
            Product::create([
                'business_id' => $business->id,
                'name' => $product['name'],
                'code' => $product['code'],
                'description' => $product['name'],
                'price' => $product['price'],
                'sku' => Str::upper(Str::random(8)),
                'is_active' => true,
            ]);
        }

        $this->command->info('Master data berhasil dibuat.');
    }
}
