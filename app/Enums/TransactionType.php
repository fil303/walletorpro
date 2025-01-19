<?php

namespace App\Enums;

enum TransactionType: int
{
    case EXTERNAL = 1;
    case INTERNAL = 2;

    public function getTypeName(): string
    {
        return match ($this) {
            self::EXTERNAL => 'External',
            self::INTERNAL => 'Internal',
        };
    }
}