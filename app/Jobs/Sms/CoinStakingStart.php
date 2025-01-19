<?php

namespace App\Jobs\Sms;

use App\Models\User;
use App\Models\Stake;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\SmsService\TwilioService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CoinStakingStart implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user,
        public Stake $stake
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Sending SMS to user for starting coin staking
        $messageService = new TwilioService;
        $messageService->coinStakingStart($this->user, $this->stake);
    }
}
