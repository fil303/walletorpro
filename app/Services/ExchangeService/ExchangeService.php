<?php

namespace App\Services\ExchangeService;

use Exception;
use App\Models\Coin;
use App\Models\Wallet;
use App\Enums\CurrencyType;
use App\Enums\FeesType;
use App\Mail\CoinExchanged;
use App\Models\CoinExchange;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\CoinService\CoinService;
use App\Services\CoinMarketCap\CoinMarketCap;
use App\Services\WalletService\WalletService;
use App\Http\Requests\User\CoinExchangeRequest;
use App\Http\Requests\User\ExchangeRateRequest;
use App\Services\WalletService\AppWalletService;
use App\Jobs\Sms\CoinExchanged as SendSMSCoinExchanged;
use App\Services\ExchangeService\IExchangeService;
use App\Services\WalletService\WalletServiceTrait;

class ExchangeService implements IExchangeService
{
    use WalletServiceTrait;
    /**
     * Get All Coins
     * @return array
     */
    public function getAllCoins()
    {
        $data['coins'] = Coin::activeCoins(CurrencyType::CRYPTO)->select(['coin', 'name'])->get(); //->groupBy(['coin'])
        return success(_t("Success"), $data);
    }

    /**
     * Exchange Coin
     * @param \App\Http\Requests\User\CoinExchangeRequest $request
     * @return array
     */
    public function exchangeCoinProcess(CoinExchangeRequest $request): array
    {
        /** @var Coin $fromCoin */
        $fromCoin = CoinService::getCoinByCoin(
            coin : $request->from_coin,
            throw: true
        );
        
        /** @var Coin $toCoin */
        $toCoin = CoinService::getCoinByCoin(
            coin : $request->to_coin,
            throw: true
        );

        /** @var Wallet $fromWallet */
        $fromWallet = WalletService::createAndGetUserWallet(
            coin : $fromCoin->coin,
            throw: true
        );

        /** @var Wallet $toWallet */
        $toWallet = WalletService::createAndGetUserWallet(
            coin : $toCoin->coin,
            throw: true
        );

        $rateResponse = (new CoinMarketCap)->get3rdPartyCoinPrice(
            from: $fromCoin->coin,
            to  : $toCoin->coin
        );

        if(!$rateResponse['status'])
            return failed(_t("Rate fetch failed"));

        /** @var AppWalletService $walletService */
        $walletService = app(AppWalletService::class);

        $feeService = FeesType::tryFrom($fromCoin->exchange_fees_type) ?? FeesType::FIXED;
        $fees = $feeService->calculateFees($request->amount, $fromCoin->exchange_fees);
        $rate = $rateResponse['data']['coin_price'] ?? 0;
        $rateAmount = $rate * $request->amount;

        $exchangeData = [
            'user_id'      => Auth::id(),
            'from_coin_id' => $fromCoin->id,
            'to_coin_id'   => $toCoin->id,
            'from_coin'    => $fromCoin->coin,
            'to_coin'      => $toCoin->coin,
            'rate'         => $rate,
            'fee'          => $fees,
            'from_amount'  => $request->amount,
            'to_amount'    => $rateAmount,
        ];

        $hasBalance = $walletService->checkWalletBalanceOrThrow(
            amount: $fees + $request->amount,
            wallet: $fromWallet,
            throw : true
        );

        DB::beginTransaction();
        if(
            $walletService->incrementBalance($rateAmount, $toWallet) &&
            $walletService->decrementBalance($fees + $request->amount, $fromWallet) &&
            $exchange = CoinExchange::create($exchangeData)
        ){
            DB::commit();
            Mail::to($request->user())
            ->queue(new CoinExchanged($request->user(), $exchange));
            SendSMSCoinExchanged::dispatch($request->user(), $exchange)->onQueue("high");
            return success(_t("Successfully exchanged"));
        }
        DB::rollBack();
        return failed(_t("Failed exchange"));
    }


    /**
     * Get exchange rate
     * @param \App\Http\Requests\User\ExchangeRateRequest $request
     * @return array
     */
    public function getExchangeRate(ExchangeRateRequest $request): array
    {
        $coinMarketCap = new CoinMarketCap;
        $rateResponse  = $coinMarketCap->get3rdPartyCoinPrice(
            from: $request->from_coin,
            to  : $request->to_coin
        );

        if($rateResponse['status']){
            $data["rate"]       = $rate = $rateResponse['data']['coin_price'] ?? 0;
            $data["total_rate"] = $rate * $request->amount;

            return success(_t("Rate found successfully"), $data);
        }

        return failed(_t("Failed to get rate"));
    }
}
