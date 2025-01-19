<?php

namespace App\Services\WalletService;

use Exception;
use App\Models\Coin;
use App\Models\Wallet;
use App\Models\Deposit;
use Illuminate\Http\Request;
use App\Models\WalletAddress;
use Illuminate\Support\Facades\DB;

trait CoinPaymentNotifierTrait
{
    /**
     * Receive Deposit By CoinPayment Notifier 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function coinPaymentNotifier(Request $request): void
    {
        logStore('coinPaymentNotifier', json_encode($request->all()));
        $this->notifierValidation($request);
        if (filled($request->ipn_type) && $request->ipn_type == "deposit"){
            $this->coinPaymentNotifierDeposit($request);
        }
    }

    /**
     * Notifier Deposit Validation
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function notifierValidation(Request $request): void
    {
        $merchant_id = get_settings('coin_payment_ipn_marchant');
        $secret      = get_settings('coin_payment_ipn_secret');

        if (blank($_SERVER['HTTP_HMAC'])) {
            logStore('coinPaymentNotifier','No HMAC signature sent');
            die("No HMAC signature sent");
        }

        if (blank($request->merchant ?? '')) {
            logStore('coinPaymentNotifier','No Merchant ID passed');
            die("No Merchant ID passed");
        }

        if ($request->merchant != $merchant_id) {
            logStore('coinPaymentNotifier','Invalid Merchant ID');
            die("Invalid Merchant ID");
        }

        $requestData = file_get_contents('php://input');
        if ($requestData === FALSE || empty($requestData)) {
            logStore('coinPaymentNotifier','Error reading POST data');
            die("Error reading POST data");
        }
        $hmac = hash_hmac("sha512", $requestData, $secret);

        if ($hmac != $_SERVER['HTTP_HMAC']) {
            logStore('coinPaymentNotifier','HMAC signature does not match');
            die("HMAC signature does not match");
        }
    }

    /**
     * CoinPayment Notifier Deposit
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function coinPaymentNotifierDeposit(Request $request): void
    {
        $walletAddress = WalletAddress::where("address", $request->address ?? '');
        $walletAddress = $walletAddress->when(filled($request->dest_tag), function ($query) use($request){
            return $query->where('memo', $request->dest_tag);
        });
        
        if(!$walletAddress = $walletAddress->first()){
            logStore('$walletAddress','Address not found');
            die("walletAddress not found");
        }

        if(!$coin = Coin::find($walletAddress->coin_id)){
            logStore('$coin','Coin not found');
            die("coin not found");
        }

        if(!$wallet = Wallet::find($walletAddress->wallet_id)){
            logStore('$wallet','Wallet not found');
            die("Wallet not found");
        }

        if($hasDeposit = Deposit::where("trx", $request->txn_id)->first()){
            logStore('$hasDeposit','Already deposited');
            die("Already deposited");
        }

        $coin_code = $request->currency;
        $coin_coin = strtok($request->currency,".");

        $depositData = [
            "user_id" => $wallet->user_id,
            "coin_id" => $coin->id,
            "wallet_id"=> $wallet->id,
            "coin"    => $coin->coin,
            "code"    => $coin->code,
            "amount"  => $request->amount,
            "trx"     => $request->txn_id,
            "from_address" => $request->address
        ];

        try {
            DB::beginTransaction();
            if(
                Deposit::create($depositData) &&
                $this->incrementBalance($request->amount, $wallet)
            ){
                DB::commit();
                logStore('coinPaymentNotifierDeposit ', "Deposit Success");
            }
        } catch (Exception $e) {
            DB::rollBack();
            logStore('coinPaymentNotifierDeposit Error', $e->getMessage());
        }
        
    }
}