<?php

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $businessId;

    public $customer_id;

    public $delete_id;

    public $code;

    public $name;

    public $email;

    public $phone;

    public $address;

    public function mount()
    {
        $this->businessId = Auth::user()->business->id;
    }

    protected function rules()
    {
        return [
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
        ];
    }

    public function save()
    {
        $this->validate();

        Customer::updateOrCreate(
            [
                'id' => $this->customer_id,
                'business_id' => $this->businessId,
            ],
            [
                'code' => $this->code,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
            ]
        );

        $this->resetForm();

        $this->modal('add-customer')->close();

        $this->dispatch('notify',
            title: 'Berhasil',
            message: 'Data pelanggan berhasil disimpan.',
            type: 'success'
        );
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        $this->customer_id = $customer->id;
        $this->code = $customer->code;
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->address = $customer->address;

        $this->modal('add-customer')->show();
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;

        $this->modal('delete-customer')->show();
    }

    public function delete()
    {
        Customer::where('id', $this->delete_id)
            ->where('business_id', $this->businessId)
            ->delete();

        $this->reset('delete_id');

        $this->modal('delete-customer')->close();

        $this->dispatch('notify',
            title: 'Berhasil',
            message: 'Data pelanggan berhasil dihapus.',
            type: 'success'
        );
    }

    public function resetForm()
    {
        $this->reset([
            'customer_id',
            'code',
            'name',
            'email',
            'phone',
            'address',
        ]);
    }

    #[Computed()]
    public function customers()
    {
        return Auth::user()->business
            ->customers()
            ->latest()
            ->paginate(10);
    }

    #[Computed()]
    public function stats()
    {
        return [
            'total' => Customer::where('business_id', $this->businessId)->count(),
        ];
    }
};
