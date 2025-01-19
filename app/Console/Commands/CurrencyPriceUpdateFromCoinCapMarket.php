<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CurrencyPriceUpdateFromCoinCapMarket as CurrencyPriceUpdateFromCoinCapMarketJob;

class CurrencyPriceUpdateFromCoinCapMarket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:currency-price-update-from-coin-cap-market';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update currency price from coin cap market';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        dispatch(new CurrencyPriceUpdateFromCoinCapMarketJob);
    }
}
