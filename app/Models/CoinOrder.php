<?php

namespace App\Models;

use App\Models\Coin;
use App\Models\User;
use App\Models\PaymentGateway;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoinOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        "uid",
        "user_id",
        "wallet_id",
        "coin_id",
        "currency_id",
        "payment_id",
        "coin",
        "coin_code",
        "currency_code",
        "payment_slug",
        "rate",
        "amount",
        "fees",
        "net_price",
        "total_price",
        "status",
        "transaction_id"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }
    public function payment(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class, "payment_id");
    }
    public function coin_table(): BelongsTo
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }
}
