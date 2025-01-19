<?php

namespace Database\Seeders;

use App\Models\Coin;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Services\CoinService\CoinService;
use App\Http\Controllers\Admin\CoinController;
use App\Http\Requests\Admin\AddCurrencyRequest;

class CryptoCoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->factorySeeder();
        $this->defaultCoins();
    }

    public function factorySeeder()
    {
        $faker = Faker::create();

        foreach(range(0, 30) as $d){
            $request = new AddCurrencyRequest();
            $request->merge([
                "name"     => $faker->name,
                "code"     => substr($faker->name, 0, 3),
                "coin"     => substr($faker->name, 0, 3),
                "type"     => "c",
                "rate"     => $faker->randomDigit(),
                "symbol"   => substr($faker->name, 0, 1),
                "provider" => "coin_payment",
                "decimal"  => 18
            ]);

            (new CoinController(new CoinService()))->coinSave($request);
        }
    }

    public function defaultCoins()
    {
        $coins = [
            [
                "name"     => "Bitcoin",
                "code"     => "BTC",
                "coin"     => "BTC",
                "type"     => "c",
                "rate"     => "600000",
                "symbol"   => "B",
                "provider" => "coin_payment",
                "decimal"  => 8
            ],
            [
                "name"     => "USD Coin",
                "code"     => "USDT",
                "coin"     => "USDT",
                "type"     => "c",
                "rate"     => "1",
                "symbol"   => "U",
                "provider" => "coin_payment",
                "decimal"  => 6
            ],
        ];
        if(! Coin::first()){
            foreach($coins as $coin){
                $request = new AddCurrencyRequest();
                $request->merge($coin);
                (new CoinController(new CoinService()))->coinSave($request);
            }
        }
    }
}
