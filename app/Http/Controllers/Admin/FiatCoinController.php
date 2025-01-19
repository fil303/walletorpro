<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FiatCoinController extends Controller
{
    /**
     * Get Fiat Coin Page
     * @return mixed
     */
    public function fiatCoinPage(): mixed
    {
        return view("admin.coins.fiat.coins");
    }
}
