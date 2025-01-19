<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyCryptoTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        "receive_coin_id",
        "spend_coin_id",
        "receive_coin",
        "spend_coin",
        "amount",
        "spend_amount",
        "fees",
        "rate",
        "status",
    ];
}
