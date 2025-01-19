<?php

namespace App\Models;

use App\Models\Coin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Wallet model
 * 
 * @property int $id
 */
class Wallet extends Model
{
    use HasFactory;
    protected $fillable = [
        "uid",
        "coin_id",
        "user_id",
        "coin",
        "balance",
    ];

    public function address(): HasOne
    {
        return $this->hasOne(WalletAddress::class, "wallet_id");
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function coin_table(): BelongsTo
    {
        return $this->belongsTo(Coin::class, "coin", "coin");
    }
    public function coin_parent_table(): HasOne
    {
        return $this->hasOne(Coin::class, 'id', 'coin_id');
    }
}
