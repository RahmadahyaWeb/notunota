<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessInvite extends Model
{
    protected $fillable = [
        'business_id',
        'token',
        'role',
        'expired_at',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
