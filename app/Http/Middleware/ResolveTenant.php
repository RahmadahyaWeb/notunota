<?php

namespace App\Http\Middleware;

use App\Services\Tenant;
use Closure;
use Illuminate\Http\Request;

class ResolveTenant
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {

            $business = auth()->user()
                ->businesses()
                ->first();

            if ($business) {
                Tenant::set($business->id);
            }
        }

        return $next($request);
    }
}
