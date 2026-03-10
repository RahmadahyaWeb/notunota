<?php

use App\Models\Invoice;
use App\Services\InvoiceService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $delete_id;

    public $selected_invoices = [];

    public $bulk_status = '';

    public $select_all = false;

    #[Url(history: true, except: '')]
    public $status = '';

    #[Url(history: true, except: '')]
    public $invoice_number = '';

    public function mount()
    {
        $this->authorize('viewAny', Invoice::class);
    }

    #[Computed]
    public function stats()
    {
        return [
            'paid' => Invoice::where('status', 'paid')->sum('total'),

            'pending' => Invoice::where('status', 'sent')->sum('total'),

            'overdue' => Invoice::where('status', 'overdue')->sum('total'),
        ];
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;

        $this->modal('delete-invoice')->show();
    }

    public function delete(InvoiceService $service)
    {
        $service->delete($this->delete_id);

        $this->reset('delete_id');

        $this->modal('delete-invoice')->close();

        $this->dispatch('notify',
            title: 'Berhasil',
            message: 'Data invoice berhasil dihapus.',
            type: 'success'
        );
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected_invoices = $this->invoices->pluck('id')->toArray();
        } else {
            $this->selected_invoices = [];
        }
    }

    public function updatedSelectedInvoices()
    {
        $this->select_all = count($this->selected_invoices) === $this->invoices->count();
    }

    public function updatedInvoiceNumber()
    {
        $this->resetPage();
    }

    public function bulkUpdateStatus(InvoiceService $service)
    {
        if (empty($this->selected_invoices) || ! $this->bulk_status) {
            return;
        }

        $service->bulkUpdateStatus(
            $this->selected_invoices,
            $this->bulk_status
        );

        $this->reset('selected_invoices', 'bulk_status', 'select_all');

        $this->dispatch('notify',
            title: 'Berhasil',
            message: 'Status beberapa invoice berhasil diperbarui.',
            type: 'success'
        );
    }

    public function sendInvoice($id)
    {
        $invoice = Invoice::with(['customer', 'business'])
            ->findOrFail($id);

        $customer = $invoice->customer;

        $invoice_link = route('invoice.preview', $invoice->public_token);

        $message = "Halo {$customer->name}\n\n"
            ."Terima kasih sudah berbelanja di {$invoice->business->name}.\n"
            ."Berikut invoice transaksi Anda:\n\n"
            ."{$invoice->invoice_number}\n"
            ."{$invoice_link}\n\n"
            ."Silakan dibuka untuk melihat detail dan pembayaran.\n"
            .'Terima kasih.';

        $encoded_message = urlencode($message);

        $phone = preg_replace('/[^0-9]/', '', $customer->phone);

        if (substr($phone, 0, 1) == '0') {
            $phone = '62'.substr($phone, 1);
        }

        $wa_link = "https://wa.me/{$phone}?text={$encoded_message}";

        $this->dispatch('open-wa', url: $wa_link);
    }

    #[Computed]
    public function invoices()
    {
        return Invoice::with(['customer', 'business', 'items'])
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->invoice_number, fn ($q) => $q->where('invoice_number', 'like', "%{$this->invoice_number}%")
            )
            ->latest()
            ->paginate(10);
    }
};
