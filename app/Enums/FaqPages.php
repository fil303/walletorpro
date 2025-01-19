<?php

namespace App\Enums;
use App\Services\CoinPaymentService\CoinPaymentService;
use App\Services\CoinProviderService\AppCoinProviderService;

enum FaqPages: string
{
    case CRYPTO_DEPOSIT = 'crypto_deposit';
    case CRYPTO_WITHDRAWAL = 'crypto_withdrawal';
    case CRYPTO_BUY = 'crypto_buy';
    case HOME = 'home';

    public function getTitle(): ?string
    {
        $pages = self::getAll();
        return $pages[enum($this)] ?? null;
    }

    /**
     * This method will return all enum case as array
     * @return array<string, string>
     */
    public static function getAll(): array
    {
        return [
            (self::HOME)->value              => _t("Home"),
            (self::CRYPTO_DEPOSIT)->value    => _t("Crypto Deposit"),
            (self::CRYPTO_WITHDRAWAL)->value => _t("Crypto Withdrawal"),
            (self::CRYPTO_BUY)->value        => _t("Crypto Buy"),
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