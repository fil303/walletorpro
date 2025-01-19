<?php

namespace App\Jobs\Sms;

use App\Models\User;
use App\Models\CoinOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\SmsService\TwilioService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CoinBuySuccess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user,
        public CoinOrder $coinOrder
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Sending SMS to user for complete coin purchase
        $messageService = new TwilioService;
        $messageService->coinPurchaseComplete($this->user, $this->coinOrder);
    }
}
