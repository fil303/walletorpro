<?php

namespace App\Services\CoinProviderService;

/**
 * Coin Provider Service Interface
 * 
 * @template T
 */
interface AppCoinProviderService
{
    /**
     * Get Address Form CoinPayment
     * @param string $coin
     * @return array<string, T>
     */
    public function getAddress(string $coin): ?array;

    /**
     * Send Coins to Address Through CoinPayment
     * @param array<string, T> $requestData
     * @return array<string, T>
     */
    public function sendCoins(array $requestData): array;
}
