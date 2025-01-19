<?php

namespace App\Services\CoinTransactionService;

use App\Http\Requests\User\BuyCryptoRequest;
use App\Http\Requests\User\getCryptoPriceRequest;

interface AppCoinTransactionService
{
    /**
     * Get Crypto Price
     * @param \App\Http\Requests\User\getCryptoPriceRequest $request
     * @return array
     */
    public function getCryptoPrice(getCryptoPriceRequest $request): array;

    /**
     * Crypto Buy Process
     * @param \App\Http\Requests\User\BuyCryptoRequest $request
     * @return array
     */
    public function cryptoBuyProcess(BuyCryptoRequest $request): array;
}
