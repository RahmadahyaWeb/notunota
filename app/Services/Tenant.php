<?php

namespace App\Services;

class Tenant
{
    protected static $business_id;

    public static function set($businessId)
    {
        static::$business_id = $businessId;
    }

    public static function id()
    {
        return static::$business_id;
    }
}
