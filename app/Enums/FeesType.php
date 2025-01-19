<?php

namespace App\Enums;
use App\Services\CoinPaymentService\CoinPaymentService;
use App\Services\CoinProviderService\AppCoinProviderService;

enum FeesType: int
{
    case FIXED   = 1;
    case PERCENT = 2;

    /**
     * This method will return all enum case as array
     * @return array<int, string>
     */
    public static function getAll(): array
    {
        return [
            (self::FIXED)->value   => _t("Fixed"),
            (self::PERCENT)->value => _t("Percent"),
        ];
    }

    public static function renderOption(string $typeParam = ""): string
    {
        $types = self::getAll();
        $html = "";

        foreach($types as $type => $typeName){
            $type_select = ($typeParam == $type)? "selected": "";
            $html .= "<option value=\"$type\" $type_select>$typeName</option>";
        }

        return $html;
    }

    public function calculateFees(float $amount, float $fees): float {
        return match($this){
            FeesType::FIXED   => $fees,
            FeesType::PERCENT => ($fees * $amount) / 100,
        };
    }
}