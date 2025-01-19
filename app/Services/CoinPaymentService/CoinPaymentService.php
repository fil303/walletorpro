<?php

namespace App\Services\CoinPaymentService;

use GuzzleHttp\Client;
use App\Services\CoinProviderService\AppCoinProviderService;

/**
 * CoinPayment Service
 * @template T
 * @implements AppCoinProviderService<T>
 */
class CoinPaymentService implements AppCoinProviderService
{
    private string $host;
    public function __construct(){
        $this->host = 'https://www.coinpayments.net/api.php';
    }

    /**
     * Get Address Form CoinPayment
     * @param string $coin
     * @return array<string, T>
     */
    public function getAddress(string $coin): array
    {
        return $this->getCallbackAddress($coin);
    }
    
    /**
     * Send Coins to Address Through CoinPayment
     * @param array<string, T> $requestData
     * @return array<string, T>
     */
    public function sendCoins(array $requestData): array
    {
		$req = [
			'amount'   => $requestData["amount"]   ?? 0,
			'currency' => $requestData["currency"] ?? '',
			'address'  => $requestData["address"]  ?? '',
			'ipn_url'  => $requestData["ipn_url"]  ?? '',
            'dest_tag' => $requestData["dest_tag"] ?? "",
		    'auto_confirm' => $requestData["auto_confirm"] ?? 0,
        ];
        return $this->__fire('create_withdrawal', $req);
    }

    /**
     * Get CoinPayment Coin Address
     * @param string $currency 
     * @param string $ipn_url
     * @return array
     */
    private function getCallbackAddress(string $currency, string $ipn_url = ''): array
    {
        $req = array(
            'currency' => $currency,
            'ipn_url' => $ipn_url,
        );
        return $this->__fire('get_callback_address', $req);
    }


    /**
     * Send Request to CoinPayment api
     * @param string $cmd
     * @param array<mixed> $options
     * @return array<string, T>
     */
    private function __fire(string $cmd, array $options = []): array
    {

        $options['version'] = 1;
        $options['cmd'] = $cmd;
        $options['key'] = get_settings("coin_payment_public_key");
        $options['format'] = 'json';

        $body = http_build_query($options, '', '&');
        $hmac = hash_hmac('sha512', $body, get_settings("coin_payment_private_key"));

        try {
            $header = [ "HMAC: $hmac" ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->host);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            // if($method != 'GET') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            // }

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
