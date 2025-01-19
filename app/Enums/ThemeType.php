<?php

namespace App\Enums;

enum ThemeType: string
{
    case PRE_BUILD = "pre-build";
    case CUSTOM    = "custom";

    public static function getAll(): array
    {
        return [
            self::PRE_BUILD->value => _t("Pre-Build Theme"),
            self::CUSTOM->value    => _t("Custom Theme")
        ];
    }
}