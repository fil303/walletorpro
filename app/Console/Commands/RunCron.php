<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run_cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command Run Some Other Command';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->comment("schedule and queue run command start");
        Artisan::call('queue:restart');
        Artisan::call('schedule:run');
        Artisan::call('queue:work --queue=default,high --timeout=100000 --tries=5');
    }
}
