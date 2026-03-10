<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function save(array $data): Customer
    {
        return Customer::updateOrCreate(
            ['id' => $data['id'] ?? null],
            [
                'code' => $data['code'],
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]
        );
    }

    public function delete(int $id): void
    {
        Customer::where('id', $id)->delete();
    }
}
