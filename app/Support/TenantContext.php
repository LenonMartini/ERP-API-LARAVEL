<?php

namespace App\Support;

class TenantContext
{
    private static ?int $tenantId = null;

    private static ?string $userType = null;

    private static bool $ready = false;

    public static function set(?int $tenantId, ?string $userType): void
    {
        self::$tenantId = $tenantId;
        self::$userType = $userType;
        self::$ready = true;
    }

    public static function tenantId(): ?int
    {
        return self::$tenantId;
    }

    public static function userType(): ?string
    {
        return self::$userType;
    }

    public static function isSystem(): bool
    {
        return self::$userType === 'SYSTEM';
    }

    public static function ready(): bool
    {
        return self::$ready;
    }
}
