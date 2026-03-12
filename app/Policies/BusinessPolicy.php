<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\User;

class BusinessPolicy
{
    public function manageUsers(User $user, Business $business)
    {
        return $user->hasBusinessPermission(
            $business->id,
            'manage users'
        );
    }

    public function update(User $user, Business $business)
    {
        return $user->hasBusinessPermission(
            $business->id,
            'update business'
        );
    }

    public function delete(User $user, Business $business)
    {
        return $user->hasBusinessPermission(
            $business->id,
            'delete business'
        );
    }
}
