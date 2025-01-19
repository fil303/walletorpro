<?php

namespace App\Services\WalletService;

use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Http\Requests\User\CryptoWalletWithdrawalRequest;

interface AppWalletService
{
    /**
     * This method will get Coin Deposit Details and Wallet Address
     * 
     * @param string $coin
     * @param ?string $code
     * @param ?string $uid
     * @return array{status: bool, message: string, data: array}
     */
    public function getCoinDepositDetails(string $coin, string $code = null, string $uid = null): array;

    /**
     * Withdraw coin to another address
     * @param \App\Http\Requests\User\CryptoWalletWithdrawalRequest $request
     * @return array
     */
    public function cryptoWithdrawal(CryptoWalletWithdrawalRequest $request): array;

    /**
     * Increment User Wallet Balance
     * @param float $amount
     * @param Wallet|null $wallet
     * @return bool
     */
    public function incrementBalance(float $amount, Wallet $wallet = null): bool;

    /**
     * Decrement User Wallet Balance
     * @param float $amount
     * @param Wallet|null $wallet
     * @return bool
     */
    public function decrementBalance(float $amount, Wallet $wallet = null): bool;

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
    ): array;

    /**
     * Receive Deposit By CoinPayment Notifier
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function coinPaymentNotifier(Request $request): void;

    /**
     * get coin wallet details for withdrawal page
     * @param string $coin
     * @param ?string $uid
     * @return mixed
     */
    public function getCoinWithdrawalPageData(string $coin, string $uid = null): mixed;

    /**
     * Withdrawal from wallet
     * @param \App\Models\Withdrawal $withdrawal
     * @return array
     */
    public function withdrawFromWallet(Withdrawal $withdrawal): array;
}
