<?php

namespace App\Services;

use App\Models\Business;
use App\Models\InvoiceSequence;
use Illuminate\Support\Facades\DB;

class InvoiceNumberService
{
    public function generate(Business $business)
    {
        return DB::transaction(function () use ($business) {

            $year = now()->year;

            $sequence = InvoiceSequence::where('business_id', $business->id)
                ->where('year', $year)
                ->lockForUpdate()
                ->first();

            if (! $sequence) {
                $sequence = InvoiceSequence::create([
                    'business_id' => $business->id,
                    'year' => $year,
                    'last_number' => 0,
                ]);
            }

            $sequence->increment('last_number');

            $number = str_pad(
                $sequence->last_number,
                $business->invoice_number_padding,
                '0',
                STR_PAD_LEFT
            );

            return $business->invoice_prefix
                .'-'.$year
                .'-'.$number;
        });
    }
}
