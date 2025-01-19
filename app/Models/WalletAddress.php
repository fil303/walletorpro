<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        "uid",
        "user_id",
        "wallet_id",
        "address",
        "coin_id",
        "coin",
        "code",
        "memo"
    ];

    public function scopeGetWalletAddress(Builder $builder, int $wallet_id, string $coin_code): Builder|QueryBuilder
    {
        return $builder->where([
            "user_id"=> Auth::id(),
            "wallet_id" => $wallet_id,
            "code" => $coin_code
        ]);
    }
}
