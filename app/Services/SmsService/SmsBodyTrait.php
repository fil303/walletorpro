<?php

namespace App\Services\SmsService;

use App\Models\User;
use App\Models\Stake;
use App\Models\CoinOrder;
use App\Models\CoinExchange;
use Illuminate\Bus\Queueable;

trait SmsBodyTrait{
    use Queueable;

    /**
     * Coin Purchase Complete SMS
     * @param \App\Models\User $user
     * @param \App\Models\CoinOrder $coinOrder
     * @return void
     */
    public function coinPurchaseComplete(User $user, CoinOrder $coinOrder): void
    {
        $subject = _t("Your Coin Purchase of :coin is Complete!", ["coin" => $coinOrder->coin ?? '']);
        $message = _t("Hi :name, your purchase of :amount :coin is complete. Total Paid: :paid :currency. Your coins are now in your wallet. Thank you for choosing :company.",[
            "name"    => $user->name ?? '',
            "amount"  => $coinOrder->amount ?? 0,
            "coin"    => $coinOrder->coin ?? '',
            "paid"    => $coinOrder->total_price ?? 0,
            "currency"=> $coinOrder->currency_code ?? '',
            "company" => get_settings("app_title") ?? ''
        ]);

        if($user->phone_verified_at)
        $this->send("+$user->phone", "$subject\n$message");
    }

    /**
     * Coin Exchange Complete SMS
     * @param \App\Models\User $user
     * @param \App\Models\CoinExchange $coinExchange
     * @return void
     */
    public function coinExchangeComplete(User $user, CoinExchange $coinExchange): void
    {
        $subject = _t("Your Coin Exchange of :from_coin to :to_coin is Complete!", [
            "from_coin" => $coinExchange->from_coin ?? '',
            "to_coin"   => $coinExchange->to_coin ?? ''
        ]);
        $message = _t("Hi :name, your exchange from :from_coin to :to_coin is successful. Exchanged: :from_amount :from_coin to :to_amount :to_coin. Fees: :fee :to_coin. Thank you for using our service!",[
            "name"     => $user->name ?? '',
            "from_coin"=> $coinExchange->from_coin ?? 0,
            "to_coin"  => $coinExchange->to_coin ?? 0,
            "from_amount"=> $coinExchange->from_amount ?? 0,
            "to_amount"=> $coinExchange->to_amount ?? 0,
            "fee"      => $coinExchange->fee ?? '',
        ]);

        if($user->phone_verified_at)
        $this->send("+$user->phone", "$subject\n$message");
    }

    /**
     * Coin Staking Start SMS
     * @param \App\Models\User $user
     * @param \App\Models\Stake $stake
     * @return void
     */
    public function coinStakingStart(User $user, Stake $stake): void
    {
        $subject = _t("Your Coin Staking for :coin Has Started!", [
            "coin" => $stake->coin ?? '',
        ]);
        $message = _t("Hi :name, your coin staking for :amount :coin has successfully started. Duration: :duration days, Interest: :interest%, Expected Return: :interest_amount :coin. Start: :created_at, End: :end_at. Thank you for staking with us!",[
            "name"      => $user->name ?? '',
            "amount"    => $stake->amount ?? 0,
            "coin"      => $stake->coin ?? 0,
            "duration"  => $stake->duration ?? 0,
            "interest"  => $stake->interest ?? 0,
            "interest_amount"  => $stake->interest_amount ?? 0,
            "created_at"=> date('M d, Y, h:i A', strtotime($stake->created_at ?? '')),
            "end_at"    => date('M d, Y, h:i A', strtotime($stake->end_at ?? '')),
        ]);

        if($user->phone_verified_at)
        $this->send("+$user->phone", "$subject\n$message");
    }

    /**
     * Coin Staking Complete SMS
     * @param \App\Models\User $user
     * @param \App\Models\Stake $stake
     * @return void
     */
    public function coinStakingSuccess(User $user, Stake $stake): void
    {
        $subject = _t("Your Coin Staking for :coin is Complete!", [
            "coin" => $stake->coin ?? '',
        ]);
        $message = _t("Hi :name, your coin staking for :amount :coin has ended. Total Return: :interest_amount :coin (Interest Earned: :interest). Funds are credited to your wallet. Thank you for staking with us!",[
            "name"      => $user->name ?? '',
            "amount"    => $stake->amount ?? 0,
            "coin"      => $stake->coin ?? 0,
            "interest"  => $stake->interest ?? 0,
            "interest_amount"  => $stake->interest_amount ?? 0,
        ]);

        if($user->phone_verified_at)
        $this->send("+$user->phone", "$subject\n$message");
    }

    /**
     * Coin Staking Auto Start SMS
     * @param \App\Models\User $user
     * @param \App\Models\Stake $stake
     * @return void
     */
    public function coinStakingAutoStart(User $user, Stake $stake): void
    {
        $subject = _t("Your Coin Staking Has Automatically Restarted!");
        $message = _t("Hi :name, your coin staking for :amount :coin has auto-renewed for another :duration days at :interest% interest. Expected Return: :interest_amount :coin. You can manage your auto-staking settings anytime.",[
            "name"      => $user->name ?? '',
            "amount"    => $stake->amount ?? 0,
            "coin"      => $stake->coin ?? 0,
            "interest"  => $stake->interest ?? 0,
            "duration"  => $stake->duration ?? 0,
            "interest_amount"  => $stake->interest_amount ?? 0,
        ]);

        if($user->phone_verified_at)
        $this->send("+$user->phone", "$subject\n$message");
    }

}