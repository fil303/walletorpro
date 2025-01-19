<?php

namespace App\Enums;

enum TwoFactor: string
{
    case GOOGLE = "google";
    case EMAIL  = "email";
    case PHONE  = "phone";

    public static function getAll(): array
    {
        return [
            (self::GOOGLE)->value => _t("Google Authenticator"),
            (self::EMAIL)->value  => _t("Email"),
            (self::PHONE)->value  => _t("Phone"),
        ];
    }
}