<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    public function viewAny(User $user, Business $business)
    {
        return $user->hasBusinessPermission(
            $business->id,
            'view customers'
        );
    }

    public function create(User $user, Business $business)
    {
        return $user->hasBusinessPermission(
            $business->id,
            'create customers'
        );
    }

    public function update(User $user, Customer $customer)
    {
        return $user->hasBusinessPermission(
            $customer->business_id,
            'update customers'
        );
    }

    public function delete(User $user, Customer $customer)
    {
        return $user->hasBusinessPermission(
            $customer->business_id,
            'delete customers'
        );
    }
}
