<?php

use App\Models\Invoice;
use Livewire\Component;

use function Spatie\LaravelPdf\Support\pdf;

new class extends Component
{
    public function preview(Invoice $invoice)
    {
        $invoice = Invoice::with(['customer', 'business', 'items'])
            ->where('id', $invoice->id)
            ->first();

        $data = [
            'business' => $invoice->business,
            'customer' => $invoice->customer,
            'invoice_number' => $invoice->invoice_number,
            'invoice_date' => $invoice->invoice_date,
            'due_date' => $invoice->due_date,
            'items' => $invoice->items,
            'subtotal' => $invoice->subtotal,
            'total' => $invoice->total,
            'status' => 'draft',
        ];

        return pdf()
            ->view('invoices.templates.classic', compact('data'))
            ->name('invoice-2023-04-10.pdf');
    }
};
