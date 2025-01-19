<?php

namespace App\Services\SmsService;

use App\Models\User;
use App\Models\Stake;
use App\Models\CoinOrder;
use App\Models\CoinExchange;

interface ISmsService
{

    /**
     * Send SMS
     * @param string $phone_number
     * @param string $message
     * @return bool
     */
    public function send(string $phone_number, string $message): bool;

    /**
     * Coin Purchase Complete SMS
     * @param \App\Models\User $user
     * @param \App\Models\CoinOrder $coinOrder
     * @return void
     */
    public function coinPurchaseComplete(User $user, CoinOrder $coinOrder): void;

    /**
     * Coin Exchange Complete SMS
     * @param \App\Models\User $user
     * @param \App\Models\CoinExchange $coinExchange
     * @return void
     */
    public function coinExchangeComplete(User $user, CoinExchange $coinExchange): void;

    /**
     * Coin Staking Start SMS
     * @param \App\Models\User $user
     * @param \App\Models\Stake $stake
     * @return void
     */
    public function coinStakingStart(User $user, Stake $stake): void;

    /**
     * Coin Staking Complete SMS
     * @param \App\Models\User $user
     * @param \App\Models\Stake $stake
     * @return void
     */
    public function coinStakingSuccess(User $user, Stake $stake): void;

    /**
     * Coin Staking Auto Start SMS
     * @param \App\Models\User $user
     * @param \App\Models\Stake $stake
     * @return void
     */
    public function coinStakingAutoStart(User $user, Stake $stake): void;
}
