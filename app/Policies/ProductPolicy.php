<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function viewAny(User $user, Business $business)
    {
        return $user->hasBusinessPermission(
            $business->id,
            'view products'
        );
    }

    public function create(User $user, Business $business)
    {
        return $user->hasBusinessPermission(
            $business->id,
            'create products'
        );
    }

    public function update(User $user, Product $product)
    {
        return $user->hasBusinessPermission(
            $product->business_id,
            'update products'
        );
    }

    public function delete(User $user, Product $product)
    {
        return $user->hasBusinessPermission(
            $product->business_id,
            'delete products'
        );
    }
}
