<?php

namespace App\Enums;

enum WithdrawalStatus: int
{
    case PENDING = 0;
    case COMPLETED = 1;
    case REJECTED = 2;

    public function getStatus(): string
    {
        return match ($this) {
            self::PENDING   => _t("Pending"),
            self::COMPLETED => _t("Completed"),
            self::REJECTED  => _t("Rejected"),
        };
    }
}