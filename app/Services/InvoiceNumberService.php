<?php

namespace App\Services;

use App\Models\Business;
use App\Models\InvoiceSequence;
use Illuminate\Support\Facades\DB;

class InvoiceNumberService
{
    public function generate(Business $business): string
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

                $sequence = InvoiceSequence::where('id', $sequence->id)
                    ->lockForUpdate()
                    ->first();
            }

            $sequence->increment('last_number');

            $running_number = str_pad(
                $sequence->last_number,
                $business->invoice_number_padding ?? 4,
                '0',
                STR_PAD_LEFT
            );

            $prefix = $business->invoice_prefix ?? 'INV';

            return "{$prefix}/{$year}/{$running_number}";
        });
    }
}
