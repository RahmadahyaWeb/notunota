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
        $invoice = Invoice::with([
            'customer',
            'business',
            'items.product',
        ])
            ->where('public_token', $token)
            ->firstOrFail();

        // Draft hanya boleh diakses oleh user yang memiliki akses ke business
        if ($invoice->status === 'draft') {

            $user = Auth::user();

            $allowed = $user &&
                $user->businesses()
                    ->where('business_id', $invoice->business_id)
                    ->exists();

            if (! $allowed) {
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
            'public_token' => $invoice->public_token,
        ];
    }
};
