<?php

namespace App\Services;

use App\Models\Organization;

class Tenant
{
    protected static ?Organization $organization = null;

    public static function set(Organization $organization): void
    {
        static::$organization = $organization;
    }

    public static function current(): ?Organization
    {
        return static::$organization;
    }
}
