<?php

namespace App\Models;

use App\Models\Coin;
use App\Models\User;
use App\Enums\TransactionType;
use App\Enums\WithdrawalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdrawal extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "coin_id",
        "wallet_id",
        "type",
        "coin",
        "fees",
        "code",
        "amount",
        "to_address",
        "trx",
        "status",
    ];

    /**
     * Casts db value to original type
     * @var array<string, string>
     */
    protected $casts = [
        "status" => WithdrawalStatus::class,
        "type"   => TransactionType::class,
    ];

    /**
     * User Relation from withdrawal model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Coin Relation from withdrawal model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coin_table(): BelongsTo
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }
}
