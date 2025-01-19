<?php
namespace App\Services\PaymentGatewayService;

use App\Models\PaymentGateway;
use App\Http\Requests\Admin\UpdateGatewayRequest;
use App\Http\Requests\Admin\AddGatewayCurrencyRequest;

interface AppPaymentGatewayService
{
    /**
     * Get Payment Gateway By Uid And Currency
     * @param string $uid
     * @param string $currency
     * @param bool $throw
     * @param string $redirect
     * @return PaymentGateway|null
     */
    public function getPaymentGatewayByUidAndCurrency(string $uid, string $currency, bool $throw = false, string $redirect = null): ?PaymentGateway;

    /**
     * Get Payment Gateway By Uid
     * @param string $uid
     * @param bool $throw
     * @param string $redirect
     * @return PaymentGateway|null
     */
    public function getPaymentGatewayByUid(string $uid, bool $throw = false, string $redirect = null): ?PaymentGateway;

    /**
     * Update Payment Gateway
     * @param \App\Http\Requests\Admin\UpdateGatewayRequest $request
     * @return array
     */
    public function updatePaymentGateway(UpdateGatewayRequest $request): array;

    /**
     * Update Payment Gateway Status
     * @param \App\Models\PaymentGateway $gateway
     * @return array
     */
    public function changeGatewayStatus(PaymentGateway $gateway): array;

    /**
     * Add new currency to a payment gateway
     * @param \App\Http\Requests\Admin\AddGatewayCurrencyRequest $request
     * @return array
     */
    public function addGatewayCurrency(AddGatewayCurrencyRequest $request): array;

    /**
     * Remove a currency from payment gateway
     * @param string $uid
     * @param string $currency_code
     * @return array
     */
    public function deleteGatewayCurrency(string $uid, string $currency_code): array;
}