<?php

namespace App\Enums;

enum SupportTicketStatus: string
{
    case OPEN     = 'open';
    case PENDING  = 'pending';
    case ANSWERED = 'answered';
    case CLOSED   = 'closed';

    /**
     * This method will return all enum case as array
     * @return array<string, string>
     */
    public static function getAll(): array
    {
        return [
            (self::OPEN)->value     => _t("Open"),
            (self::PENDING)->value  => _t("Pending"),
            (self::ANSWERED)->value => _t("Answer"),
            (self::CLOSED)->value   => _t("Closed"),
        ];
    }

    public static function setReplayStatus(): array
    {
        return [
            (self::ANSWERED)->value => _t("Answer"),
            (self::PENDING)->value  => _t("Pending"),
        ];
    }

    public function value(): string
    {
        return match ($this) {
            self::OPEN     => _t("Open"),
            self::PENDING  => _t("Pending"),
            self::ANSWERED => _t("Answered"),
            self::CLOSED   => _t("Closed"),
        };
    }
}