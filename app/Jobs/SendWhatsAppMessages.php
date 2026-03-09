<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Services\FonnteService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsAppMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoiceIds;

    protected $waDeviceId;

    public function __construct(array $invoiceIds, string $waDeviceId)
    {
        $this->invoiceIds = $invoiceIds;
        $this->waDeviceId = $waDeviceId;
    }

    public function handle(FonnteService $fonnte)
    {
        // Ambil invoice beserta customer
        $invoices = Invoice::with('customer')
            ->whereIn('id', $this->invoiceIds)
            ->get();

        $messages = [];

        foreach ($invoices as $invoice) {
            $customer = $invoice->customer;
            if (! $customer) {
                continue;
            }

            $invoiceLink = route('invoice.preview', $invoice->public_token);

            $messages[] = [
                'target' => $customer->phone,
                'message' => "Halo {$customer->name},\nTerimakasih telah mendaftar di aplikasi kami.\nInvoice Anda bisa dilihat di: {$invoiceLink}",
                'delay' => '1-3',
            ];
        }

        $fonnte = new FonnteService($this->waDeviceId);
        $fonnte->send($messages);
    }
}
