<?php

namespace App\Services\WalletService;

use App\Models\Wallet;

trait WalletServiceTrait{

    /**
     * Increment User Wallet Balance
     * @param float $amount
     * @param \App\Models\Wallet|null $wallet
     * @return bool
     */
    public function incrementBalance(float $amount, Wallet $wallet = null): bool
    {
        try {
            $decimal_amount = to_decimal($amount);
            $userWallet = $wallet ?? WalletService::$wallet;
            return $userWallet?->increment('balance', $amount) == true;
        } catch (\Exception $e) {
            logStore("WalletServiceTrait incrementBalance", $e->getMessage());
            return false;
        }
    }
    
    /**
     * Decrement User Wallet Balance
     * @param float $amount
     * @param \App\Models\Wallet|null $wallet
     * @return bool
     */
    public function decrementBalance(float $amount, Wallet $wallet = null): bool
    {
        try {
            $decimal_amount = to_decimal($amount);
            $userWallet = $wallet ?? WalletService::$wallet;
            return $userWallet?->decrement('balance', $amount) == true;
        } catch (\Exception $e) {
            logStore("WalletServiceTrait decrementBalance", $e->getMessage());
            return false;
        }
    }
}