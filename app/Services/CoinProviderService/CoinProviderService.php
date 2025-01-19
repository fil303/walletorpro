<?php

namespace App\Services\CoinProviderService;

use App\Models\Coin;
use App\Services\CoinService\CoinService;
use App\Services\ResponseService\Response;
use App\Services\CoinProviderService\AppCoinProviderService;

class CoinProviderService
{

    public function __construct(){}

    /**
     * Generate Coin Wallet address
     * @param \App\Models\Coin $coin
     * @return array|null
     */
    public function address(Coin $coin): ?array
    {
        if(!$providerType = $coin->provider)
            Response::throw(
                failed(_t("Coin provider not found"))
            );

        if(!$coinProvider = $providerType->getCoinProvider())
            Response::throw(
                failed(_t("Provider service not found"))
            );

        return $coinProvider->getAddress($coin->code);
    }

    /**
     * Send Coins To External Address
     * @param \App\Models\Coin $coin
     * @param array<string, string> $requestData
     * @return array
     */
    public function sendCoins(Coin $coin, array $requestData): array
    {
        if(!$providerType = $coin->provider)
            Response::throw(
                failed(_t("Coin provider not found"))
            );

        if(!$coinProvider = $providerType->getCoinProvider())
            Response::throw(
                failed(_t("Provider service not found"))
            );

        return $coinProvider->sendCoins($requestData);
    }
}
