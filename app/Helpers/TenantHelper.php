<?php

namespace App\Helpers;

use App\Models\Library;
use Illuminate\Support\Facades\Session;

class TenantHelper
{
    /**
     * Get the current tenant library
     */
    public static function current(): ?Library
    {
        return Session::get('tenant_library') ?? app()->make('tenant_library', fn() => null);
    }

    /**
     * Get the current tenant's UID
     */
    public static function uid(): ?string
    {
        return static::current()?->uid;
    }

    /**
     * Check if we're in a multi-tenant context
     */
    public static function isSet(): bool
    {
        return static::current() !== null;
    }

    /**
     * Get library by subdomain
     */
    public static function bySubdomain(string $subdomain): ?Library
    {
        return Library::bySubdomain($subdomain)->first();
    }

    /**
     * Get library by UID
     */
    public static function byUid(string $uid): ?Library
    {
        return Library::where('uid', $uid)->first();
    }
}
