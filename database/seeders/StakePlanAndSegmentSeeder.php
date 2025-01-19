<?php

namespace Database\Seeders;

use App\Models\Coin;
use App\Models\StakePlan;
use App\Enums\CurrencyType;
use App\Models\StakeSegment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Collection;

class StakePlanAndSegmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var Collection $coins */
        $coins = Coin::activeCoins(CurrencyType::CRYPTO)->get();
        $coinCount = count($coins) - 1;

        foreach (range(0,99) as $i) {
            $coin = $coins[rand(0, $coinCount)];
            $stake = StakePlan::create([
                "coin_id" => $coin->id,
                "coin"    => $coin->coin,
                "min"     => rand(1, 50),
                "max"     => rand(51, 100),
                "status"  => true,
            ]);
            foreach (range(0,rand(1,5)) as $k) {
                StakeSegment::create([
                    "stake_plan_id" => $stake->id,
                    "duration"      => rand(1,20),
                    "interest"      => rand(1,20),
                ]);
            }
        }
    }
}
