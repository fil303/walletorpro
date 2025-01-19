<?php

namespace App\Services\ExchangeService;

use App\Http\Requests\User\CoinExchangeRequest;
use App\Http\Requests\User\ExchangeRateRequest;

interface IExchangeService
{
    /**
     * Get All Coins
     * @return array
     */
    public function getAllCoins();

    /**
     * Exchange Coin
     * @param \App\Http\Requests\User\CoinExchangeRequest $request
     * @return array
     */
    public function exchangeCoinProcess(CoinExchangeRequest $request): array;

    /**
     * Get exchange rate
     * @param ExchangeRateRequest $request
     * @return array
     */
    public function getExchangeRate(ExchangeRateRequest $request): array;
}
