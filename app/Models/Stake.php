<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stake extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "coin_id",
        "stake_plan_id",
        "stake_segment_id",
        "coin",
        "duration",
        "interest",
        "amount",
        "interest_amount",
        "auto_stake",
        "status",
        "end_at"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function plan_coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class, "coin_id");
    }
}
