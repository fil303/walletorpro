<?php

namespace App\Models;

use App\Models\Coin;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoinExchange extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'from_coin_id',
        'to_coin_id',
        'from_coin',
        'to_coin',
        'fee',
        'rate',
        'from_amount',
        'to_amount',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function f_coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class, "from_coin_id");
    }
    public function t_coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class, "to_coin_id");
    }
}
