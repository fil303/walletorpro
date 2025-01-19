<?php

namespace App\Enums;
use App\Services\CoinPaymentService\CoinPaymentService;
use App\Services\CoinProviderService\AppCoinProviderService;

enum CurrencyType: string
{
    case CRYPTO = 'c';
    case FIAT = 'f';

    /**
     * This method will return all enum case as array
     * @return array<string, string>
     */
    public static function getAll(): array
    {
        return [
            (self::CRYPTO)->value  => "Crypto",
            (self::FIAT)->value      => "Fiat",
        ];
    }

    public static function renderOption(string $pageParam = ""): string
    {
        $pages = self::getAll();
        $html = "";

        foreach($pages as $page => $pageName){
            $page_select = ($pageParam == $page)? "selected": "";
            $html .= "<option value=\"$page\" $page_select>$pageName</option>";
        }

        return $html;
    }
}