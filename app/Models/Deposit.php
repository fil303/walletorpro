<?php

namespace App\Models;

use App\Models\User;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deposit extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "coin_id",
        "wallet_id",
        "type",
        "coin",
        "code",
        "amount",
        "trx",
        "from_address",
        "status",
    ];

    /**
     * Casts db value to original type
     * @var array<string, string>
     */
    protected $casts = [
        "type" => TransactionType::class,
    ];

    /**
     * User Relation from deposit model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function coin_table(): BelongsTo
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }
}
