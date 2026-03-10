<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceService
{
    protected InvoiceNumberService $numberService;

    public function __construct(InvoiceNumberService $numberService)
    {
        $this->numberService = $numberService;
    }

    public function create($business, array $data)
    {
        return DB::transaction(function () use ($business, $data) {

            $invoice = Invoice::create([
                'business_id' => $business->id,
                'customer_id' => $data['customer_id'],
                'invoice_number' => $this->numberService->generate($business),
                'invoice_date' => $data['invoice_date'],
                'due_date' => $data['due_date'],
                'template' => $data['template'],
                'status' => 'draft',
                'public_token' => Str::uuid(),
            ]);

            foreach ($data['items'] as $item) {

                $invoice->items()->create([
                    'product_id' => $item['product_id'],
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'total' => $item['qty'] * $item['price'],
                ]);
            }

            return $invoice;
        });
    }

    public function update(Invoice $invoice, array $data)
    {
        return DB::transaction(function () use ($invoice, $data) {

            $invoice->update([
                'customer_id' => $data['customer_id'],
                'invoice_date' => $data['invoice_date'],
                'due_date' => $data['due_date'],
                'template' => $data['template'],
            ]);

            $invoice->items()->delete();

            foreach ($data['items'] as $item) {

                $invoice->items()->create([
                    'product_id' => $item['product_id'],
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'total' => $item['qty'] * $item['price'],
                ]);
            }

            return $invoice;
        });
    }

    protected function generateNumber($business)
    {
        $count = $business->invoices()->count() + 1;

        return 'INV-'.str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    public function delete(int $id): void
    {
        Invoice::where('id', $id)->delete();
    }

    public function bulkUpdateStatus(array $ids, string $status): void
    {
        Invoice::whereIn('id', $ids)->update([
            'status' => $status,
        ]);
    }
}
