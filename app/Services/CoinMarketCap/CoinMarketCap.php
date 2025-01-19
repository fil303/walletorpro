<?php

namespace App\Services\CoinMarketCap;

use App\Services\CoinMarketCap\AppCoinMarketCap;

class CoinMarketCap implements AppCoinMarketCap {
    public static string $apiKey = '';
    protected string $host = "https://pro-api.coinmarketcap.com";
    protected string $version = "v2";

    public function __construct(){
        if(self::$apiKey == null)
        self::$apiKey = "9fd75d8c-6488-442a-8b75-3ef13166e33a";
    }

    /**
     * Get coin price
     * @param string $from
     * @param string $to
     * @param mixed $amount
     * @return array
     */
    public function getPriceConversion(string $from, string $to, $amount = 1): array
    {
        return $this->__request("tools/price-conversion?amount=$amount&symbol=$from&convert=$to", "GET");
    }

    /**
     * Get 3rd party coin price
     * @param string $from
     * @param string $to
     * @return array
     */
    public function get3rdPartyCoinPrice(string $from, string $to = 'USDT'): array
    {
        $this->host = "https://3rdparty-apis.coinmarketcap.com";
        $this->setVersion('v1');

        $response = $this->__request(
            endpoint: "cryptocurrency/widget?symbol=$from&convert=$to", 
            method  : "GET",
            header  : [
                "Content-Type: application/json",
                "Accept: application/json",
                "User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:130.0) Gecko/20100101 Firefox/130.0",
            ]
        );

        if(
            isset($response['status']) 
            && isset($response['data']['status']['error_code']) 
            && $response['data']['status']['error_code'] === 0
            && isset($response['data']['data'])
        ){
            $responseData = $response['data']['data'];
            $responseDataKeys = array_keys($responseData);
            $responseCoinCapMarketData = $responseData[$responseDataKeys[0] ?? 0] ?? [];

            if(!isset($responseCoinCapMarketData['quote'][$to]))
                return failed(_t("Price not found"));;

            $quoteData = $responseCoinCapMarketData['quote'][$to];
            $price = $quoteData['price'] ?? 0;
            if(!$price) return failed();

            $priceData = [
                "coin_name"     => $responseCoinCapMarketData['name'],
                "coin_code"     => $responseCoinCapMarketData['symbol'],
                "coin_rank"     => $responseCoinCapMarketData['cmc_rank'] ?? 0,
                "coin_price"    => $price,
                "is_fiat"       => $responseCoinCapMarketData['is_fiat'],
                "token_address" => $responseCoinCapMarketData['platform']['token_address'] ?? NULL,
                "change_24h"    => $quoteData['percent_change_24h'],
                "volume"        => $quoteData['market_cap'] ?? 0,
            ];

            return success($priceData);
        }   return failed();
    }

    protected function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * Send request to coin market cap api
     * @param string $endpoint
     * @param string $method
     * @param array<string> $params
     * @param array<string> $header
     * @return mixed
     */
    private function __request(string $endpoint, string $method, array $params = [], ?array $header = null): mixed
    {

        $body = http_build_query($params, '', '&');

        try {
            $header ??= [
                "Accept: application/json",
                "X-CMC_PRO_API_KEY: y" . self::$apiKey
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "$this->host/$this->version/$endpoint");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            if($method != 'GET') {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            }

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $res = curl_exec($ch);
            curl_close($ch);

            $response = json_decode((string)$res,true);
            return success(_t("Success"), $response);
        } catch (\Exception $e) {
            logStore("EvmWalletService __send", $e->getMessage());
            return failed(_t("Something went wrong"));
        }
    }
}