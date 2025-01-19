<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\FaqSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\WalletSeeder;
use Database\Seeders\GatewaySeeder;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\CryptoCoinSeeder;
use Database\Seeders\SiteSettingSeeder;
use Database\Seeders\LandingSettingSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(SiteSettingSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CryptoCoinSeeder::class);
        $this->call(WalletSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(GatewaySeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(LandingSettingSeeder::class);
    }
}
