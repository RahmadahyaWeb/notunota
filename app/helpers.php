<?php

use App\Models\Business;
use App\Services\Tenant;

function tenant()
{
    return Business::findOrFail(Tenant::id());
}
