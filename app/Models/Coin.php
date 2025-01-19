<?php

namespace App\Models;

use App\Enums\Status;
use App\Models\Wallet;
use App\Enums\FeesType;
use App\Enums\CurrencyType;
use App\Enums\CryptoProvider;
use App\Enums\FileDestination;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coin extends Model
{
    use HasFactory;
    protected $fillable = [
        "uid", "provider", "coin", "name", "code", "coin", "symbol", 
        "has_network", "network", "icon", "type", "rate", "decimal",
        "status", "fee" ,"fee_type" ,"exchange_status" ,"buy_status",
        "withdrawal_status" ,"withdrawal_min" ,"withdrawal_max",
        "exchange_fees", "exchange_fees_type", "withdrawal_fees",
        "withdrawal_fees_type", "print_decimal"
    ];

    /**
     * Casts db value to original type
     * @var array<string, string>
     */
    protected $casts = [
        "provider"    => CryptoProvider::class,
        'has_network' => 'boolean',
    ];

    /**
     * Scope for active coins
     * @param \Illuminate\Contracts\Database\Eloquent\Builder $builder
     * @param \App\Enums\CurrencyType $currency
     * @return Builder
     */
    public function scopeActiveCoins(Builder $builder, CurrencyType $currency): Builder
    {
        return
            $this->query()
            ->when(filled($currency), function ($q) use ($currency){
                /** @var CurrencyType $currency */
                return $q->where("type", $currency->value);
            })
            ->where('status', Status::ENABLE->value);
    }

    /**
     * Get Coin Icon
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon
            ? asset_bind(Storage::url($this->icon))
            : asset_bind(Storage::url("coin/icon.png"));
    }

    /**
     * Wallet relation from coin model
     * @return mixed
     */
    public function wallet():mixed
    {
        return $this->belongsTo(Wallet::class, "coin", "coin");
    }
}
