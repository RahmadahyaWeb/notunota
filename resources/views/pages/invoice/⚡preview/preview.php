<?php

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public $data = [];

    public $template = 'classic';

    public function mount($token)
    {
        $invoice = Invoice::with(['customer', 'business', 'items.product'])
            ->where('public_token', $token)
            ->firstOrFail();

        // Jika status draft, hanya pemilik yang boleh mengakses
        if ($invoice->status === 'draft') {
            if (! auth()->check() || Auth::user()->business->id !== $invoice->business->id) {
                abort(403, 'Anda tidak memiliki akses ke invoice ini.');
            }
        }

        $this->template = $invoice->template ?? 'classic';

        $this->data = [
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
    }
};
