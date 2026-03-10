<?php

namespace App\Models\Traits;

use App\Services\Tenant;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToBusiness
{
    protected static function bootBelongsToBusiness()
    {

        static::creating(function ($model) {

            if (! $model->business_id) {
                $model->business_id = Tenant::id();
            }

        });

        static::addGlobalScope('business', function (Builder $builder) {

            if (Tenant::id()) {
                $builder->where(
                    $builder->getModel()->getTable().'.business_id',
                    Tenant::id()
                );
            }

        });
    }
}
