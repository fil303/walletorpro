<?php

namespace App\Jobs;

use App\Models\Stake;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\StakeService\AppStakeService;

class AutoStakingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 2;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 99999999;

    /**
     * Create a new job instance.
     */
    public function __construct(private Stake $stake)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logStore("auto staking called");
        app(AppStakeService::class)->autoStake($this->stake);
    }
}
