<?php

namespace App\Services\UserCoinBuyService;

use Exception;
use App\Models\Coin;
use App\Models\User;
use App\Models\Wallet;
use App\Enums\FeesType;
use App\Models\Currency;
use App\Models\CoinOrder;
use App\Enums\CurrencyType;
use App\Enums\CoinBuyStatus;
use App\Enums\PaymentMethod;
use App\Mail\CoinBuySuccess;
use Illuminate\Http\Request;
use App\Enums\ApprovedStatus;
use App\Models\PaymentGateway;
use App\Models\GatewayCurrency;
use Illuminate\Support\Facades\DB;
use App\Models\BuyCryptoTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\CoinService\CoinService;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\User\BuyCryptoRequest;
use App\Services\CoinMarketCap\CoinMarketCap;
use App\Services\WalletService\WalletService;
use App\Http\Requests\User\getCryptoPriceRequest;
use App\Services\CurrencyService\CurrencyService;
use App\Services\UserCoinBuyService\IUserCoinBuyService;
use App\Jobs\Sms\CoinBuySuccess as SendSMSCoinBuySuccess;
use App\Services\PaymentGatewayService\PaymentGatewayService;
use App\Services\PaymentMethod\PaymentMethod as IPaymentMethod;

class UserCoinBuyService implements IUserCoinBuyService
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

        $response = $coinMarketCap->get3rdPartyCoinPrice( // getPriceConversion
            $request->crypto,
            $request->currency
        );

        if($response['status'] ?? false){
            $price = $response['data']['coin_price'] ?? 0;
            return success(_t("Crypto price get successfully"), [
                "price" => $price,
                "total" => $request->amount * $price
            ]);
        }

        return failed(_t("Crypto price get failed"));
    }

    /**
     * this method will get buy coin page data to render on website
     * @return array
     */
    public function getBuyCoinPageData (): array
    {
        $coins = Coin::activeCoins(CurrencyType::CRYPTO)->select(['coin', 'name'])->get(); // ->groupBy(['coin'])
        $coins->map(function(Coin $coin){
            $coin->key   = $coin->coin;
            $coin->value = $coin->name;
        });

        $currencies = GatewayCurrency::select(['currency_code'])->groupBy('currency_code')->get();
        // $currencies = Currency::activeCurrency()->get();
        $currencies->map(function(GatewayCurrency $currency){
            $currency->key   = $currency->currency_code;
            $currency->value = $currency->currency_code;
            $currency->code  = $currency->currency_code;
        });

        $paymentMethods = null;
        if(isset($currencies[0]->currency_code)){
            $currency = $currencies[0]->currency_code;
            $response = $this->getPaymentMethodByCurrency($currency);
            $paymentMethods = $response['data']['paymentMethods'] ?? [];
        }

        $data['selected_fiat'] = $currencies[0]->currency_code ?? "";
        $data["coins"]      = $coins;
        $data["currencies"] = $currencies;
        $data["gateways"]   = $paymentMethods ?? [];
        return success(_t("Success"), $data);
    }

    /**
     * Crypto Buy Process
     * @param BuyCryptoRequest $request
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

    /**
     * Get Payment Method By Currency
     * @param string $currency
     * @return array
     */
    public function getPaymentMethodByCurrency(string $currency): array
    {
        $paymentMethods = PaymentGateway::byCurrency($currency)->get();

        $paymentMethods->map(function($gateway){
            $gateway->key   = $gateway->uid;
            $gateway->value = $gateway->title;
        });

        $data['paymentMethods'] = $paymentMethods;
        return success(_t("Success"), $data);
    }

    /**
     * Coin Buy Process
     * @param \App\Http\Requests\User\BuyCryptoRequest $request
     * @return array
     */
    public function coinBuyProcess(BuyCryptoRequest $request): array
    {
        /**  @var Coin $crypto */
        $crypto   = CoinService::getCoinByCoin($request->crypto,   true, 'coinBuyPage');
        
        /**  @var Currency $currency */
        $currency = CurrencyService::getCurrencyByCode($request->currency, true, 'coinBuyPage');
        
        /**  @var PaymentGateway $gateway */
        $gateway = (new PaymentGatewayService)->getPaymentGatewayByUidAndCurrency($request->gateway, $currency->code, true, 'coinBuyPage');

        /**  @var Wallet $wallet */
        $wallet   = WalletService::createAndGetUserWallet($request->crypto,   true, true, 'coinBuyPage');

        $coinOrderSaveResponse = $this->coinOrderSave(
            wallet  : $wallet,
            crypto  : $crypto,
            gateway : $gateway,
            currency: $currency,
            amount  : $request->amount
        );

        if(!$coinOrderSaveResponse['status'])
            return $coinOrderSaveResponse;

        /** @var CoinOrder $coinOrder */
        $coinOrder = $coinOrderSaveResponse['data'][0];

        if(!$paymentMethod = PaymentMethod::tryFrom($gateway->slug))
            return failed(_t("Invalid payment method found in record"));

        /** @var IPaymentMethod $paymentMethodService */
        $paymentMethodService = $paymentMethod->getPaymentMethod();

        $checkout_url = $paymentMethodService->checkout_url($gateway, $coinOrder);
        return success(_t("Redirect to checkout page"), $checkout_url);
    }

    /**
     * Coin Order Save
     * @param \App\Models\Wallet $wallet
     * @param \App\Models\Coin $crypto
     * @param \App\Models\PaymentGateway $gateway
     * @param \App\Models\Currency $currency
     * @param string $amount
     * @return array
     */
    private function coinOrderSave(
        Wallet $wallet,
        Coin $crypto,
        PaymentGateway $gateway,
        Currency $currency,
        string $amount
    ): array
    {
        $request = new getCryptoPriceRequest([
            "crypto"   => $crypto->code,
            "currency" => $currency->code,
            "amount"   => $amount
        ]);

        $priceResponse = $this->getCryptoPrice($request);

        if(!($priceResponse['status'] ?? false))
            return $priceResponse;

        $price       = $priceResponse['data']['price'] ?? 0;
        $amount      = $request->amount;
        $net_amount  = $amount * $price;
        $feeService  = FeesType::tryFrom($gateway->fees_type ?? 1) ?? FeesType::FIXED;
        $fees        = $feeService->calculateFees($net_amount, $gateway->fees ?? 0);
        $total_amount= $net_amount + $fees;

        $coinOrder = new CoinOrder;
        $coinOrder->uid         = uniqueCode("BC", true);
        $coinOrder->user_id     = Auth::id();
        $coinOrder->wallet_id   = $wallet->id;
        $coinOrder->coin_id     = $crypto->id;
        $coinOrder->currency_id = $currency->id;
        $coinOrder->payment_id  = $gateway->id;
        $coinOrder->coin        = $crypto->coin;
        $coinOrder->coin_code   = $crypto->code;
        $coinOrder->currency_code = $currency->code;
        $coinOrder->payment_slug= $gateway->slug;
        $coinOrder->rate        = $price;
        $coinOrder->amount      = $request->amount;
        $coinOrder->fees        = $fees;
        $coinOrder->net_price   = $net_amount;
        $coinOrder->total_price = $total_amount;
        $coinOrder->status      = CoinBuyStatus::PENDING->value;
        $coinOrder->transaction_id = random_str("BC", 30);

        try {
            if($coinOrder->save())
                return success(_t('Success'), $coinOrder);
            return failed(_t('Coin buy process failed'));
        } catch (Exception $e) {
            logStore("coinOrderSave :", $e->getMessage());
            return failed($e->getMessage());
        }
    }

    /**
     * Cancel Coin Order
     * @param string $gatewayUid
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cancelCoinOrder(string $gatewayUid, Request $request): array
    {
        $coinOrderUid = null;

        /** @var ?PaymentGateway $gateway */
        $gateway = PaymentGateway::firstByUid($gatewayUid)->first();
        if(!$gateway) return failed(_t("Payment gateway not found"));

        if(!$paymentMethod = PaymentMethod::tryFrom($gateway->slug))
            return failed(_t("Invalid payment method found in record"));

        if($paymentMethod == PaymentMethod::PERFECT_MONEY){
            $coinOrderUid = $request->PAYMENT_ID ?? null;
        }
        
        if($paymentMethod == PaymentMethod::PAYPAL){
            $coinOrderUid = $request->order_uid ?? null;
        }
        
        if($paymentMethod == PaymentMethod::STRIPE){
            $coinOrderUid = $request->order_uid ?? null;
        }

        if($coinOrderUid){
            $coinOrder = CoinOrder::where('uid', $coinOrderUid)->first();

            if(CoinBuyStatus::tryFrom($coinOrder->status) == CoinBuyStatus::PENDING){
                $coinOrder->update([
                    "status" => CoinBuyStatus::CANCELED->value
                ]);
            }
        }

        return success(_t("Order Canceled"));
    }

    /**
     * Confirm Coin Order
     * @param string $gatewayUid
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function confirmCoinOrder(String $gatewayUid, Request $request): array
    {
        $coinOrderUid = null;

        /** @var ?PaymentGateway $gateway */
        $gateway = PaymentGateway::firstByUid($gatewayUid)->first() ;
        if(!$gateway) return failed(_t("Payment gateway not found"));

        if(!$paymentMethod = PaymentMethod::tryFrom($gateway->slug))
            return failed(_t("Invalid payment method found in response"));

        /** @var IPaymentMethod $paymentMethodService */
        $paymentMethodService = $paymentMethod->getPaymentMethod();

        if($paymentMethod == PaymentMethod::PERFECT_MONEY){
            $coinOrderUid = $request->PAYMENT_ID ?? null;
        }

        if($paymentMethod == PaymentMethod::PAYPAL){
            $coinOrderUid = $request->order_uid ?? null;
        }
        
        if($paymentMethod == PaymentMethod::STRIPE){
            $coinOrderUid = $request->order_uid ?? null;
        }

        if($coinOrderUid){
            $coinOrder = CoinOrder::where('uid', $coinOrderUid)->first();

            if(CoinBuyStatus::tryFrom($coinOrder->status) == CoinBuyStatus::PENDING){
                $coinOrder->update([
                    "status" => CoinBuyStatus::WAITING->value
                ]);
            }
            return success(_t("Order Completed"));
        }
        return failed(_t("Order Failed"));
    }

    /**
     * Coin Order IPN
     * @param string $gatewayUid
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function coinOrderIpn(String $gatewayUid, Request $request): array
    {
        $coinOrderUid = null;
        $coinOrderTransactionId = null;

        $requestData = $request->all();
        logStore("paypal log ipn", json_encode($requestData));

        /** @var ?PaymentGateway $gateway */
        $gateway = PaymentGateway::firstByUid($gatewayUid)->orWhere('slug', $gatewayUid)->first();
        if(!$gateway) return failed(_t("Payment gateway not found"));
        
        if(!$paymentMethod = PaymentMethod::tryFrom($gateway->slug))
            return failed(_t("Invalid payment method found in response"));

        /** @var IPaymentMethod $paymentMethodService */
        $paymentMethodService = $paymentMethod->getPaymentMethod();

        if($paymentMethod == PaymentMethod::PERFECT_MONEY){
            $coinOrderUid = $request->PAYMENT_ID ?? null;
            $response = $paymentMethodService->verify($gatewayUid, $request);

            if(!$response['status']) return $response;
            $coinOrderTransactionId = $request->PAYMENT_BATCH_NUM;
        }
       
        if($paymentMethod == PaymentMethod::PAYPAL){
            $coinOrderUid = $request->custom ?? null;
            $response = $paymentMethodService->verify($gatewayUid, $request);

            logStore("paypal log verify response", json_encode($response));

            if(!$response['status']) return $response;
            $coinOrderTransactionId = $request->txn_id;
        }

        if($paymentMethod == PaymentMethod::STRIPE){
            $coinOrderUid = $request->data["object"]["metadata"]["order_id"] ?? null;
            $response = $paymentMethodService->verify($gateway->uid, $request);
            logStore("stripe log verify response", json_encode($response));

            if(!$response['status']) return $response;
            $coinOrderTransactionId = $request->data["object"]["id"] ?? 'payment_intent_id';
        }

        logStore("coin order ipn: coinOrderTransactionId", $coinOrderTransactionId ?? 'not found');

        try{
            DB::beginTransaction();
            if($coinOrderUid){
                $coinOrder = CoinOrder::where('uid', $coinOrderUid)->first();
                $user      = User::find($coinOrder->user_id);
                $wallet    = Wallet::where("user_id", $coinOrder->user_id)->where("coin", $coinOrder->coin)->first();
                $coinOrderUpdateData =[
                    "transaction_id" => $coinOrderTransactionId,
                    "status" => CoinBuyStatus::COMPLETED->value
                ];
                if(
                    $user &&
                    $coinOrder && $coinOrder->update($coinOrderUpdateData) &&
                    $wallet    && $wallet->increment("balance", $coinOrder->amount ?? 0)
                ){
                    DB::commit();
                    Mail::to($user->email)->queue(new CoinBuySuccess($user, $coinOrder));
                    SendSMSCoinBuySuccess::dispatch($user, $coinOrder)->onQueue("high");
                    logStore("coin order ipn", "Balance credited");
                    return success(_t("Order Completed"));
                }
            }
            return failed(_t("Order Failed"));
        } catch(Exception $e){
            DB::rollBack();
            logStore("coin order ipn error", $e->getMessage());
            return failed(_t("Order Failed"));
        }
    }
}
