<?php

namespace App\Enums;
use App\Services\CoinPaymentService\CoinPaymentService;
use App\Services\CoinProviderService\AppCoinProviderService;

enum CryptoProvider: string
{
    case COINPAYMENT = 'coin_payment';
    case BITGO = 'bitgo';
    case BLOCKIO = 'block_io';

    /**
     * This method will return all enum case as array
     * @return array<string, string>
     */
    public static function getAll(): array
    {
        return [
            (self::COINPAYMENT)->value  => "Coin Payment",
            (self::BITGO)->value        => "Bitgo",
            (self::BLOCKIO)->value      => "BlockIo",
        ];
    }

    /**
     * Get Coin Provider
     * @return ?CoinPaymentService<string>
     */
    public function getCoinProvider(): ?AppCoinProviderService
    {
        return match ($this) {
            self::COINPAYMENT => new CoinPaymentService(),
            // self::BITGO       => new \stdClass,

            default => null
        };
    }

    /**
     * Render Select Option
     * @param string $keyParam
     * @return string
     */
    public static function renderOption(string $keyParam = ""): string
    {
        $providers = self::getAll();
        $html = "";

        foreach($providers as $key => $provider){
            $key_select = ($keyParam == $key)? "selected": "";
            $html .= "<option value=\"$key\" $key_select>$provider</option>";
        }

        return $html;
    }
}