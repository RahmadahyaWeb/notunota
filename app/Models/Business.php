<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $guarded = [];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function invoice_sequences()
    {
        return $this->hasMany(InvoiceSequence::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'business_users')
            ->withPivot('role')
            ->withTimestamps();
    }
}
