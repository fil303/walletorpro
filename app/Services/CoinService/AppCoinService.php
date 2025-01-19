<?php

namespace App\Services\CoinService;

use App\Models\Coin;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Requests\Admin\UpdateCurrencyRequest;

interface AppCoinService
{
    /**
     * Get Coin By Uid
     * @param string $uid
     * @return ?Coin
     */
    public static function getCoinByUid(string $uid): ?Coin;

    /**
     * Get Coin By Coin
     * @param string $coin
     * @param bool $throw
     * @param string $redirect
     * @return ?Coin
     */
    public static function getCoinByCoin(string $coin, bool $throw = false, string $redirect = ""): ?Coin;

    /**
     * Save New Currency
     * @param array<string, string> $newCurrency
     * @return ?Coin
     */
    public function saveNewCurrency(array $newCurrency): ?Coin;

    /**
     * Update Coin
     * @param \App\Http\Requests\Admin\UpdateCurrencyRequest $request
     * @return array
     */
    public function updateCoin(UpdateCurrencyRequest $request): array;

    /**
     * Update Coin Status
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function updateCoinStatus(Request $request):array;

    /**
     * Delete Coin
     * @param string $uid
     * @return array
     */
    public function deleteCoin(string $uid):array;

    /**
     * Update Active Coin Price
     * @return void
     */
    public function updateActiveCoinPrice(): void;

    /**
     * Get Coins by Coin
     * @param string $coin
     * @return \Illuminate\Support\Collection
     */
    public static function getCoinsByCoin(string $coin): Collection;
}
