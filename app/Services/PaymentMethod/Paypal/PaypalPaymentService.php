<?php

namespace App\Services\PaymentMethod\Paypal;

use App\Models\CoinOrder;
use App\Models\GatewayExtra;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Services\PaymentMethod\PaymentMethod;

class PaypalPaymentService implements PaymentMethod
{
    /**
     * Verify Payment
     * @param string $gateway
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function verify(string $gateway, Request $request): array
    {
        $gatewayCredentials = GatewayExtra::get()->toSlugValue();

        /** @var string $raw_ipn_data */
        $raw_ipn_data = file_get_contents('php://input');
        $raw_ipn_array = explode('&', $raw_ipn_data);
        $parsedData = [];
        foreach ($raw_ipn_array as $pair) {
            $pair = explode('=', $pair);
            if (count($pair) == 2) {
                $parsedData[$pair[0]] = urldecode($pair[1]);
            }
        }

        $validation_req = 'cmd=_notify-validate';
        foreach ($parsedData as $key => $value) {
            $value = urlencode($value);
            $validation_req .= "&$key=$value";
        }

        $curl_handle = curl_init("https://ipnpb.paypal.com/cgi-bin/webscr");
        if(isset($gatewayCredentials->paypal_mode) && $gatewayCredentials->paypal_mode == 'test')
            $curl_handle = curl_init("https://ipnpb.sandbox.paypal.com/cgi-bin/webscr");

        curl_setopt($curl_handle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $validation_req);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, ['Connection: Close']);

        $paypal_response = curl_exec($curl_handle);
        if (!$paypal_response) {
            curl_close($curl_handle);
            logStore("paypal ipn", "paypal transaction curl response invalid .".'Error: "' .
                curl_error($curl_handle) . '" - Code: ' . curl_errno($curl_handle)
            );
            return failed("Paypal "._t("payment failed"));
        }
        curl_close($curl_handle);

        /** @var string $paypal_response */
        if (strcmp($paypal_response , "VERIFIED") == 0) {

            $payment_status = $request->payment_status;
            $transaction_id = $request->txn_id;
            $receiver_email = $request->receiver_email;
            $amount_paid    = $request->mc_gross;
            $currency       = $request->mc_currency;
            
            if ($payment_status == "Completed" && $receiver_email == $gatewayCredentials->paypal_email) {
                return success("Paypal "._t("payment success"));
            }

            logStore("paypal ipn", "paypal transaction not completed or email invalid");
            return failed("Paypal "._t("payment failed"));
        }
        logStore("paypal ipn", "paypal transaction not valid");
        return failed("Paypal "._t("payment failed"));
    }

    /**
     * Prepare Payment Data for Payment Gateway
     * @param \App\Models\PaymentGateway $gateway
     * @param \App\Models\CoinOrder $order
     * @return array<mixed>
     */
    public function checkout_url(PaymentGateway $gateway, CoinOrder $order): array
    {
        $gatewayCredentials = GatewayExtra::get()->toSlugValue();
        $paypal_url = "https://www.paypal.com/cgi-bin/webscr";

        if(isset($gatewayCredentials->paypal_mode) && $gatewayCredentials->paypal_mode == 'test')
            $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";

        $data['redirect_on_page'] = true;
        $data['view']   = "payments.redirector";
        $data['action'] = $paypal_url;
        $data['method'] = "POST";
        $data['inputs'] = [
            "cmd"       => '_xclick',
            "business"  => trim($gatewayCredentials->paypal_email),
            "cbt"       => "cbt IdotNjotKgnosw",
            "currency_code" => $order->currency_code,
            "quantity"  => 1,
            "item_name" => "Payment To Buy $order->coin",
            "custom"    => $order->uid,
            "amount"    => round($order->total_price,2),
            "return"    => route("coinBuyConfirm", [
                "gateway"   => $gateway->uid,
                "order_uid" => $order->uid 
           ]),
            "cancel_return" => route("coinBuyCancel", [
                "gateway"   => $gateway->uid,
                "order_uid" => $order->uid 
            ]),
            "notify_url" => route('coinBuyPaymentIpn', $gateway->uid),
        ];

        return $data;
    }
}
