<?php

namespace App\Models;

use App\Models\Traits\BelongsToBusiness;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use BelongsToBusiness;

    protected $guarded = [];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function recalculate_total()
    {
        $subtotal = $this->items()->sum('total');

        $this->update([
            'subtotal' => $subtotal,
            'total' => $subtotal - $this->discount + $this->tax,
        ]);
    }
}
