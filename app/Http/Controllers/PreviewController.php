<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

use function Spatie\LaravelPdf\Support\pdf;

class PreviewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $token)
    {

        $invoice = Invoice::with(['customer', 'business', 'items.product'])
            ->where('public_token', $token)
            ->firstOrFail();

        $data = [
            'business' => $invoice->business,
            'customer' => $invoice->customer,
            'invoice_number' => $invoice->invoice_number,
            'invoice_date' => $invoice->invoice_date,
            'due_date' => $invoice->due_date,
            'items' => $invoice->items,
            'subtotal' => $invoice->subtotal,
            'total' => $invoice->total,
            'status' => $invoice->status,
        ];

        $filename = 'invoice-'.$invoice->invoice_number.'.pdf';

        $template = $invoice->template ?? 'classic';

        return pdf()
            ->view('pdf.'.$template, compact('data'))
            ->name($filename);
    }
}
