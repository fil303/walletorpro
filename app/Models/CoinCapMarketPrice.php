<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinCapMarketPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        "coin_id",
        "coin_name",
        "coin_code",
        "coin_rank",
        "coin_price",
        "is_fiat",
        "token_address",
        "change_24h",
        "volume"
    ];
}
