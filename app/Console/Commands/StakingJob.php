<?php

namespace App\Console\Commands;

use App\Jobs\StakingJob as StakingCommandJob;
use Illuminate\Console\Command;

class StakingJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:staking-job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will run staking job and check for staking maturity and reward';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        dispatch(new StakingCommandJob);
    }
}
