<?php

namespace App\Enums;

enum UserRole: int
{
    case ALL = 0;
    case SUPERADMIN = 1;
    case ADMIN = 2;
    case USER = 3;

    /**
     * Check for super admin
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return match ($this) {
            self::SUPERADMIN => TRUE,
            default => FALSE
        };
    }

    /**
     * Check for admin
     * @return bool
     */
    public function isAdmin(): bool
    {
        return match ($this) {
            self::SUPERADMIN, self::ADMIN => TRUE,
            default => FALSE
        };
    }

    /**
     * Check for user
     * @return bool
     */
    public function isUser(): bool
    {
        return match ($this) {
            self::USER => TRUE,
            default => FALSE
        };
    }
}