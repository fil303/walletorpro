<?php

namespace App\Services\CoinTransactionService;

use Exception;
use App\Models\Coin;
use Illuminate\Support\Facades\DB;
use App\Models\BuyCryptoTransaction;
use App\Services\CoinService\CoinService;
use App\Services\ResponseService\Response;
use App\Http\Requests\User\BuyCryptoRequest;
use App\Services\CoinMarketCap\CoinMarketCap;
use App\Services\WalletService\WalletService;
use App\Http\Requests\User\getCryptoPriceRequest;

class CoinTransactionService implements AppCoinTransactionService
{
    public function __construct(){}

    /**
     * Get Crypto Price
     * @param \App\Http\Requests\User\getCryptoPriceRequest $request
     * @return array
     */
    public function getCryptoPrice(getCryptoPriceRequest $request): array
    {
        $coinMarketCap = new CoinMarketCap();

        $response = $coinMarketCap->getPriceConversion(
            $request->crypto,
            $request->currency
        );

        $responseData = isset($response['data'][0]) ? $response['data'][0] : [];
        $quoteData = $responseData['quote'] ?? [];
        $price = $quoteData[$request->currency]['price'] ?? 0;

        return success(_t("Crypto price get successfully"), [
            "price" => $price,
            "total" => $request->amount * $price
        ]);
    }

    /**
     * Crypto Buy Process
     * @param \App\Http\Requests\User\BuyCryptoRequest $request
     * @return array
     */
    public function cryptoBuyProcess(BuyCryptoRequest $request): array
    {
        /**  @var Coin $crypto */
        $crypto   = CoinService::getCoinByCoin($request->crypto,   true, 'coinBuyPage');
        
        /**  @var Coin $currency */
        $currency = CoinService::getCoinByCoin($request->currency, true, 'coinBuyPage');

        $cryptoWallet   = WalletService::createAndGetUserWallet($request->crypto,   true, true, 'coinBuyPage');
        $currencyWallet = WalletService::createAndGetUserWallet($request->currency, true, true, 'coinBuyPage');

        $amount         = to_decimal($request->amount, $crypto->decimal);
        $fees           = to_decimal(0.5, $currency->decimal);
        $ui_fees        = to_coin($fees, $currency->decimal);
        $price          = to_decimal(5,   $currency->decimal);
        $total_spend    = $price + $fees;
        $ui_total_spend = to_coin($total_spend, $currency->decimal);

        $checkSpendBalance = WalletService::checkWalletBalanceOrThrow($total_spend, $currencyWallet);

        if(!($checkSpendBalance['status'] ?? false))
            return failed(_t("You don't have sufficient balance to pay"));

        DB::beginTransaction();
        try {
            if(! $currencyWallet?->decrement("balance", $total_spend))
                return failed(_t('Failed to spend currency'));

            if(! $cryptoWallet?->increment("balance", $amount))
                return failed(_t('Failed to receive coin'));

            BuyCryptoTransaction::create([
                "receive_coin_id" => $crypto->id,
                "spend_coin_id"   => $currency->id,
                "receive_coin"    => $crypto->coin,
                "spend_coin"      => $currency->coin,
                "amount"          => $amount,
                "spend_amount"    => $total_spend,
                "fees"            => $fees,
                "rate"            => 0,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            logStore("cryptoBuyProcess :", $e->getMessage());
            return failed($e->getMessage());
        }
        
        DB::commit();
        return success("You successfully purchased crypto");
    }
}
