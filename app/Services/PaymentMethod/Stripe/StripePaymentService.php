<?php

namespace App\Services\PaymentMethod\Stripe;

use Stripe\StripeClient;
use App\Models\CoinOrder;
use App\Models\GatewayExtra;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use Exception;

class StripePaymentService
{
    /**
     * Prepare Payment Data for Payment Gateway
     * @param \App\Models\PaymentGateway $gateway
     * @param \App\Models\CoinOrder $order
     * @return array<mixed>
     */
    public function checkout_url(PaymentGateway $gateway, CoinOrder $order): array
    {
        $gatewayCredentials = GatewayExtra::where('payment_gateway_uid', $gateway->uid)->get()->toSlugValue();
        $stripe = new StripeClient($gatewayCredentials->stripe_secret_key ?? '');

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency'     => $order->currency_code ?? 'usd',
                    'product_data' => ['name' => $order->coin ?? 'USDT'],
                    'unit_amount'  => (int)($order->total_price * 100),
                ],
                'quantity' => 1,
            ]],
            // "automatic_tax" => [ "enabled" => true ],
            'phone_number_collection' => [ 'enabled' => false ],
            'mode' => 'payment',
            'success_url' => route("coinBuyConfirm", [ "gateway" => $gateway->uid, "order_uid" => $order->uid]),
            'cancel_url'  => route("coinBuyCancel", [ "gateway" => $gateway->uid, "order_uid" => $order->uid]),
            'payment_intent_data' => [
                'metadata' => [
                    'order_id' => $order->uid ?? '123',
                ],
            ],
        ]);

        $data['redirect_on_page'] = true;
        $data['view']   = "payments.redirector";
        $data['action'] = $checkout_session->url ?? '';
        $data['method'] = "GET";
        $data['inputs'] = [];

        return $data;
    }

    public function verify(string $gateway, Request $request): array
    {
        $gatewayCredentials = GatewayExtra::get()->toSlugValue();

        /** @var string $payload */
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $gatewayCredentials->stripe_webhook_endpoint_secret ?? ''
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            logStore("Stripe UnexpectedValueException", $e->getMessage());
            return failed("Stripe "._t("payment failed"));
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            logStore("Stripe SignatureVerificationException", $e->getMessage());
            return failed("Stripe "._t("payment failed"));
        }
        
        if ($event->type == "payment_intent.succeeded") {
            // $intent = $event->data?->object;
            // logStore("Succeeded: %s", $intent->id);
            return success("Stripe "._t("payment success"));

        } elseif ($event->type == "payment_intent.payment_failed") {
            // $intent = $event->data?->object;
            // $error_message = $intent->last_payment_error ? $intent->last_payment_error->message : "";
            // logStore("Failed: %s, %s", $intent->id, $error_message);
            return failed("Stripe "._t("payment failed"));
        }
        return failed("Stripe "._t("payment failed"));
    }
}
