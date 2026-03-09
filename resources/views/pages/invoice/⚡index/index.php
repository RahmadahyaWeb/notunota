<?php

use App\Jobs\SendWhatsAppMessages;
use App\Models\Business;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $businessId;

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
        $this->businessId = Business::where('user_id', Auth::id())->first()->id;
    }

    #[Computed()]
    public function stats()
    {
        return [
            'paid' => Invoice::where('status', 'paid')
                ->sum('total'),

            'pending' => Invoice::where('status', 'sent')
                ->sum('total'),

            'overdue' => Invoice::where('status', 'overdue')
                ->sum('total'),
        ];
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;

        $this->modal('delete-invoice')->show();
    }

    public function delete()
    {
        Invoice::where('id', $this->delete_id)
            ->where('business_id', $this->businessId)
            ->delete();

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

    public function bulkUpdateStatus()
    {
        if (empty($this->selected_invoices) || ! $this->bulk_status) {
            return;
        }

        Invoice::whereIn('id', $this->selected_invoices)
            ->where('business_id', $this->businessId)
            ->update([
                'status' => $this->bulk_status,
            ]);

        $this->reset('selected_invoices', 'bulk_status', 'select_all');

        $this->dispatch('notify',
            title: 'Berhasil',
            message: 'Status beberapa invoice berhasil diperbarui.',
            type: 'success'
        );
    }

    public function sendInvoice($id)
    {
        $invoiceIds = [$id];
        $waDeviceId = Auth::user()->business->wa_device_id;

        SendWhatsAppMessages::dispatch($invoiceIds, $waDeviceId);

        $this->dispatch('notify',
            title: 'Berhasil',
            message: 'Invoice sedang dikirim melalui WhatsApp.',
            type: 'success'
        );
    }

    #[Computed()]
    public function invoices()
    {
        $invoices = Invoice::with(['customer', 'business', 'items'])
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->invoice_number, function ($query) {
                $query->where('invoice_number', 'like', "%{$this->invoice_number}%");
            })
            ->latest()
            ->paginate(10);

        return $invoices;
    }
};
