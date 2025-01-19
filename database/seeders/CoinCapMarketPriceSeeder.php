<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoinCapMarketPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoinCapMarketPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(! CoinCapMarketPrice::first()){
            $btcData = [
                "coin_id"       => 1,
                "coin_name"     => 'Bitcoin',
                "coin_code"     => 'BTC',
                "coin_rank"     => 1,
                "coin_price"    => '60000',
                "is_fiat"       => 0,
                "token_address" => NULL,
                "change_24h"    => '0.72',
                "volume"        => '42668645951',
            ];
            CoinCapMarketPrice::create($btcData);
            
            $usdtData = [
                "coin_id"       => 2,
                "coin_name"     => 'Tether (USDT)',
                "coin_code"     => 'USDT',
                "coin_rank"     => 2,
                "coin_price"    => '1',
                "is_fiat"       => 0,
                "token_address" => NULL,
                "change_24h"    => '0.00',
                "volume"        => '130397293330',
            ];
            CoinCapMarketPrice::create($usdtData);
        }
    }
}
