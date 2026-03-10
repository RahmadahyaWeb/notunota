<?php

namespace App\Models;

use App\Models\Traits\BelongsToBusiness;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use BelongsToBusiness;

    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted()
    {
        static::created(function ($item) {
            $item->invoice->recalculate_total();
        });

        static::updated(function ($item) {
            $item->invoice->recalculate_total();
        });

        static::deleted(function ($item) {
            $item->invoice->recalculate_total();
        });
    }
}
