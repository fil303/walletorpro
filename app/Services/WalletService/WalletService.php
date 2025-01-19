<?php

namespace App\Services\WalletService;

use Exception;
use App\Models\Coin;
use App\Models\Wallet;
use App\Enums\FeesType;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Facades\UserFacade;
use App\Models\WalletAddress;
use App\Enums\TransactionType;
use App\Enums\WithdrawalStatus;
use App\Facades\ResponseFacade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\CoinService\CoinService;
use App\Services\ResponseService\Response;
use App\Services\WalletService\AppWalletService;
use App\Services\WalletService\WalletServiceTrait;
use App\Services\WalletService\CoinPaymentNotifierTrait;
use App\Http\Requests\User\CryptoWalletWithdrawalRequest;
use App\Services\CoinProviderService\CoinProviderService;

class WalletService implements AppWalletService
{
    use WalletServiceTrait;
    use CoinPaymentNotifierTrait;
    public static ?Wallet $wallet = null;
    public function __construct(){}

    /**
     * Get Auth User Wallet
     * @param string $coin
     * @param int $user_id
     * @return Wallet|null
     */
    public static function getAuthUserWallet(string $coin, int $user_id = null): ?Wallet
    {
        $user_id ??= Auth::id();

        if(self::$wallet instanceof Wallet){
            if(
                self::$wallet->coin    == $coin &&
                self::$wallet->user_id == $user_id
            ) return self::$wallet;
        }

        self::$wallet = 
            Wallet::whereUserId($user_id ?? Auth::id())
            ->whereCoin($coin)
            ->first();
        
        // if(!(self::$wallet instanceof Wallet))
        //     throw new Exception(_t("User wallet not found"));

        return self::$wallet;
    }

    /**
     * Get Auth User Wallet
     * @param int $coin_id
     * @param int $user_id
     * @return Wallet|null
     */
    public static function getAuthUserWalletByCoinId(int $coin_id, int $user_id = null): ?Wallet
    {
        $user_id ??= Auth::id();

        if(self::$wallet instanceof Wallet){
            if(
                self::$wallet->coin_id == $coin_id &&
                self::$wallet->user_id == $user_id
            ) return self::$wallet;
        }

        self::$wallet = 
            Wallet::whereUserId($user_id ?? Auth::id())
            ->where('coin_id', $coin_id)
            ->first();

        return self::$wallet;
    }

    /**
     * Create And Get User Wallet
     * @param string $coin
     * @param bool $create
     * @param bool $throw
     * @param string $redirect
     * @return ?Wallet
     */
    public static function createAndGetUserWallet(
        string $coin,
        bool   $create   = false,
        bool   $throw    = false,
        string $redirect = null
    ):  ?Wallet
    {
        self::$wallet = null;
        if($create) {
            UserFacade::updateUserWallets();

            if(!self::getAuthUserWallet($coin) && $throw){
                Response::throw(
                    failed(_t("Wallet not found")),
                    $redirect
                );
            }

            return self::$wallet;
        };

        $wallet = self::getAuthUserWallet($coin) ?? self::createAndGetUserWallet($coin, true, $throw, $redirect);

        if(!$wallet && $throw){
            Response::throw(
                failed(_t("Wallet not found")),
                $redirect
            );
        }
        return $wallet;
    }

    /**
     * Check User Wallet Has Enough Balance
     * @param float $amount
     * @param \App\Models\Wallet|int|string|null $wallet
     * @param string $coin
     * @param bool $throw
     * @param string|null $redirect
     * @return array
     */
    public static function checkWalletBalanceOrThrow(
        float $amount,
        Wallet|int|string|null $wallet,
        string $coin = "",
        bool $throw = false,
        ?string $redirect = null
    ): array
    {
        $Wallet = $wallet;
        if(gettype($wallet) == "integer") {
            if(!$Wallet = Wallet::find($wallet))
                Response::throw(
                    failed(_t("Wallet not found")),
                    $redirect ?? null
                );
        }
        
        if(gettype($wallet) == "string") {
            if(!$Wallet = Wallet::where('user_id', user_id())->where('coin', $wallet)->first())
                Response::throw(
                    failed(_t("Wallet not found")),
                    $redirect ?? null
                );
        }

        if($wallet == null){
            $Wallet = self::createAndGetUserWallet($coin, false, true);
        }
     
        if($amount <= ($Wallet->balance ?? 0))
            return success("success", $wallet);
        
        if($throw){
            Response::throw(
                failed("Insufficient user wallet balance")
            );
        }
        return failed("failed");
    }

    /**
     * This method will get Coin Deposit Details and Wallet Address
     * 
     * @param string $coin
     * @param ?string $code
     * @param ?string $uid
     * @return array<string>
     */
    public function getCoinDepositDetails(string $coin, string $code = null, string $uid = null): array
    {
        $multiNetworkCoin = false;

        if(!$uid){
            $getCoins = safe_code( fn() => CoinService::getCoinsByCoin($coin) );

            if(!$getCoins['status'])
                Response::throw(
                    failed(_t("Coin not found")),
                    "cryptoWalletPage"
                );
    
            /** @var Coin $coin */
            $coins = $getCoins['data']['result'];
            if(count($coins) > 1){
                // $multiNetworkCoin = true;
                $coins->map(function($coin){
                    $coin->key   = $coin->code;
                    $coin->value = $coin->name;
                });
            }
    
            $getWallet = safe_code( fn() => self::getAuthUserWallet($coins[0]->coin) );
    
            if(!$getWallet['status'])
                Response::throw(
                    failed(_t("Wallet not found")),
                    "cryptoWalletPage"
                );
    
            /** @var Wallet $wallet */
            $wallet = $getWallet['data']['result'];
    
            $address = WalletAddress::where([
                "user_id"=> Auth::id(),
                "wallet_id" => $wallet->id,
                "code" => $code ?? $coins[0]->code
            ])->first();
    
            if(!$address){
                $address = $this->saveNewWallerAddress(
                    addressResponse: $this->generateAddress($coins[0]),
                    wallet: $wallet,
                    coin: $coins[0],
                );
            }
            $responseData = new \stdClass;
            $responseData->coins   = $coins;
            $responseData->coin_code=$code ?? $coins[0]->code;
            $responseData->coin_table= $coins[0] ?? null;
            $responseData->name    = $coins[0]->name;
            $responseData->coin    = $coins[0]->coin;
            $responseData->icon    = $coins[0]?->getIcon() ?? '';
            $responseData->balance = $wallet->balance;
            $responseData->address = $address->address ?? null ;
            $responseData->multiNetworkCoin = $multiNetworkCoin;
        } else {
            $getCoins = safe_code( fn() => CoinService::getCoinByUid($uid) );
            if(!$getCoins['status'])
                Response::throw(
                    failed(_t("Coin not found")),
                    "cryptoWalletPage"
                );
    
            /** @var Coin $coin */
            $coin = $getCoins['data']['result'];
            $data['coin']   = $coin;

            $getWallet = safe_code( fn() => self::getAuthUserWalletByCoinId($coin->id) );
            if(!$getWallet['status'])
                Response::throw(
                    failed(_t("Wallet not found")),
                    "cryptoWalletPage"
                );
    
            /** @var Wallet $wallet */
            $wallet = $getWallet['data']['result'];

            $address = WalletAddress::where([
                "user_id"=> Auth::id(),
                "wallet_id" => $wallet->id,
                "code" => $coin->code
            ])->first();
    
            if(!$address){
                $address = $this->saveNewWallerAddress(
                    addressResponse: $this->generateAddress($coin),
                    wallet: $wallet,
                    coin: $coin,
                );
            }
            $responseData = new \stdClass;
            $responseData->coins   = null;
            $responseData->coin_code=$coin->code;
            $responseData->coin_table= $coin;
            $responseData->name    = $coin->name;
            $responseData->coin    = $coin->coin;
            $responseData->icon    = $coin->getIcon();
            $responseData->balance = $wallet->balance;
            $responseData->address = $address->address ?? null ;
            $responseData->multiNetworkCoin = $multiNetworkCoin;
        }

        return success(_t("Wallet details found successfully"), $responseData);
    }

    /**
     * get coin wallet details for withdrawal page
     * @param string $coin
     * @param ?string $uid
     * @return mixed
     */
    public function getCoinWithdrawalPageData(string $coin, string $uid = null): mixed
    {
        $multiNetworkCoin = false;

        if(!$uid){
            $getCoins = safe_code( fn() => CoinService::getCoinsByCoin($coin) );
    
            if(!$getCoins['status'])
                Response::throw(
                    failed(_t("Coin not found")),
                    "cryptoWalletPage"
                );
    
            /** @var Coin $coin */
            $coins = $getCoins['data']['result'];
            if(count($coins) > 1){
                // $multiNetworkCoin = true;
                $coins->map(function($coin){
                    $coin->key   = $coin->code;
                    $coin->value = $coin->name;
                });
            }
            $getWallet = safe_code( fn() => self::getAuthUserWallet($coins[0]->coin) );
            if(!$getWallet['status'])
                Response::throw(
                    failed(_t("Wallet not found")),
                    "cryptoWalletPage"
                );
    
            /** @var Wallet $wallet */
            $wallet = $getWallet['data']['result'];
            $data['coin']   = $coins[0];
            $data['coins']  = $coins;
        }else{
            $getCoins = safe_code( fn() => CoinService::getCoinByUid($uid) );

            if(!$getCoins['status'])
                Response::throw(
                    failed(_t("Coin not found")),
                    "cryptoWalletPage"
                );
    
            /** @var Coin $coin */
            $coin = $getCoins['data']['result'];
            $data['coin']   = $coin;

            $getWallet = safe_code( fn() => self::getAuthUserWalletByCoinId($coin->id) );
            if(!$getWallet['status'])
                Response::throw(
                    failed(_t("Wallet not found")),
                    "cryptoWalletPage"
                );
    
            /** @var Wallet $wallet */
            $wallet = $getWallet['data']['result'];
            $data['wallet'] = $wallet;
        }

        $data['withdrawals'] = Withdrawal::where('coin_id', $coin->id ?? 0)->limit(5)->orderByDesc("id")->get();
        $data['multiNetworkCoin']   = $multiNetworkCoin;

        return success(_t("Wallet details found successfully"), $data);
    }

    /**
     * Crypto Wallet Withdrawal
     * @param \App\Http\Requests\User\CryptoWalletWithdrawalRequest $request
     * @return array
     */
    public function cryptoWithdrawal(CryptoWalletWithdrawalRequest $request): array
    {
        if(!$wallet = Wallet::where('uid', $request->wallet)->first())
        {
            Response::throw(
                failed(_t("Wallet not found")),
                "cryptoWalletPage"
            );
        }

        if(!$coin = Coin::where('code', $request->coin_code)->first())
        {
            Response::throw(
                failed(_t("Coin not found")),
                "cryptoWalletPage"
            );
        }

        $feeService = FeesType::tryFrom($coin->withdrawal_fees_type) ?? FeesType::FIXED;
        $fees = $feeService->calculateFees($request->amount, $coin->withdrawal_fees);

        $this->checkWalletBalanceOrThrow(
            amount: $fees + $request->amount,
            wallet: $wallet,
            coin  : $coin->coin,
            throw : true,
            redirect: "cryptoWalletPage"
        );

        $type = TransactionType::EXTERNAL->value;
        $walletAddress = WalletAddress::where('address', $request->address)->first();
        if($walletAddress){
            $type = TransactionType::INTERNAL->value;
            if($walletAddress->user_id == $wallet->user_id)
            ResponseFacade::failed(_t("You can not send to own account"));
        }

        $withdrawalData = [
            "user_id"  => Auth::id(),
            "coin_id"  => $coin->id,
            "wallet_id"=> $wallet->id,
            "coin"     => $coin->coin,
            "type"     => $type,
            "code"     => $coin->code,
            "amount"   => $request->amount,
            "fees"     => $fees,
            "to_address"=> $request->address,
            "trx"      => NULL,
            "status"   => WithdrawalStatus::PENDING->value,
        ];

        DB::beginTransaction();
        try {
            if(
                $this->decrementBalance($fees + $request->amount, $wallet) &&
                Withdrawal::create($withdrawalData)
            ){
                DB::commit();
                return success(_t("Withdrawal request sent successfully"));
            }

            return failed(_t("Withdrawal request failed"));
        } catch (Exception $e) {
            DB::rollBack();
            logStore("cryptoWithdrawal", $e->getMessage());
            return failed(_t("Withdrawal request failed").". "._t("Something went wrong"));
        }


    }

    /**
     * Generate new wallet address
     * @param \App\Models\Coin $coin
     * @return array
     */
    public function generateAddress(Coin $coin): array
    {
        $coinProvider = new CoinProviderService;

        /** @var array<string> $address */
        $address = $coinProvider->address($coin);
        return $address;
    }

    /**
     * Save new wallet address
     * @param array<mixed> $addressResponse
     * @param \App\Models\Wallet $wallet
     * @param \App\Models\Coin $coin
     * @return WalletAddress|null
     */
    private function saveNewWallerAddress(array $addressResponse, Wallet $wallet, Coin $coin): ?WalletAddress
    {
        if(
            // is_array($addressResponse)        &&
            isset($addressResponse['data']["result"]) && 
            isset($addressResponse['data']["result"]["address"])
        ){
            $walletAddressData = [
                "uid"       => uniqueCode("A"),
                "wallet_id" => $wallet->id,
                "user_id"   => Auth::id(),
                "address"   => $addressResponse['data']["result"]["address"],
                "coin_id"   => $coin->id,
                "coin"      => $coin->coin,
                "code"      => $coin->code,
            ];

            try {
                return WalletAddress::create($walletAddressData);
            } catch (Exception $e) {
                logStore("saveNewWallerAddress", $e->getMessage());
            }
        }
        return null;
    }

    /**
     * Withdrawal from wallet
     * @param \App\Models\Withdrawal $withdrawal
     * @return array
     */
    public function withdrawFromWallet(Withdrawal $withdrawal): array
    {
        if(!$wallet = Wallet::find($withdrawal->wallet_id)->first())
        {
            Response::throw(
                failed(_t("Wallet not found")),
                "cryptoWalletPage"
            );
        }

        if(!$coin = Coin::find($withdrawal->coin_id)->first())
        {
            Response::throw(
                failed(_t("Coin not found")),
                "cryptoWalletPage"
            );
        }

        if($withdrawal->type == TransactionType::INTERNAL){
            return $this->internalTransfer($withdrawal);
        }
        return $this->externalTransfer($withdrawal, $coin);
    }

    /**
     * Internal transfer
     * @param \App\Models\Withdrawal $withdrawal
     * @return array
     */
    public function internalTransfer(Withdrawal $withdrawal): array
    {
        if(!$receiverWalletAddress = WalletAddress::where('address', $withdrawal->to_address)->first())
        {
            Response::throw(
                failed(_t("Receiver wallet address not found")),
                "cryptoWalletPage"
            );
        }

        if(!$receiverWallet = Wallet::find($withdrawal->wallet_id)->first())
        {
            Response::throw(
                failed(_t("Receiver wallet not found")),
                "cryptoWalletPage"
            );
        }

        $depositData = [
            "user_id" => $receiverWallet->user_id,
            "coin_id" => $withdrawal->coin_id,
            "wallet_id"=> $receiverWallet->id,
            "type"    => TransactionType::INTERNAL->value,
            "coin"    => $withdrawal->coin,
            "code"    => $withdrawal->code,
            "amount"  => $withdrawal->amount,
            "trx"     => random_str(length: 32),
            "from_address" => $withdrawal->to_address
        ];

        try {
            DB::beginTransaction();
            $withdrawal->status = WithdrawalStatus::COMPLETED->value;
            if(
                $withdrawal->save() &&
                Deposit::create($depositData) &&
                $this->incrementBalance($withdrawal->amount, $receiverWallet)
            ){
                DB::commit();
                return success( _t("Withdrawal confirm successfully"));
            }   return failed(_t("Withdrawal confirmation failed"));
        } catch (Exception $e) {
            DB::rollBack();
            logStore("internalTransfer", $e->getMessage());
            return failed(_t("Withdrawal confirmation failed").". "._t("Something went wrong"));
        }
    }

    /**
     * External transfer
     * @param \App\Models\Withdrawal $withdrawal
     * @param \App\Models\Coin $coin
     * @return array
     */
    public function externalTransfer(Withdrawal $withdrawal, Coin $coin): array
    {
        DB::beginTransaction();
        $withdrawal->status = WithdrawalStatus::COMPLETED->value;
        if($withdrawal->save()){
            $coinProvider = new CoinProviderService;

            /** @var array<mixed> $sendCoinResponse */
            $sendCoinResponse = $coinProvider->sendCoins($coin, [ 
                "amount"   => $withdrawal->amount,
                'currency' => $coin->code,
                'address'  => $withdrawal->to_address,
                'ipn_url'  => route('coinPaymentIpn'),
            ]);

            if(!is_success($sendCoinResponse))
                Response::throw(
                    failed(_t("Transfer coins failed")),
                    "cryptoWalletPage"
                );

            if(($sendCoinResponse['data']['error'] ?? '') !== "ok"){
                ResponseFacade::failed($sendCoinResponse['data']['error'] ?? _t('Transfer coins failed'))->throw();
            }

            DB::commit();
            return success( _t("Withdrawal confirm successfully"));
        }   return failed(_t("Withdrawal confirmation failed"));
    }

}
