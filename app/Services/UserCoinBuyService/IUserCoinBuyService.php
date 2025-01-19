<?php

namespace App\Services\UserCoinBuyService;

use Illuminate\Http\Request;
use App\Http\Requests\User\BuyCryptoRequest;
use App\Http\Requests\User\getCryptoPriceRequest;

interface IUserCoinBuyService
{
    /**
     * Get Crypto Price
     * @param \App\Http\Requests\User\getCryptoPriceRequest $request
     * @return array
     */
    public function getCryptoPrice(getCryptoPriceRequest $request): array;

    /**
     * this method will get buy coin page data to render on website
     * @return array
     */
    public function getBuyCoinPageData (): array;

    /**
     * Crypto Buy Process
     * @param \App\Http\Requests\User\BuyCryptoRequest $request
     * @return array
     */
    public function cryptoBuyProcess(BuyCryptoRequest $request): array;

    /**
     * Get Payment Method By Currency
     * @param string $currency
     * @return array
     */
    public function getPaymentMethodByCurrency(string $currency): array;

    /**
     * Coin purchase process
     * @param \App\Http\Requests\User\BuyCryptoRequest $request
     * @return array
     */
    public function coinBuyProcess(BuyCryptoRequest $request): array;

    /**
     * Cancel Coin Order
     * @param string $gatewayUid
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cancelCoinOrder(string $gatewayUid, Request $request): array;

    /**
     * Confiirm Coin Order
     * @param string $gatewayUid
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function confirmCoinOrder(String $gatewayUid, Request $request): array;

    /**
     * Coin Order Ipn
     * @param string $gatewayUid
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function coinOrderIpn(String $gatewayUid, Request $request): array;
}
