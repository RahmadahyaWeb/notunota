<?php

use App\Models\Customer;
use App\Services\CustomerService;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $customer_id;

    public $delete_id;

    public $code;

    public $name;

    public $email;

    public $phone;

    public $address;

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

    public function save(CustomerService $service)
    {
        $this->validate();

        $service->save([
            'id' => $this->customer_id,
            'code' => $this->code,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

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

    public function delete(CustomerService $service)
    {
        $service->delete($this->delete_id);

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

    #[Computed]
    public function customers()
    {
        return Customer::query()
            ->latest()
            ->paginate(10);
    }

    #[Computed]
    public function stats()
    {
        return [
            'total' => Customer::count(),
        ];
    }
};
