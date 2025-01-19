<?php

namespace App\Types;

class CoinOrderType
{
    public function __construct(
        public string $uid,
        public int    $user_id,
        public int    $wallet_id,
        public int    $coin_id,
        public int    $currency_id,
        public int    $payment_id,
        public string $coin,
        public string $coin_code,
        public string $currency_code,
        public string $payment_slug,
        public float  $rate,
        public float  $amount,
        public float  $fees,
        public float  $net_price,
        public float  $total_price,
        public bool   $status,
        public string $transaction_id
    ){}
}
