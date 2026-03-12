<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    public function viewAny(User $user, Business $business)
    {
        return $user->hasBusinessPermission(
            $business->id,
            'view invoices'
        );
    }

    public function create(User $user, Business $business)
    {
        return $user->hasBusinessPermission(
            $business->id,
            'create invoices'
        );
    }

    public function update(User $user, Invoice $invoice)
    {
        return $user->hasBusinessPermission(
            $invoice->business_id,
            'update invoices'
        );
    }

    public function delete(User $user, Invoice $invoice)
    {
        return $user->hasBusinessPermission(
            $invoice->business_id,
            'delete invoices'
        );
    }

    public function send(User $user, Invoice $invoice)
    {
        return $user->hasBusinessPermission(
            $invoice->business_id,
            'send invoices'
        );
    }
}
