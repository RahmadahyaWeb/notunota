<?php

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

    #[Url(history: true, except: '')]
    public $status = '';

    public function mount()
    {
        $this->businessId = Business::where('user_id', Auth::id())->first()->id;
    }

    #[Computed()]
    public function stats()
    {
        return [
            'paid' => Invoice::where('business_id', $this->businessId)
                ->where('status', 'paid')
                ->sum('total'),

            'pending' => Invoice::where('business_id', $this->businessId)
                ->where('status', 'sent')
                ->sum('total'),

            'overdue' => Invoice::where('business_id', $this->businessId)
                ->where('status', 'overdue')
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

    #[Computed()]
    public function invoices()
    {
        $invoices = Invoice::with(['customer', 'business', 'items'])
            ->where('business_id', $this->businessId)
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->paginate(10);

        return $invoices;
    }
};
