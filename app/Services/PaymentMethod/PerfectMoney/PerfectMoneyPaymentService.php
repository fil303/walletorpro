<?php

namespace App\Services\PaymentMethod\PerfectMoney;

use App\Models\CoinOrder;
use App\Models\GatewayExtra;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use App\Services\PaymentMethod\PaymentMethod;
use Illuminate\Http\Request;

class PerfectMoneyPaymentService implements PaymentMethod
{
    /**
     * Perfect money payment response verify
     * 
     * @param string $gateway
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function verify(string $gateway, Request $request): array
    {
        $gatewayCredentials = GatewayExtra::get()->toSlugValue();

        $alternate_passphrase = "";
        if($gatewayCredentials->alternate_passphrase)
            $alternate_passphrase = strtoupper(md5($gatewayCredentials->alternate_passphrase ?? '')).":";

        $string =
            "$request->PAYMENT_ID:$request->PAYEE_ACCOUNT:".
            "$request->PAYMENT_AMOUNT:$request->PAYMENT_UNITS:".
            "$request->PAYMENT_BATCH_NUM:$request->PAYER_ACCOUNT:".
            "$alternate_passphrase$request->TIMESTAMPGMT";

        $hash=strtoupper(md5($string));

        if(!($hash === $request->V2_HASH))
            return failed("Perfect money "._t("payment failed"));
        return success("Perfect money "._t("payment success"));
    }

    /**
     * Perfect money payment checkout_url generate
     * 
     * @param \App\Models\PaymentGateway $gateway
     * @param \App\Models\CoinOrder $order
     * @return array<string, mixed>
     */
    public function checkout_url(PaymentGateway $gateway, CoinOrder $order): array
    {
        $gatewayCredentials = GatewayExtra::where('payment_gateway_uid', $gateway->uid)->get()->toSlugValue();

        $data['redirect_on_page'] = true;
        $data['view']   = "payments.redirector";
        $data['action'] = "https://perfectmoney.is/api/step1.asp";
        $data['method'] = "POST";
        $data['inputs'] = [
            'PAYEE_ACCOUNT' => $order->currency_code == 'USD' ? $gatewayCredentials->pm_usd_wallet ?? '' : $gatewayCredentials->pm_eur_wallet ?? '',
            'PAYEE_NAME'    => get_settings('app_name'),
            'PAYMENT_ID'    => $order->uid,
            'PAYMENT_AMOUNT'=> 0.01, //round($order->total_price,2),
            'PAYMENT_UNITS' => $order->currency_code,
            'STATUS_URL'    => route("coinBuyPaymentIpn", $gateway->uid),
            'PAYMENT_URL'   => route("coinBuyConfirm", $gateway->uid),
            'NOPAYMENT_URL' => route("coinBuyCancel", $gateway->uid),
            'SUGGESTED_MEMO'=> Auth::user()->username,
            'BAGGAGE_FIELDS'=> 'IDENT',
            'PAYMENT_URL_METHOD'   => 'GET',
            'NOPAYMENT_URL_METHOD' => 'GET',
        ];

        return $data;
    }
}
