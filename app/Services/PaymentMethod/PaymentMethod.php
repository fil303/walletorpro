<?php

namespace App\Services\PaymentMethod;

use App\Models\CoinOrder;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;

interface PaymentMethod
{
    /**
     * Verify Payment
     * @param string $gateway
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function verify(string $gateway, Request $request): array;

    /**
     * Prepare Payment Data for Payment Gateway
     * @param \App\Models\PaymentGateway $gateway
     * @param \App\Models\CoinOrder $order
     * @return array<mixed>
     */
    public function checkout_url(PaymentGateway $gateway, CoinOrder $order): array;
}
