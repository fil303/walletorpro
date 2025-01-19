<?php

namespace Database\Seeders;

use App\Models\Wallet;
use App\Facades\UserFacade;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(! Wallet::first()){
            UserFacade::updateUserWallets();
        }
    }
}
