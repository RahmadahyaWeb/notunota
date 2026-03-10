<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public $name;

    public $address;

    public $phone;

    public $bank_name;

    public $bank_account_number;

    public $bank_account_name;

    public $invoice_prefix;

    public $business_id;

    public $wa_device_id;

    public $use_notunota_token = '1';

    public function mount()
    {
        $business = tenant();

        if ($business) {
            $this->business_id = $business->id;
            $this->name = $business->name;
            $this->address = $business->address;
            $this->phone = $business->phone;

            $this->bank_name = $business->bank_name;
            $this->bank_account_number = $business->bank_account_number;
            $this->bank_account_name = $business->bank_account_name;

            $this->wa_device_id = $business->wa_device_id;

            $this->invoice_prefix = $business->invoice_prefix;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:100',
            'bank_account_name' => 'nullable|string|max:255',
            'invoice_prefix' => 'nullable|string|max:20',
            'wa_device_id' => 'nullable|string|max:255',
        ]);

        Auth::user()->business()->updateOrCreate(
            [],
            [
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'bank_name' => $this->bank_name,
                'bank_account_number' => $this->bank_account_number,
                'bank_account_name' => $this->bank_account_name,
                'invoice_prefix' => $this->invoice_prefix,
                'wa_device_id' => $this->wa_device_id,
            ]
        );

        $this->dispatch('notify',
            title: 'Berhasil',
            message: 'Pengaturan toko berhasil disimpan.',
            type: 'success'
        );
    }
};
