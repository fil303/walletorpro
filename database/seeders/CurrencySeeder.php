<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies_row = file_get_contents(
            storage_path('/currency.json')
        );
        $currencies = json_decode($currencies_row,true);
        
        foreach ($currencies as $currency) {
            Currency::updateOrCreate(
                [
                    "code" => $currency['code'],
                ],[
                    "name" => $currency['name'],
                    "symbol" => $currency['symbol'],
                    "status" => $currency['code'] == "USD" ? 1 : 0
                ]
            );
        }
    }
}
