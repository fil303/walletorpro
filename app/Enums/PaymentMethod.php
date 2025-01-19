<?php

namespace App\Enums;

use App\Services\PaymentMethod\Paypal\PaypalPaymentService;
use App\Services\PaymentMethod\Stripe\StripePaymentService;
use App\Services\PaymentMethod\PerfectMoney\PerfectMoneyPaymentService;
use App\Services\PaymentMethod\PaymentMethod as PaymentMethodInterface;

/**
 * Get Payment Method
 * 
 * @return string
 */
enum PaymentMethod: string
{
    case PAYPAL = 'paypal';
    case STRIPE = 'stripe';
    case PERFECT_MONEY = 'perfect_money';

    /**
     * This method will return all enum case as array
     * @return array<string, string>
     */
    public static function getAll(): array
    {
        return [
            (self::PAYPAL)->value        => "Paypal",
            (self::STRIPE)->value        => "Stripe",
            (self::PERFECT_MONEY)->value => "Perfect Money",
        ];
    }

    /**
     * Get payment method by provide payment slug
     * 
     * @return PaypalPaymentService|StripePaymentService|PerfectMoneyPaymentService
     */
    public function getPaymentMethod(): PaypalPaymentService|StripePaymentService|PerfectMoneyPaymentService
    {
        return match ($this) {
            self::PAYPAL => new PaypalPaymentService(),
            self::STRIPE => new StripePaymentService(),
            self::PERFECT_MONEY => new PerfectMoneyPaymentService(),
        };
    }

    /**
     * Generate html option tags for select box to render on web page
     * @param string $paymentMethodSlugParam
     * @return string
     */
    public static function renderOption(string $paymentMethodSlugParam = ""): string
    {
        $paymentMethods = self::getAll();
        $html = "";

        foreach($paymentMethods as $paymentMethodSlug => $paymentMethod){
            $key_select = ($paymentMethodSlugParam == $paymentMethodSlug)? "selected": "";
            $html .= "<option value=\"$paymentMethodSlug\" $key_select>$paymentMethod</option>";
        }

        return $html;
    }
}