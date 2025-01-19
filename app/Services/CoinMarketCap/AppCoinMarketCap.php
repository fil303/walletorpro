<?php

namespace App\Services\CoinMarketCap;

interface AppCoinMarketCap {
    /**
     * Get coin price from CoinCapMarket by using Basic plan api
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return array
     */
    public function getPriceConversion(string $from, string $to, float $amount = 1): array;

    /**
     * Get coin details from CoinCapMarket by using widget url
     * 
     * @param string $from
     * @param string $to
     * @return array
     */
    public function get3rdPartyCoinPrice(string $from, string $to = 'USDT'): array;
}
