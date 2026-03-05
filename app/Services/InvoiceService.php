<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceService
{
    protected InvoiceNumberService $invoiceNumberService;

    public function __construct(InvoiceNumberService $invoiceNumberService)
    {
        $this->invoiceNumberService = $invoiceNumberService;
    }

    public function create(Business $business, array $payload): Invoice
    {
        return DB::transaction(function () use ($business, $payload) {

            // 1️⃣ Generate invoice number
            $invoice_number = $this->invoiceNumberService->generate($business);

            // 2️⃣ Generate secure public token
            $public_token = Str::random(40);

            // 3️⃣ Hitung ulang subtotal & total
            $subtotal = 0;

            foreach ($payload['items'] as $item) {

                $qty = (float) $item['qty'];
                $price = (float) $item['price'];

                $line_total = $qty * $price;

                $subtotal += $line_total;
            }

            $total = $subtotal; // nanti bisa ditambah tax/discount

            // 4️⃣ Create invoice
            $invoice = Invoice::create([
                'business_id' => $business->id,
                'customer_id' => $payload['customer_id'],
                'invoice_number' => $invoice_number,
                'public_token' => $public_token,
                'status' => 'draft',
                'invoice_date' => $payload['invoice_date'],
                'due_date' => $payload['due_date'] ?? null,
                'subtotal' => $subtotal,
                'total' => $total,
                'is_public' => true,
                'template' => $payload['template'] ?? 'classic',
            ]);

            // 5️⃣ Save invoice items snapshot
            foreach ($payload['items'] as $item) {

                $qty = (float) $item['qty'];
                $price = (float) $item['price'];
                $line_total = $qty * $price;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $item['product_id'] ?? null,
                    'description' => $item['description'],
                    'qty' => $qty,
                    'price' => $price,
                    'total' => $line_total,
                ]);
            }

            return $invoice->load('items', 'customer');
        });
    }
}
