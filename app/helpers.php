<?php

use App\Models\Business;
use App\Services\Tenant;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

function tenant()
{
    return Business::findOrFail(Tenant::id());
}

function authorize_model(string $ability, string $modelClass, $id, array $extra = [])
{
    $model = $modelClass::findOrFail($id);

    Gate::authorize($ability, array_merge([$model], $extra));

    return $model;
}

function canBusiness($permission, $businessId = null)
{
    $businessId ??= tenant()->id;

    return auth()->user()?->hasBusinessPermission($businessId, $permission);
}

function authorize_action(callable $callback, ?callable $onDenied = null)
{
    try {
        return $callback();
    } catch (AuthorizationException $e) {
        if ($onDenied) {
            return $onDenied($e);
        }

        return null;
    }
}
